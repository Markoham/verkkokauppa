<?php
    $tuote = $framework->getTuote();
?>
<h1><?php echo $tuote->getTuotteennimi(); ?></h1>
<?php echo $tuote->getKuvaus(); ?>
<?php echo $tuote->getHinta(); ?>