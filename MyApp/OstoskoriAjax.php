<?php
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

if(isset($_POST['add']))
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
else if(isset($_POST['update']))
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
?>
