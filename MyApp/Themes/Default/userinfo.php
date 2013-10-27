<?php
$asiakas = $framework->getUser();
?>
<h1>Omat tiedot</h1>
<table>
    <tr>
        <td><b>Nimi:</b></td>
        <td><?php echo $asiakas->getEtunimi() . " " . $asiakas->getSukunimi(); ?></td>
    </tr>
    <tr>
        <td><b>Sähköposti:</b></td>
        <td><?php echo $asiakas->getEmail(); ?></td>
    </tr>
</table>