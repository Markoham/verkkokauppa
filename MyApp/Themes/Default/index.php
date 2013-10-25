<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
        <meta charset="utf-8">
        <title>Framework</title>
        <link href='http://fonts.googleapis.com/css?family=Voltaire|IM+Fell+English' rel='stylesheet' type='text/css'>
        <?php $framework->importExtralibs(); ?>
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
                            <button type="button" class="btn btn-primary">Ostoskorin sisältö</button>
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <ul class="dropdown-menu" role="menu">
                                    <li>Ei tuotteita</li>
                                    <li class="divider"></li>
                                    <li>Yhteensä: 0 &euro;</li>
                                </ul>
                            </button>
                        </div>
                    </div>
                    <div class="search">
                        <form class="form-inline" method="get" action="" role="form">
                            <div class="form-group">
                                <input type="text" class="form-control" name="searchtext" placeholder="Hakusana">
                            </div>
                            <button type="submit" class="btn btn-primary">Etsi</button>
                        </form>
                    </div>
                    <div style="clear:both;"></div>
                </div>
            </div>
            <div class="grid-80">
                <div id="content"><?php $framework->getPageContent(); ?></div>
            </div>
            <div class="grid-100">
                <div id="footer">Footer</div>
            </div>
        </div>
    </body>
</html>