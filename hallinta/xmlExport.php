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
        $file = "../" . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    
        if (is_file($file)) {
            include $file;
        }
    });

    $framework = new \MyApp\Hallinta();
    
    if($framework->getUser())
    {
        header("Content-type: text/xml");
        header("Content-Disposition:attachment;filename=products.xml");
        
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
        $tuotteet = $framework->getTuotteet();
        echo "\n<products>\n";
        for($i = 0, $c = count($tuotteet); $i < $c; $i++)
        {
            $cats = $framework->getTuotteenkategoriat($tuotteet[$i]->getId());
            
            echo "\t<product id=\"" . $tuotteet[$i]->getId() . "\" action=\"none\">\n";
            echo "\t\t<name>" . $tuotteet[$i]->getTuotteennimi() . "</name>\n";
            echo "\t\t<price>" . $tuotteet[$i]->getHinta() . "</price>\n";
            echo "\t\t<description>" . $tuotteet[$i]->getKuvaus() . "</description>\n";
            echo "\t\t<categories>\n";
            for($j = 0, $k = count($cats); $j < $k; $j++)
            {
                echo "\t\t\t<category id=\"" . $cats[$j]->getId() . "\" action=\"none\" />\n";
            }
            echo "\t\t</categories>\n";
            echo "\t</product>\n";
        }
        echo "</products>\n";
    }
    else
    {
        echo "No user logged!";
    }
?>