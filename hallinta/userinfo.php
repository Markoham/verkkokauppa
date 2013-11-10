<?php
$user = $framework->getUser();
?>
<h1>Omat tiedot</h1>
<table>
    <tr>
        <td><b>Nimi:</b></td>
        <td><?php echo $user->getEtunimi() . " " . $user->getSukunimi(); ?></td>
    </tr>
    <tr>
        <td><b>Sähköposti:</b></td>
        <td><?php echo $user->getEmail(); ?></td>
    </tr>
</table>