<?php

    echo "<ul>";
    echo "<li class=\"navitem\"><a href=\"" . $this->getBasePath() . "\"><i class=\"fa fa-home\"></i> Etusivu</a></li>";
    $categorylist = $framework->getKategoriat();
    for($i = 0, $c = count($categorylist); $i < $c; $i++)
    {
        echo "<li><a class=\"paakategoria\" href=\"#" . $categorylist[$i]->getKategoria() . "\"><i class=\"fa fa-chevron-right " . (@$_GET['hcat'] == $categorylist[$i]->getId() ? " active" : "") . "\"></i> " . $categorylist[$i]->getKategoria() . "</a>";
        if(count($categorylist[$i]->getAlakategoriat()) > 0)
        {
            echo "<ul class=\"alakategoria " . $categorylist[$i]->getKategoria() . (@$_GET['hcat'] == $categorylist[$i]->getId() ? " active" : "") . "\">";
            $alacategorylist = $categorylist[$i]->getAlakategoriat();
            for($j = 0, $n = count($alacategorylist); $j < $n; $j++)
            {
                echo "<li><a " . (@$_GET['cat'] == $alacategorylist[$j]->getId() ? "class=\"active\" " : "") . "href=\"?hcat=" . $categorylist[$i]->getId() . "&amp;cat=" . $alacategorylist[$j]->getId() . "\">" . $alacategorylist[$j]->getKategoria() . "</a></li>";
            }
            echo "</ul>";
        }
        echo "</li>";
    }
    if($this->getUser())
    {
        echo "<li class=\"navitem\"><a " . (isset($_GET['userinfo']) ? "class=\"active\" " : "") . "href=\"" . $this->getBasePath() . "?userinfo\"><i class=\"fa fa-user\"></i> Omat tiedot</a></li>";
        
        echo "<li class=\"navitem\"><a " . (isset($_GET['logout']) ? "class=\"active\" " : "") . "href=\"" . $this->getBasePath() . "?logout\"><i class=\"fa fa-sign-out\"></i> Kirjaudu ulos</a></li>";
    }
    else
        echo "<li class=\"navitem\"><a " . (isset($_GET['login']) ? "class=\"active\" " : "") . "href=\"" . $this->getBasePath() . "?login\"><i class=\"fa fa-sign-in\"></i> Kirjaudu sisään</a></li>";
    echo "</ul>";

?>