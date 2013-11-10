<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
        <meta charset="utf-8">
        <title>Framework</title>
        <link href='https://fonts.googleapis.com/css?family=Scada|IM+Fell+English' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo $framework->getBasePath(); ?>MyApp/Themes/extralib/unsemantic/css/unsemantic-grid-responsive.css" />
        <link rel="stylesheet" href="<?php echo $framework->getBasePath(); ?>MyApp/Themes/extralib/font-awesome/css/font-awesome.min.css" />
        <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.10.0.custom.min.js"></script>
        <script type="text/javascript" src="js/rangy-core-1.2.3.js"></script>
        <script src="js/hallo.js"></script>
        <script src="js/markdown/showdown.js"></script>
        <script src="js/markdown/to-markdown.js"></script>
        <script src="js/markdown/editor.js"></script>
        <link rel="stylesheet" href="css/jquery-ui-1.8.16.custom.css" />
        <link rel="stylesheet" href="css/input.css" />
        <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>
        <div class="grid-container">
            <div class="grid-100">
                <div id="logo"><h1><a href="<?php echo $framework->getBasePath(); ?>hallinta/">Kahvimaailma - Hallinta</a></h1></div>
            </div>
            <div class="grid-20">
                <div id="nav"><?php

echo "<ul>";
    echo "<li class=\"navitem\">";
        echo "<a href=\"" . $framework->getBasePath() . "hallinta/\">";
            echo "<i class=\"fa fa-home\"></i> Etusivu</a>";
    echo "</li>";

    echo "<li>";
        echo "<a class=\"paakategoria\" href=\"" . $framework->getBasePath() . "hallinta/?manage=products\">";
            echo "<i class=\"fa fa-chevron-right\"></i> Hallitse tuotteita</a>";
        echo "<ul class=\"alakategoria\">";
            echo "<li>";
                echo "<a href=\"" . $framework->getBasePath() . "hallinta/?manage=products&amp;add\">";
                    echo "<i class=\"fa fa-plus\"></i> Lisää tuote</a>";
            echo "</li>";
             echo "<li>";
                echo "<a href=\"" . $framework->getBasePath() . "hallinta/?manage=products&amp;import\">";
                    echo "<i class=\"fa fa-download\"></i> Import XML</a>";
            echo "</li>";
             echo "<li>";
                echo "<a href=\"" . $framework->getBasePath() . "hallinta/?manage=products&amp;export\">";
                    echo "<i class=\"fa fa-upload\"></i> Export XML</a>";
            echo "</li>";
        echo "</ul>";
    echo "</li>";

    echo "<li>";
        echo "<a class=\"paakategoria\" href=\"" . $framework->getBasePath() . "hallinta/?manage=categories\">";
            echo "<i class=\"fa fa-chevron-right\"></i> Hallitse kategorioita</a>";
        echo "<ul class=\"alakategoria\">";
            echo "<li>";
                echo "<a href=\"" . $framework->getBasePath() . "hallinta/?manage=categories&amp;add\"><i class=\"fa fa-plus\"></i> Lisää kategoria</a>";
            echo "</li>";
        echo "</ul>";
    echo "</li>";

    echo "<li>";
        echo "<a class=\"paakategoria\" href=\"" . $framework->getBasePath() . "hallinta/?manage=employees\">";
            echo "<i class=\"fa fa-chevron-right\"></i> Hallitse työntekijöitä</a>";
        echo "<ul class=\"alakategoria\">";
            echo "<li>";
                echo "<a href=\"" . $framework->getBasePath() . "hallinta/?manage=employees&amp;add\">";
                    echo "<i class=\"fa fa-plus\"></i> Lisää työntekijä</a>";
            echo "</li>";
        echo "</ul>";
    echo "</li>";

    echo "<li>";
        echo "<a class=\"navitem\" href=\"" . $framework->getBasePath() . "hallinta/?manage=orders\">";
            echo "<i class=\"fa fa-truck\"></i> Hallitse tilauksia</a>";
    echo "</li>";

    echo "<li>";
        echo "<a class=\"navitem\" href=\"" . $framework->getBasePath() . "hallinta/?manage=settings\">";
            echo "<i class=\"fa fa-wrench\"></i> Asetukset</a>";
    echo "</li>";


    echo "<li class=\"navitem\">";
        echo "<a " . (isset($_GET['userinfo']) ? "class=\"active\" " : "") . "href=\"" . $framework->getBasePath() . "hallinta/?userinfo\">";
            echo "<i class=\"fa fa-user\"></i> Omat tiedot</a>";
    echo "</li>";
    
    echo "<li class=\"navitem last\">";
        echo "<a " . (isset($_GET['logout']) ? "class=\"active\" " : "") . "href=\"" . $framework->getBasePath() . "hallinta/?logout\">";
            echo "<i class=\"fa fa-sign-out\"></i> Kirjaudu ulos</a>";
    echo "</li>";
echo "</ul>";

?></div>
            </div>
            <div class="grid-80">
                <div id="content">
                <?php
                    if(isset($_GET['manage']))
                        include("manage.php");
                    else if(isset($_GET['userinfo']))
                        include("userinfo.php");
                    else
                        include("content.php");
                ?></div>
            </div>
            <div class="grid-100">
                <div id="footer">
                    <div class="center">Footer</div>
                </div>
            </div>
        </div>
    </body>
</html>