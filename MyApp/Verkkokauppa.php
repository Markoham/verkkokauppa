<?php
namespace MyApp;

class Verkkokauppa extends \MyApp\UserInfo
{
    private $_theme, $_root= "/teht/verkkokauppa/";

    function __construct()
    {
        parent::__construct();

        if (!is_file("../settings.php")) die("Settings file is missing...");
        require("../settings.php");

        $this->_root = $installfolder;

        if(isset($theme))
            $this->_theme = $theme;
        else
            $this->_theme = "Default";
    }

    //
    function importExtralibs()
    {
        echo "<link rel=\"stylesheet\" href=\"" . $this->_root . "MyApp/Themes/extralib/unsemantic/css/unsemantic-grid-responsive.css\" />\n";
        echo "<link rel=\"stylesheet\" href=\"" . $this->_root . "MyApp/Themes/extralib/font-awesome/css/font-awesome.min.css\">
";
        //echo "<link rel=\"stylesheet\" href=\"" . $this->_root . "MyApp/Themes/extralib/bootstrap/css/bootstrap.min.css\" />\n";
        //echo "<script src=\"" . $this->_root . "MyApp/Themes/extralib/bootstrap/js/bootstrap.min.js\"></script>\n";
    }

    // Tyhjentää ostoskorin
    function clearOstoskori()
    {
        unset($_SESSION['ostoskori']);
    }

    // Palauttaa ostoskorin
    function getOstoskori()
    {
        return (isset($_SESSION['ostoskori']) ? unserialize($_SESSION['ostoskori']) : null);
    }

    // Hakee tuotteen kuvan
    function getProductImage($product)
    {
        $image = $this->getBasePath() . "tuotekuvat/" . $product . ".jpg";
        if(is_file($image))
            return image;
        else
            return $this->getBasePath() . "tuotekuvat/img/default.jpg";
    }

    // Hakee tuotteen pienen kuvan
    function getProductThumbImage($product)
    {
        $image = $this->getBasePath() . "tuotekuvat/" . $product . "_thumb.jpg";
        if(is_file($image))
            return image;
        else
            return $this->getBasePath() . "tuotekuvat/default_thumb.jpg";
    }

    // Teeman osoite
    function getThemeUrlPath()
    {
        return $this->_root . $this->getThemePath();
    }

    // Palauttaa Teeman osoitteen
    function getThemepath()
    {
        return "MyApp/Themes/" . $this->_theme . "/";
    }

    // Palauttaa juurihakemiston
    function getBasePath()
    {
        return $this->_root;
    }

    // Hakee sivuston sisällön
    function getPageContent()
    {
        $framework = $this;
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
        else if(isset($_GET['ostoskori']))
        {
            include($this->getThemepath() . "ostoskori.php");
        }
        else if(isset($_GET['order']))
        {
            include($this->getThemepath() . "tilaus.php");
        }
        else if(isset($_GET['userinfo']))
        {
            include($this->getThemepath() . "userinfo.php");
        }
        else if(isset($_GET['search']))
        {
            include($this->getThemepath() . "search.php");
        }
        else
        {
            include($this->getThemepath() . "main.php");
        }
    }

    // Palauttaa navin
    function getNav()
    {
        $framework = $this;

        include($this->getThemepath() . "nav.php");
    }

    function updateOstoskoriQuantity($tuoteId, $quantity)
    {
        $ostoskori = unserialize($_SESSION['ostoskori']);

        $ostoskorituote = $ostoskori->getTuotteet()[$tuoteId];

        if($ostoskorituote)
        {
            $ostoskorituote->setMaara($quantity);
            $ostoskori->updateTuote($ostoskorituote);

            $_SESSION['ostoskori'] = serialize($ostoskori);
        }
    }
}
?>
