<div id="productpage">
    <?php
        $tuote = $framework->getTuote();
    ?>
    <button type="button" class="btn btn-primary" onClick="addTuote(<?php echo $tuote->getId(); ?>)"><span class="glyphicon glyphicon-plus"></span> Lisää koriin</button>
    <h1><?php echo $tuote->getTuotteennimi(); ?></h1>
    <h3>Hinta: <?php echo $tuote->getHinta(); ?></h3>
    <div class="picture"><img src="productimage.php?product=<?php echo $tuote->getId(); ?>" alt="" /></div>
    <div class="description"><?php echo \Michelf\Markdown::defaultTransform($tuote->getKuvaus()); ?></div>
</div>
