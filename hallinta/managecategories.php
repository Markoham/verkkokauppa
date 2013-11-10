<?php
if(isset($_GET['add']))
{

}
else if(isset($_GET['edit']))
{
}
else if(isset($_GET['product']))
{

}
else
{
    echo "<ul>";
    $categorylist = $framework->getKategoriat();

    for($i = 0, $c = count($categorylist); $i < $c; $i++)
    {
        echo "<li>" . $categorylist[$i]->getKategoria() . "</li>";
        echo "<ul>";
        $alacategorylist = $categorylist[$i]->getAlakategoriat();
        for($j = 0, $n = count($alacategorylist); $j < $n; $j++)
        {
            echo "<li>" . $alacategorylist[$j]->getKategoria() . "</li>";
        }
        echo "<li><a href=\"" . $framework->getBasePath() . "hallinta/?manage=categories&amp;add=" . $categorylist[$i]->getId() . "\">Lisää uusi</a></li>";
        echo "</ul>";
    }
    echo "<li><a href=\"" . $framework->getBasePath() . "hallinta/?manage=categories&amp;add\">Lisää uusi pääkategoria</a></li>";
    echo "</ul>";
}
?>