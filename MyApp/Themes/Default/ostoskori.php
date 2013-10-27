<?php

if(isset($_GET['tyhjenna']))
{
    $framework->clearOstoskori();
    header("location: ?ostoskori");
}
$ostoskori = $framework->getOstoskori();
if($ostoskori)
    $tuotteet = $ostoskori->getTuotteet();

$totalprice = 0.0;
if(!isset($tuotteet) || count($tuotteet) == 0)
    echo "<h3>Ei tuotteita</h3>";
else
{
    echo "<form action=\"?ostoskori\"><table id=\"ostoskori\" class=\"table\">";
    echo "<thead><tr><th class=\"picture\">Kuva</th><th class=\"product\">Tuote</th><th class=\"price\" colspan=\"2\">Total</th></tr></thead><tbody>";
    foreach($tuotteet as $ostoskoriTuote)
    {
        echo "<tr><td class=\"picture\"><img src=\"" . $framework->getProductThumbImage($ostoskoriTuote->getTuoteId()) . "\" alt=\"\"></td>";
        $tuote = $framework->getTuote($ostoskoriTuote->getTuoteId());
        echo "<td class=\"product\">" . $tuote->getTuotteennimi() . "</td><td class=\"quantity\"><input type=\"text\" class=\"form-control\" name=\"product_" . $ostoskoriTuote->getTuoteId() . "\" value=\"" . $ostoskoriTuote->getMaara() . "\"> x</td><td class=\"price\">" . $tuote->getHinta() . " &euro;<br />" . ($ostoskoriTuote->getMaara() * $tuote->getHinta()) . " &euro;</td></tr>";
        $totalprice += $ostoskoriTuote->getMaara() * $tuote->getHinta();
    }
    echo "</tbody></table></form>";
    echo "<p><b>Yhteensä:</b> " . $totalprice . " &euro;</p>";
    echo "<p><a href=\"?ostoskori&tyhjenna\">Tyhjennä ostoskori</a></p><p><a href=\"?ostoskori&paivita\">Päivitä ostoskori</a></p>";
}
?>