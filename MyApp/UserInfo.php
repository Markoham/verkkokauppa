<?php
namespace MyApp;

class UserInfo extends \MyApp\Database
{
    private $_user = false;
    private $_salt1, $_salt2;
    private $_asiakas;
    private $_sessionprefix;
    
    function __construct($path = "", $asiakas = true)
    {
        parent::__construct($path);
        $this->init($path);
        $this->_asiakas = $asiakas;
        
        if($asiakas) $this->_sessionprefix = "asiakas";
        else $this->_sessionprefix = "hallinta";
        
        $this->isLoggedIn();
        
        if(isset($_GET['logout']) && $this->_user)
        {
            $this->logout();
            header("Location: ?logout");
        }
    }
    
    // Hakee asetukset ja yhdistää tietokantaan
    function init($path = "")
    {
        if (!is_file($path . "../settings.php")) die("Settings file is missing...");
        require($path . "../settings.php");
        
        $this->_salt1 = $salt1;
        $this->_salt2 = $salt2;
    }
    
    // tarkistaa onko käyttäjä kirjautuneena
    function isLoggedIn()
    {
        if(isset($_SESSION[$this->_sessionprefix . 'id']))
        {
            if($this->_asiakas)
                $this->_user = $this->_db->getAsiakas($_SESSION[$this->_sessionprefix . 'id']);
            else
                $this->_user = $this->_db->getTyontekija($_SESSION[$this->_sessionprefix . 'id']);
            
            if($_SESSION[$this->_sessionprefix . 'hash'] != $this->createHash($this->_user->getEtunimi() . $this->_user->getSukunimi() . $this->_user->getId() . $_SESSION[$this->_sessionprefix . 'loggedin']))
            {
                $this->_user = false;
            }
        }
    }
    
    // Palauttaa sha512 tiivisteen
    function createHash($value)
    {
        return hash("sha512", $value);
    }
    
    // palauttaa sha512 salasana tiivisteen
    function createPasswordHash($value)
    {
        return hash("sha512", $this->_salt1 . $value . $this->_salt2);
    }
    
    // Palauttaa kirjautuneen asiakkaan
    function getUser()
    {
        return $this->_user;
    }
    
    // uloskirjautuminen
    function logout()
    {
        session_destroy();
    }
    
    // Tarkistaa että käyttäjälöytyy ja asettaa sen jälkeen kirjautuneeksi
    function checkLogin($email, $salasana)
    {
        if($this->_asiakas)
            $user = $this->_db->getAsiakasByEmail($email);
        else
            $user = $this->_db->getTyontekijaByEmail($email);
        
        if(isset($user) && $user->getSalasana() == $this->createPasswordHash($salasana))
        {
            $this->_user = $user;
            $timestamp = time();
            $_SESSION[$this->_sessionprefix . 'loggedin'] = $timestamp;
            $_SESSION[$this->_sessionprefix . 'id'] = $user->getId();
            $_SESSION[$this->_sessionprefix . 'hash'] = $this->createHash($user->getEtunimi() . $user->getSukunimi() . $user->getId() . $timestamp);
            
            return $user;
        }
        
        return false;
    }

    // Sähköposti osoitteen tarkistus
    function validEmail($email)
    {
        require_once('Validate.php');

        if (@\Validate::email($email, array('check_domain' => 'true','use_rfc822' => true))) {
            return true;
        } else {
            return false;
        }
    }
}
?>
