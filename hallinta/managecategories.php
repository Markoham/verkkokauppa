<?php
if(isset($_GET['add']))
{
    if(isset($_POST['categoryname']) && isset($_POST['maincategory']))
    {
        $framework->addCategory($_POST['categoryname'], $_POST['maincategory']);
        echo "<div class=\"message message-ok\">Kategoria lisätty</div>";
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
    if(isset($_POST['categoryname']))
    {
        $framework->updateCategory($_GET['edit'], $_POST['categoryname']);
        echo "<div class=\"message message-ok\">Kategoria päivitetty</div>";
    }

    $categorylist = $framework->getKategoriat();
?>
    <form method="post">
        <div class="form-group">
            <label for="categoryname">Kategorian nimi</label>
            <input id="categoryname" class="form-control" type="text" placeholder="Kategorian nimi" name="categoryname" value="<?php echo $framework->getCategoryNameById($_GET['edit']); ?>">
        </div>
        <button class="btn btn-primary" type="submit">Päivitä kategoria</button>
    </form>
<?php
}
else if(isset($_GET['remove']))
{
    if(isset($_GET['comfirm']))
        if($_GET['comfirm'] == "true")
            $framework->removeCategory($_GET['remove']);
        else
            header("Location: " . (explode("&remove", $framework->getCurrentUrlNoAmp())[0]) );
    else
    {
        echo "<h2>Haluatko varmasti poistaa kategorian?</h2>";
        echo "<a href=\"" . $framework->getCurrentUrl() . "&comfirm=true\" class=\"btn btn-success\">Kyllä</a>";
        echo "<a href=\"" . $framework->getCurrentUrl() . "&comfirm=false\" class=\"btn btn-danger\">Ei</a>";
    }
}
else
{
    echo "<ul>";
    $categorylist = $framework->getKategoriat();

    for($i = 0, $c = count($categorylist); $i < $c; $i++)
    {
        echo "<li>" . $categorylist[$i]->getKategoria() . " <a href=\"" . $framework->getCurrentUrl() . "&amp;edit=" . $categorylist[$i]->getId() . "\">Muokkaa</a> <a href=\"" . $framework->getCurrentUrl() . "&amp;remove=" . $categorylist[$i]->getId() . "\">Poista</a></li>";
        echo "<ul>";
        $alacategorylist = $categorylist[$i]->getAlakategoriat();
        for($j = 0, $n = count($alacategorylist); $j < $n; $j++)
        {
            echo "<li>" . $alacategorylist[$j]->getKategoria() . " <a href=\"" . $framework->getCurrentUrl() . "&amp;edit=" . $alacategorylist[$j]->getId() . "\">Muokkaa</a> <a href=\"" . $framework->getCurrentUrl() . "&amp;remove=" . $alacategorylist[$j]->getId() . "\">Poista</a></li>";
        }
        echo "<li><a href=\"" . $framework->getBasePath() . "hallinta/?manage=categories&amp;add=" . $categorylist[$i]->getId() . "\">Lisää uusi</a></li>";
        echo "</ul>";
    }
    echo "<li><a href=\"" . $framework->getBasePath() . "hallinta/?manage=categories&amp;add\">Lisää uusi pääkategoria</a></li>";
    echo "</ul>";
}
?>
