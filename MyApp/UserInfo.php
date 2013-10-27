<?php
namespace MyApp;

class UserInfo extends \MyApp\Database
{
    private $_user = false;
    private $_salt1, $_salt2;
    
    function __construct($path = "", $asiakas = true)
    {
        parent::__construct($path);
        $this->init($path);
        
        $this->isLoggedIn($asiakas);
        
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
    function isLoggedIn($asiakas)
    {
        if(isset($_SESSION['id']))
        {
            if($asiakas)
            {
                $this->_user = $this->_db->getAsiakas($_SESSION['id']);
            
                if($_SESSION['hash'] != $this->createHash($this->_user->getEtunimi() . $this->_user->getSukunimi() . $this->_user->getId() . $_SESSION['loggedin']))
                {
                    $this->_user = false;
                }
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
    
    // Tarkistaa että käyttäjälöytyy ja asettaa sen jälkeen kirjautuneeksi
    function checkLogin($email, $salasana)
    {
        $user = $this->_db->getAsiakasByEmail($email);
        
        if(isset($user) && $user->getSalasana() == $this->createPasswordHash($salasana))
        {
            $this->_user = $user;
            $timestamp = time();
            $_SESSION['loggedin'] = $timestamp;
            $_SESSION['id'] = $user->getId();
            $_SESSION['hash'] = $this->createHash($user->getEtunimi() . $user->getSukunimi() . $user->getId() . $timestamp);
            
            return $user;
        }
        
        return false;
    }
}
?>