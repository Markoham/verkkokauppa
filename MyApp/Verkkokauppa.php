<?php
namespace MyApp;

class Verkkokauppa
{
    private $_db, $_theme, $_user;
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
        //echo "<script src=\"" . $this->_root . "MyApp/Themes/extralib/bootstrap/js/bootstrap.min.js\"></script>\n";
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
        else if(isset($_GET['logout']))
        {
            include($this->getThemepath() . "logout.php");
        }
        else
        {
            include($this->getThemepath() . "main.php");
        }
    }
    
    function getTuote()
    {
    }
    
    function getTuotteet()
    {
        echo "<table id=\"tuotelista\" class=\"table\">";
        echo "<thead><tr><th class=\"product\">Tuote</th><th class=\"price\">Hinta</th><th class=\"shoppingcart\"></th></tr></thead><tbody>";
        $tuotteet = $this->_db->getTuotteet($_GET['cat']);
        for($i = 0, $c = count($tuotteet); $i < $c; $i++)
        {
            echo "<tr><td class=\"product\"><p><a href=\"?cat=" . $_GET['cat'] . "&amp;product=" . $tuotteet[$i]->getId() . "\">" . $tuotteet[$i]->getTuotteennimi() . "</a></p><p>" . $tuotteet[$i]->getKuvaus() . "</p></td><td class=\"price\">" . str_replace(".",",", $tuotteet[$i]->getHinta()) . " &euro;</span></td><td class=\"shoppingcart\"><button type=\"button\" class=\"btn btn-primary\"><span class=\"glyphicon glyphicon-plus\"></span> Lisää koriin</td></button></tr>";
        }
        echo "</tbody></table>";
    }
    
    function getKategoriat()
    {
        echo "<ul>";
        echo "<li class=\"navitem\"><a href=\"" . $this->getBasePath() . "\"><span class=\"glyphicon glyphicon-home\"></span> Etusivu</a></li>";
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
                    echo "<li><a " . (@$_GET['cat'] == $alacategorylist[$j]->getId() ? "class=\"active\" " : "") . "href=\"?cat=" . $alacategorylist[$j]->getId() . "\">" . $alacategorylist[$j]->getKategoria() . "</a></li>";
                }
                echo "</ul>";
            }
        }
        if($this->_user)
            echo "<li class=\"navitem\"><a " . (isset($_GET['logout']) ? "class=\"active\" " : "") . "href=\"" . $this->getBasePath() . "?logout\"><span class=\"glyphicon glyphicon-log-out\"></span> Kirjaudu ulos</a></li>";
        else
            echo "<li class=\"navitem\"><a " . (isset($_GET['login']) ? "class=\"active\" " : "") . "href=\"" . $this->getBasePath() . "?login\"><span class=\"glyphicon glyphicon-log-in\"></span> Kirjaudu sisään</a></li>";
        echo "</ul>";
    }
}
?>