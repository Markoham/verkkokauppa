<?php

if(isset($_GET['tyhjenna']))
{
    $framework->clearOstoskori();
    header("location: ?ostoskori");
}

$ostoskori = $framework->getOstoskori();
if($ostoskori)
    $tuotteet = $ostoskori->getTuotteet();

if(isset($_GET['update']))
{
    foreach($tuotteet as $ostoskoriTuote)
    {
        $framework->updateOstoskoriQuantity($ostoskoriTuote->getTuoteId(), $_POST['product_' . $ostoskoriTuote->getTuoteId()]);
    }
    header("location: ?ostoskori");
}

$totalprice = 0.0;
if(!isset($tuotteet) || count($tuotteet) == 0)
    echo "<h3>Ei tuotteita</h3>";
else
{
    echo "<form action=\"?ostoskori&update\" method=\"post\"><table id=\"ostoskori\" class=\"table\">";
    echo "<thead><tr><th class=\"picture\">Kuva</th><th class=\"product\">Tuote</th><th class=\"price\" colspan=\"2\">Total</th></tr></thead><tbody>";
    foreach($tuotteet as $ostoskoriTuote)
    {
        $tuote = $framework->getTuote($ostoskoriTuote->getTuoteId());
        echo "<tr><td class=\"picture\"><img src=\"productimage.php?product=" . $tuote->getId() . "\" alt=\"\"></td>";
        echo "<td class=\"product\">" . $tuote->getTuotteennimi() . "</td><td class=\"quantity\"><input type=\"text\" class=\"form-control\" name=\"product_" . $ostoskoriTuote->getTuoteId() . "\" value=\"" . $ostoskoriTuote->getMaara() . "\"> x</td><td class=\"price\">" . $tuote->getHinta() . " &euro;<br />" . ($ostoskoriTuote->getMaara() * $tuote->getHinta()) . " &euro;</td></tr>";
        $totalprice += $ostoskoriTuote->getMaara() * $tuote->getHinta();
    }
    echo "<tr><td></td><td></td><td>Yhteensä:</td><td>" . $totalprice . " &euro;</td></tr>";
    echo "</tbody></table>";
    echo "<p><a class=\"btn btn-danger\" href=\"?ostoskori&tyhjenna\">Tyhjennä ostoskori</a> <button class=\"btn btn-success\">Päivitä ostoskori</button> <a class=\"btn btn-primary\" href=\"?order\">Tee tilaus</a></p>";
    echo "</form>";
}
?>
