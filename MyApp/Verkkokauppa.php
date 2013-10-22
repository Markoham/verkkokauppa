<?php
namespace MyApp;

class Verkkokauppa
{
    private $_db, $_theme;
    private $_root= "/teht/verkkokauppa/";
    
    function __construct()
    {
        require_once("../settings.php");
        
        if(isset($theme))
            $this->_theme = $theme;
        else
            $this->_theme = "Default";
        
        $this->_db = new Database\DatabaseHandler();
        $this->_db->setHost($host);
        $this->_db->setUsername($username);
        $this->_db->setPassword($password);
        $this->_db->setDatabase($database);
        $this->_db->setPrefix($database_prefix);
        $this->_db->connect();
    }
    
    function importExtralibs()
    {
        echo "<link rel=\"stylesheet\" href=\"" . $this->_root . "MyApp/Themes/extralib/unsemantic/css/unsemantic-grid-responsive.css\" />\n";
        echo "<link rel=\"stylesheet\" href=\"" . $this->_root . "MyApp/Themes/extralib/bootstrap/css/bootstrap.min.css\" />\n";
        echo "<script type=\"text/javascript\" href=\"" . $this->_root . "MyApp/Themes/extralib/bootstrap/js/bootstrap.min.js\"></script>\n";
    }
    
    function getThemeUrlPath()
    {
        return $this->_root . $this->getThemePath();
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
        if(isset($_GET['cat']))
        {
            include($this->getThemepath() . "tuotelista.php");
        }
        else if(isset($_GET['login']))
        {
            include($this->getThemepath() . "login.php");
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
    
    function getTuotteet()
    {
        echo "<table id=\"tuotelista\">";
        $tuotteet = $this->_db->getTuotteet($_GET['cat']);
        for($i = 0, $c = count($tuotteet); $i < $c; $i++)
        {
            echo "<tr><td>" . $tuotteet[$i]->getId() . "</td><td>" . $tuotteet[$i]->getTuotteennimi() . "</td><td>" . $tuotteet[$i]->getHinta() . "</td><td>Lisää koriin</td></tr>";
        }
        echo "</table>";
    }
    
    function getKategoriat()
    {
        echo "<ul>";
        $categorylist = $this->_db->getCategorys();
        for($i = 0, $c = count($categorylist); $i < $c; $i++)
        {
            echo "<li><a class=\"paakategoria\" href=\"#" . $categorylist[$i]->getKategoria() . "\">" . $categorylist[$i]->getKategoria() . "</a></li>";
            if(count($categorylist[$i]->getAlakategoriat()) > 0)
            {
                echo "<ul class=\"alakategoria " . $categorylist[$i]->getKategoria() . "\">";
                $alacategorylist = $categorylist[$i]->getAlakategoriat();
                for($j = 0, $n = count($alacategorylist); $j < $n; $j++)
                {
                    echo "<li><a href=\"?cat=" . $alacategorylist[$j]->getId(). "\">" . $alacategorylist[$j]->getKategoria() . "</a></li>";
                }
                echo "</ul>";
            }
        }
        echo "</ul>";
    }
}
?>