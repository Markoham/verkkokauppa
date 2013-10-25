<?php
    echo "<table id=\"tuotelista\" class=\"table\">";
    echo "<thead><tr><th class=\"product\">Tuote</th><th class=\"price\">Hinta</th><th class=\"shoppingcart\">Varasto saldo</th><th class=\"shoppingcart\">&nbsp;</th></tr></thead><tbody>";
    $tuotteet = $framework->getTuotteet();
    for($i = 0, $c = count($tuotteet); $i < $c; $i++)
    {
        echo "<tr><td class=\"product\"><p><a href=\"?hcat=" . $_GET['hcat'] . "&amp;cat=" . $_GET['cat'] . "&amp;product=" . $tuotteet[$i]->getId() . "\">" . $tuotteet[$i]->getTuotteennimi() . "</a></p><p>" . $tuotteet[$i]->getKuvaus() . "</p></td><td class=\"price\">" . str_replace(".",",", $tuotteet[$i]->getHinta()) . " &euro;</span></td><td class=\"shoppingcart\">" . $this->getVarastoSaldo($tuotteet[$i]->getId()) . " kpl</td><td class=\"shoppingcart\"><button type=\"button\" class=\"btn btn-primary\" onClick=\"addTuote(" . $tuotteet[$i]->getId() . ")\"><span class=\"glyphicon glyphicon-plus\"></span> Lisää koriin</td></button></tr>";
    }
    echo "</tbody></table>";
?>