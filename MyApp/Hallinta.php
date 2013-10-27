<?php
namespace MyApp;

class Hallinta extends \MyApp\UserInfo
{
    private $_root= "/teht/verkkokauppa/hallinta";
    
    function __construct()
    {
        parent::__construct("../", false);
    }
}
?>