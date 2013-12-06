<h1>Tervetuloa Kahvimaailmaan!</h1>
<p>Viimeksi lisätyt tuotteet:</p>
<div id="recentlyadded">
<?php
$tuotteet = $framework->getRecentlyAdded(5);
foreach($tuotteet as $tuote)
{
    echo "<div class=\"product\"><a href=\"?product=" . $tuote->getId() . "\"><img src=\"productimage.php?product=" . $tuote->getId() . "\" alt=\"\"><div>" . $tuote->getTuotteennimi() . "</div></a></div>";
}
?>
</div>
<div class="clear"></div>
