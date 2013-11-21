<?php
namespace MyApp;

class Hallinta extends \MyApp\UserInfo
{
    private $_root= "/teht/verkkokauppa/hallinta/";
    
    function __construct()
    {
        parent::__construct("../", false);
    }
    
    function importExtralibs()
    {
        echo "<link rel=\"stylesheet\" href=\"" . $this->_root . "../MyApp/Themes/extralib/unsemantic/css/unsemantic-grid-responsive.css\" />\n";
        echo "<link rel=\"stylesheet\" href=\"" . $this->_root . "../MyApp/Themes/extralib/bootstrap/css/bootstrap.min.css\" />\n";
        //echo "<script src=\"" . $this->_root . "MyApp/Themes/extralib/bootstrap/js/bootstrap.min.js\"></script>\n";
    }
    
    // Palauttaa juurihakemiston
    function getBasePath()
    {
        return "/teht/verkkokauppa/";
    }
    
    // Hakee tuotteen kuvan
    function getProductImage($product)
    {
        $image = $this->getBasePath() . "tuotekuvat/" . $product . ".jpg";
        if(is_file($image))
            return image;
        else
            return $this->getBasePath() . "tuotekuvat/default_thumb.jpg";
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
    
    function getServerUrl()
    {
        return "http" . (@$_SERVER["HTTPS"] == "on" ? "s" : "") . "://".str_replace("&","&amp;",@$_SERVER[HTTP_HOST]);
    }
    
    function getCurrentUrl()
    {
        return "http" . (@$_SERVER["HTTPS"] == "on" ? "s" : "") . "://".str_replace("&","&amp;",@$_SERVER[HTTP_HOST] . @$_SERVER[REQUEST_URI]);
    }

    function getCurrentUrlNoAmp()
    {
        return "http" . (@$_SERVER["HTTPS"] == "on" ? "s" : "") . "://".@$_SERVER[HTTP_HOST] . @$_SERVER[REQUEST_URI];
    }
}
?>
