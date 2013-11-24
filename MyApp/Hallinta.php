<?php
namespace MyApp;

class Hallinta extends \MyApp\UserInfo
{
    private $_root= "/teht/verkkokauppa/hallinta/";
    
    function __construct()
    {
        parent::__construct("../", false);
        require("../../settings.php");

        $this->_root = $installfolder;
    }
    
    function importExtralibs()
    {
        echo "<link rel=\"stylesheet\" href=\"" . $this->_root . "MyApp/Themes/extralib/unsemantic/css/unsemantic-grid-responsive.css\" />\n";
        echo "<link rel=\"stylesheet\" href=\"" . $this->_root . "MyApp/Themes/extralib/bootstrap/css/bootstrap.min.css\" />\n";
    }
    
    // Palauttaa juurihakemiston
    function getBasePath()
    {
        return $this->_root;
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
