<?php
    session_start();
	// Cachen esto
    error_reporting(E_ALL);
    ini_set('display_errors','On');

    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    if(@$_SERVER["HTTPS"] != "on")
        header("location: https://".$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]);

    spl_autoload_register(function($class) {
        $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

        if (is_file($file)) {
            include $file;
        }
    });


    $framework = new \MyApp\Verkkokauppa();

    if(isset($_GET["product"]))
    {
        $tuote = $framework->getTuote($_GET["product"]);

        if($tuote->getMimetype())
        {
            header("Content-type: " . $tuote->getMimetype());
            echo $tuote->getKuva();
        }
        else
        {
            header("Content-type: " . mime_content_type("tuotekuvat/default.jpg"));
            readfile("tuotekuvat/default.jpg");
        }
    }

?>
