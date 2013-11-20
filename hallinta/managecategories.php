<?php
if(isset($_GET['add']))
{
    if(isset($_POST['categoryname']) && isset($_POST['maincategory']))
    {
        $framework->addCategory($_POST['categoryname'], $_POST['maincategory']);
    }
    
    $categorylist = $framework->getKategoriat();
?>
    <form method="post">
        <div class="form-group">
            <label for="categoryname">Kategorian nimi</label>
            <input id="categoryname" class="form-control" type="text" placeholder="Kategorian nimi" name="categoryname">
        </div>
        <div class="form-group">
            <label for="maincategory">Pääkategoria</label>
            <select id="maincategory" name="maincategory">
                <option value="0">Uusi pääkategoria</option>
                <OPTGROUP LABEL="Kategoriat">
                    <?php
    for($i = 0, $c = count($categorylist); $i < $c; $i++)
    {
        echo "<option value=\"" . $categorylist[$i]->getId() . "\"" . ( $_GET['add'] ==  $categorylist[$i]->getId() ? " SELECTED" : ""). ">" . $categorylist[$i]->getKategoria() . "</option>";
    }
                    ?>
                </OPTGROUP>
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Lisää kategoria</button>
    </form>
<?php
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