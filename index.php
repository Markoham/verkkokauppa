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

function genJSON($ostoskori)
{
    global $framework;
    echo '{"ostoskori": [';
    $tuotteet = $ostoskori->getTuotteet();
    $i = 0;
    $c = count($tuotteet);
    foreach($tuotteet as $ostoskorituote)
    {
        $tuote = $framework->getTuote($ostoskorituote->getTuoteId());
        echo '{"tuote": "' . $tuote->getTuotteennimi() . '", "maara":"' . $ostoskorituote->getMaara() . '", "hinta": "' . $tuote->getHinta() . '", "hintayht": "' . ($ostoskorituote->getMaara() * $tuote->getHinta()) . '"}';
        if($i < ($c-1)) echo ',';
        $i++;
    }
    echo '] }';
}

if(isset($_POST['ostoskori']) && isset($_POST['add']))
{
    if(!isset($_SESSION['ostoskori']))
        $ostoskori = new \MyApp\DataObjects\Ostoskori();
    else
        $ostoskori = unserialize($_SESSION['ostoskori']);
    
    $tuote = $framework->getTuote($_POST['add']);
    
    if($tuote)
    {
        $ostoskorituote = new \MyApp\DataObjects\OstoskoriTuote();
        $ostoskorituote->setTuoteId($tuote->getId());
        $ostoskorituote->setMaara(1);
        
        $ostoskori->addTuote($ostoskorituote);
        $_SESSION['ostoskori'] = serialize($ostoskori);
    }
    
    genJSON($ostoskori);
}
else if(isset($_POST['ostoskori']) && isset($_POST['update']))
{
    $ostoskori = unserialize($_SESSION['ostoskori']);
    
    $tuote = $_POST['update'];
    $maara = $_POST['quantity'];
    
    $ostoskorituote = $ostoskori->getTuotteet()[$tuote];
    
    if($ostoskorituote)
    {
        $ostoskorituote->setMaara($maara);        
        $ostoskori->updateTuote($ostoskorituote);
        
        $_SESSION['ostoskori'] = serialize($ostoskori);
    }
    
    genJSON($ostoskori);
}
else
{
    if(!is_file($framework->getThemepath() . "index.php")) die("Theme file missing...");
    include($framework->getThemepath() . "index.php");
}

ob_end_flush();
// http://www.ohjelmointiputka.net/keskustelu/26544-oman-funktiokirjaston-rakentaminen/sivu-1
?>