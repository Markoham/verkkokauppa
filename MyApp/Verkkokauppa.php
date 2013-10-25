<?php
namespace MyApp;

class Verkkokauppa
{
    private $_db, $_theme, $_asiakas = false;
    private $_root= "/teht/verkkokauppa/";
    private $_salt1, $_salt2;
    
    function __construct()
    {
        require_once("../settings.php");
        
        if(isset($theme))
            $this->_theme = $theme;
        else
            $this->_theme = "Default";
        
        $this->_salt1 = $salt1;
        $this->_salt2 = $salt2;
        
        $this->_db = new Database\DatabaseHandler();
        $this->_db->setHost($host);
        $this->_db->setUsername($username);
        $this->_db->setPassword($password);
        $this->_db->setDatabase($database);
        $this->_db->setPrefix($database_prefix);
        $this->_db->connect();
        
        $this->isLoggedIn();
        
        if(isset($_GET['logout']) && $this->_asiakas)
        {
            $this->logout();
            header("Location: ?logout");
        }
    }
    
    function importExtralibs()
    {
        echo "<link rel=\"stylesheet\" href=\"" . $this->_root . "MyApp/Themes/extralib/unsemantic/css/unsemantic-grid-responsive.css\" />\n";
        echo "<link rel=\"stylesheet\" href=\"" . $this->_root . "MyApp/Themes/extralib/bootstrap/css/bootstrap.min.css\" />\n";
        //echo "<script src=\"" . $this->_root . "MyApp/Themes/extralib/bootstrap/js/bootstrap.min.js\"></script>\n";
    }
    
    function isLoggedIn()
    {
        if(isset($_SESSION['id']))
        {
            $this->_asiakas = $this->_db->getAsiakas($_SESSION['id']);
            
            if($_SESSION['hash'] != $this->createHash($this->_asiakas->getEtunimi() . $this->_asiakas->getSukunimi() . $this->_asiakas->getId() . $_SESSION['loggedin']))
            {
                $this->_asiakas = false;
            }
        }
    }
    
    function createHash($value)
    {
        return hash("sha512", $value);
    }
    
    function createPasswordHash($value)
    {
        return hash("sha512", $this->_salt1 . $value . $this->_salt2);
    }
    
    function getUser()
    {
        return $this->_asiakas;
    }
    
    function logout()
    {
        session_destroy();
    }
    
    function checkLogin($email, $salasana)
    {
        $asiakas = $this->_db->getAsiakasByEmail($email);
        
        if($asiakas->getSalasana() == $this->createPasswordHash($salasana))
        {
            $this->_asiakas = $asiakas;
            $timestamp = time();
            $_SESSION['loggedin'] = $timestamp;
            $_SESSION['id'] = $asiakas->getId();
            $_SESSION['hash'] = $this->createHash($asiakas->getEtunimi() . $asiakas->getSukunimi() . $asiakas->getId() . $timestamp);
            
            return $asiakas;
        }
        
        return false;
    }
    
    function sendLostPassword($email)
    {
         $asiakas = $this->_db->getAsiakasByEmail($email);
    }
    
    function addUser($etunimi, $sukunimi, $email, $salasana)
    {
        if($this->_db->getAsiakasByEmail($email))
            return -1;
        
        $id = $this->_db->addAsiakas($etunimi, $sukunimi, $email, $this->createPasswordHash($salasana));
        $this->checkLogin($email, $salasana);
        return $id;
    }
    
    function getThemeUrlPath()
    {
        return $this->_root . $this->getThemePath();
    }
    
    function cleanInput($array, $key, $type = "string")
    {
        return $array[$key];
    }
    
    function getThemepath()
    {
        return "MyApp/Themes/" . $this->_theme . "/";
    }
    
    function getBasePath()
    {
        return "/teht/verkkokauppa/";
    }
    
    function getPageContent()
    {
        global $framework;
        if(isset($_GET['product']))
        {
            include($this->getThemepath() . "tuote.php");
        }
        else if(isset($_GET['cat']))
        {
            include($this->getThemepath() . "tuotelista.php");
        }
        else if(isset($_GET['login']))
        {
            include($this->getThemepath() . "login.php");
        }
        else if(isset($_GET['lostpassword']))
        {
            include($this->getThemepath() . "lostpassword.php");
        }
        else if(isset($_GET['register']))
        {
            include($this->getThemepath() . "register.php");
        }
        else if(isset($_GET['logout']))
        {
            include($this->getThemepath() . "logout.php");
        }
        else
        {
            include($this->getThemepath() . "main.php");
        }
    }
    
    function getNav()
    {
        global $framework;
        
        include($this->getThemepath() . "nav.php");
    }
    
    function getTuote($tuote = null)
    {
        if(!$tuote)
            $tuote = $this->cleanInput($_GET, 'product');
        
        return $this->_db->getTuote($tuote);
    }
    
    function getVarastoSaldo($id)
    {
        return $this->_db->getVarastosaldo($id);
    }
    
    function getTuotteet()
    {
        return $this->_db->getTuotteet($this->cleanInput($_GET, 'cat'));
    }
    
    function getKategoriat()
    {
        return $this->_db->getCategorys();
    }
}
?>