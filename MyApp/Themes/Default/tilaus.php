<?php
if($framework->getUser())
{
    echo "<h1>Tilaus</h1>";

    if(isset($_GET['send']))
    {
        $tilaus = $framework->getTilausKesken();
        $framework->updateTilausStatus($tilaus, 1);
        echo "Kiitos tilauksesta.";
    }
    else
    {
        if($framework->tilausKesken())
        {
            $tilaus = $framework->getTilausKesken();
        }
        else
        {
            $tilaus = $framework->createTilaus();
            $framework->clearOstoskori();
        }

        if($tilaus)
            $tuotteet = $tilaus->getTuotteet();

        $totalprice = 0.0;
        if(!isset($tuotteet) || count($tuotteet) == 0)
            echo "<h3>Ei tuotteita</h3>";
        else
        {
            echo "<form action=\"?order&send\" method=\"post\"><table id=\"ostoskori\" class=\"table\">";
            echo "<thead><tr><th class=\"picture\">Kuva</th><th class=\"product\">Tuote</th><th class=\"price\" colspan=\"2\">Total</th></tr></thead><tbody>";
            foreach($tuotteet as $tilauksenTuote)
            {
                $tuote = $framework->getTuote($tilauksenTuote->getTuoteId());
                echo "<tr><td class=\"picture\"><img src=\"productimage.php?product=" . $tuote->getId() . "\" alt=\"\"></td>";
                echo "<td class=\"product\">" . $tuote->getTuotteennimi() . "</td><td class=\"quantity\">" . $tilauksenTuote->getMaara() . " x</td><td class=\"price\">" . $tuote->getHinta() . " &euro;<br />" . ($tilauksenTuote->getMaara() * $tuote->getHinta()) . " &euro;</td></tr>";
                $totalprice += $tilauksenTuote->getMaara() * $tuote->getHinta();
            }
            echo "<tr><td></td><td></td><td>Yhteensä:</td><td>" . $totalprice . " &euro;</td></tr>";
            echo "</tbody></table>";
            echo "<p>Toimitus osoite:</p>";
            echo "<table>";
            $asiakas = $framework->getUser();
            echo "<tr><td>Sähköposti:</td><td>" . $asiakas->getEmail() . "</td><tr>";
            echo "<tr><td>Katuosoite:</td><td><input name=\"osoite\" type=\"text\" /></td><tr>";
            echo "<tr><td>Postinumero:</td><td><input name=\"postinro\" type=\"text\" /></td><tr>";
            echo "<tr><td>Postitoimipaikka:</td><td><input name=\"posttoim\" type=\"text\" /></td><tr>";
            echo "</table>";
            echo "<p><a class=\"btn btn-primary\" href=\"?order&send\">Tilaa</a></p>";
            echo "</form>";
        }
    }
}
else
{
    echo "<h2>Tilaus vaatii kirjautumista!</h2>";
    $redirectUrl = "?order";
    include("login.php");
}
?>
