<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
        <meta charset="utf-8">
        <title>Framework</title>
        <link href='https://fonts.googleapis.com/css?family=Scada|IM+Fell+English' rel='stylesheet' type='text/css'>
        <?php $framework->importExtralibs(); ?>
        <link rel="stylesheet" href="<?php echo $framework->getThemeUrlPath(); ?>css/input.css" />
        <link rel="stylesheet" href="<?php echo $framework->getThemeUrlPath(); ?>css/style.css" />
        <script src="<?php echo $framework->getThemeUrlPath(); ?>js/menu.js"></script>
        <script>var basepath = "<?php echo $framework->getBasePath(); ?>"</script>
    </head>
    <body>
        <div class="grid-container">
            <div class="grid-100">
                <div id="logo"><h1><a href="<?php echo $framework->getBasePath(); ?>">Kahvimaailma</a></h1></div>
            </div>
            <div class="grid-20">
                <div id="nav"><?php $framework->getNav(); ?></div>
            </div>
            <div class="grid-80">
                <div id="searchandshoppingcart">
                    <div class="shoppingcart">
                        <div class="btn-group">
                            <?php
                                $ostoskori = $framework->getOstoskori();
                                if($ostoskori)
                                    $tuotteet = $ostoskori->getTuotteet();
                            ?>
                            <a href="?ostoskori" class="btn btn-primary" id="ostoskoributton">Ostoskorin sisältö<?php echo (isset($tuotteet) && count($tuotteet) > 0 ? " (".count($tuotteet).")" : "")?></a>
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-sort-asc"></i>
                            </button>
                            <ul class="dropdown-menu" role="menu" id="shoppingcartList">
                                    <?php
                                        $totalprice = 0.0;
                                        if(!isset($tuotteet) || count($tuotteet) == 0)
                                            echo "<li>Ei tuotteita</li>";
                                        else
                                            foreach($tuotteet as $ostoskoriTuote)
                                            {
                                                $tuote = $framework->getTuote($ostoskoriTuote->getTuoteId());
                                                echo "<li>" . $tuote->getTuotteennimi() . " (" . $ostoskoriTuote->getMaara() . ") " . ($ostoskoriTuote->getMaara() * $tuote->getHinta()) . " &euro;</li>";
                                                $totalprice += $ostoskoriTuote->getMaara() * $tuote->getHinta();
                                            }
                                    ?>
                                    
                                    <li class="divider"></li>
                                    <li>Yhteensä: <?php echo $totalprice; ?> &euro;</li>
                                </ul>
                        </div>
                    </div>
                    <div class="search">
                        <form class="form-inline" method="get" action="<?php echo "http" . (@$_SERVER["HTTPS"] == "on" ? "s" : "") . "://".str_replace("&","&amp;",@$_SERVER[HTTP_HOST] . @$_SERVER[REQUEST_URI]); ?>" role="form">
                            <div class="form-group">
                                <input type="text" class="form-control" id="search" name="search" placeholder="Hakusana">
                            </div>
                            <button type="submit" class="btn btn-primary">Etsi</button>
                        </form>
                        <script>
                            document.getElementById("search").focus();
                        </script>
                    </div>
                    <div style="clear:both;"></div>
                </div>
            </div>
            <div class="grid-80">
                <div id="content"><?php $framework->getPageContent(); ?></div>
            </div>
            <div class="grid-100">
                <div id="footer">
                    <div class="center">Footer</div>
                    <div class="left"><a href="<?php echo $framework->getBasePath(); ?>hallinta">Hallinta paneeliin</a></div>
                </div>
            </div>
        </div>
    </body>
</html>