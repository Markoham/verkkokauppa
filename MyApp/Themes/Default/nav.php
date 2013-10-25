<?php

    echo "<ul>";
    echo "<li class=\"navitem\"><a href=\"" . $this->getBasePath() . "\"><span class=\"glyphicon glyphicon-home\"></span> Etusivu</a></li>";
    $categorylist = $framework->getKategoriat();
    for($i = 0, $c = count($categorylist); $i < $c; $i++)
    {
        echo "<li><a class=\"paakategoria\" href=\"#" . $categorylist[$i]->getKategoria() . "\"><span class=\"glyphicon glyphicon-chevron-down\"></span> " . $categorylist[$i]->getKategoria() . "</a>";
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
    if($this->_asiakas)
        echo "<li class=\"navitem\"><a " . (isset($_GET['logout']) ? "class=\"active\" " : "") . "href=\"" . $this->getBasePath() . "?logout\"><span class=\"glyphicon glyphicon-log-out\"></span> Kirjaudu ulos</a></li>";
    else
        echo "<li class=\"navitem last\"><a " . (isset($_GET['login']) ? "class=\"active\" " : "") . "href=\"" . $this->getBasePath() . "?login\"><span class=\"glyphicon glyphicon-log-in\"></span> Kirjaudu sisään</a></li>";
    echo "</ul>";

?>