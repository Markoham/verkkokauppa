<?php
session_start();
ob_start();
error_reporting(E_ALL);
ini_set('display_errors','On');

if(@$_SERVER["HTTPS"] != "on")
    header("location: https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
spl_autoload_register(function($class) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

    // NOTE: Ladataan tiedosto vain, jos se on olemassa. Mikäli tiedostoa ei löydy,
    // ei tehdä mitään, koska sovelluksessa voi olla useita autoloadereita,
    // joista jokin myöhemmin triggeröitävä osaa ladata luokan.
    if (is_file($file)) {
        include $file;
    }
});

$framework = new \MyApp\Verkkokauppa();

if(isset($_POST['ostoskori']))
{
    include("MyApp/OstoskoriAjax.php");
}
else
{
    if(!is_file($framework->getThemepath() . "index.php")) die("Theme file missing...");
    include($framework->getThemepath() . "index.php");
}

ob_end_flush();
// http://www.ohjelmointiputka.net/keskustelu/26544-oman-funktiokirjaston-rakentaminen/sivu-1
?>
