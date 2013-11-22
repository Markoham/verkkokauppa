<?php
if(isset($_GET['add']))
{
    if(isset($_POST['productname']) && isset($_POST['productprice']) && isset($_POST['productdescription']))
    {
        $product = new \MyApp\DataObjects\Tuote();
        $product->setTuotteennimi($_POST['productname']);
        $product->setHinta(str_replace(",",".",$_POST['productprice']));
        $product->setKuvaus($_POST['productdescription']);

        $id = $framework->addProduct($product);

        foreach ($_POST['catElem'] as $category)
        {
            $cat = explode("_", $category);

            if($cat[1] == "add")
            {
                $framework->addTuotteelleKategoria($id, $cat[0]);
            }
        }
        echo "<div class=\"message message-ok\">Tuote lisätty</div>";
    }
?>
    <form method="post">
        <div class="form-group">
            <label for="productname">Tuotteen nimi</label>
            <input id="productname" class="form-control" type="text" placeholder="Tuotteen nimi" name="productname" value="<?php echo (isset($_POST['productname']) ? $_POST['productname'] : ""); ?>">
        </div>
        <div class="form-group">
            <label for="productprice">Tuotteen hinta</label>
            <input id="productprice" class="form-control" type="text" placeholder="Tuotteen hinta" name="productprice" value="<?php echo (isset($_POST['productprice']) ? $_POST['productprice'] : ""); ?>">
        </div>
        <div class="form-group">
            <label for="productdescription">Tuotteen kuvaus</label>
            <div id="markdownEditorTabs">
                <ul>
                    <li><a href="javascript:void(0)" onClick="showLive();" id="linkproductdescriptionlive" class="active">Live</a></li>
                    <li><a href="javascript:void(0)" onClick="showMarkdown();" id="linkproductdescriptionsource">Markdown</a></li>
                </ul>
            </div>
            <div id="markdownEditor">
                <div class="productdescription editable" id="productdescriptionlive" data-placeholder="Tuotteen kuvaus"></div>
                <textarea class="productdescription form-control" id="productdescriptionsource" name="productdescription" placeholder="Tuotteen kuvaus"><?php echo (isset($_POST['productdescription']) ? $_POST['productdescription'] : ""); ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="productcategories">Tuotteen kategoriat</label>
            <div id="productcategylist"><?php
            if(isset($_POST['catElem']))
            {
                foreach ($_POST['catElem'] as $category)
                {
                    $cat = explode("_", $category);
                    echo "<div class=\"catListItem\" data-action=\"add\" id=\"catListItem_" . $cat[0] . "\"><span class=\"catListItemText\">" . $framework->getCategoryNameById($cat[0]) . "</span><input value=\"" . $cat[0] . "_add\" data-id=\"" . $cat[0] . "\" data-database=\"false\" name=\"catElem[]\" type=\"hidden\"><button onclick=\"removeCategory('catListItem_" . $cat[0] . "');\" type=\"button\" class=\"catListItemClose\">x</button></div>";
                }
            }
                ?></div>
            <div id="search">
                <input type="text" list="catlist" class="form-control" id="searchfield"><button type="button" onclick="addCategory();" class="btn btn-primary">Lisää kategoria</button>
                <datalist id="catlist">
                    <?php
    $categorylist = $framework->getKategoriat();

    for($i = 0, $c = count($categorylist); $i < $c; $i++)
    {
        $alacategorylist = $categorylist[$i]->getAlakategoriat();
        for($j = 0, $n = count($alacategorylist); $j < $n; $j++)
        {
            echo "<option value=\"" . $alacategorylist[$j]->getKategoria() . "\" id=\"" . $alacategorylist[$j]->getId() . "\"></option>";
        }
    }
                    ?>
                </datalist>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Lisää tuote</button>
    </form>
<?php
}
else if(isset($_GET['edit']))
{
    $tuote = $framework->getTuote($_GET['edit']);
    if(isset($_POST['productname']) && isset($_POST['productprice']) && isset($_POST['productdescription']))
    {
        $product = new \MyApp\DataObjects\Tuote();
        $product->setId($_GET['edit']);
        $product->setTuotteennimi($_POST['productname']);
        $product->setHinta(str_replace(",",".",$_POST['productprice']));
        $product->setKuvaus($_POST['productdescription']);

        $framework->updateProduct($product);

        foreach ($_POST['catElem'] as $category)
        {
            $cat = explode("_", $category);

            if($cat[1] == "add")
            {
                $framework->addTuotteelleKategoria($product->getId(), $cat[0]);
            }
            else if($cat[1] == "remove")
            {
                $framework->removeTuotteenKategoria($product->getId(), $cat[0]);
            }
        }
        echo "<div class=\"message message-ok\">Tuote päivitetty</div>";
    }
?>
    <form method="post">
        <div class="form-group">
            <label for="productname">Tuotteen nimi</label>
            <input id="productname" class="form-control" type="text" placeholder="Tuotteen nimi" value="<?php echo $tuote->getTuotteennimi(); ?>" name="productname">
        </div>
        <div class="form-group">
            <label for="productprice">Tuotteen hinta</label>
            <input id="productprice" class="form-control" type="text" placeholder="Tuotteen hinta" value="<?php echo str_replace(".",",",$tuote->getHinta()); ?>" name="productprice">
        </div>
        <div class="form-group">
            <label for="productdescription">Tuotteen kuvaus</label>
            <div id="markdownEditorTabs">
                <ul>
                    <li><a href="javascript:void(0)" onClick="showLive();" id="linkproductdescriptionlive" class="active">Live</a></li>
                    <li><a href="javascript:void(0)" onClick="showMarkdown();" id="linkproductdescriptionsource">Markdown</a></li>
                </ul>
            </div>
            <div id="markdownEditor">
                <div class="productdescription editable" id="productdescriptionlive" data-placeholder="Tuotteen kuvaus"><?php echo $tuote->getKuvaus(); ?></div>
                <textarea class="productdescription form-control" id="productdescriptionsource" value="" name="productdescription" placeholder="Tuotteen kuvaus"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="productcategories">Tuotteen kategoriat</label>
            <div id="productcategylist"><?php
                $cats = $framework->getTuotteenkategoriat($tuote->getId());
                for($i = 0, $c = count($cats); $i < $c; $i++)
                {
                    echo "<div class=\"catListItem\" data-action=\"none\" id=\"catListItem_" . $cats[$i]->getId() . "\"><span class=\"catListItemText\">" . $cats[$i]->getKategoria() . "</span><input value=\"" . $cats[$i]->getId() . "_none\" data-id=\"" . $cats[$i]->getId() . "\" data-database=\"true\" name=\"catElem[]\" type=\"hidden\"><button onclick=\"removeCategory('catListItem_" . $cats[$i]->getId() . "');\" type=\"button\" class=\"catListItemClose\">x</button></div>";
                }
        ?></div>
            <div id="search">
                <input type="text" list="catlist" class="form-control" id="searchfield"><button type="button" onclick="addCategory();" class="btn btn-primary">Lisää kategoria</button>
                <datalist id="catlist">
                    <?php
    $categorylist = $framework->getKategoriat();

    for($i = 0, $c = count($categorylist); $i < $c; $i++)
    {
        $alacategorylist = $categorylist[$i]->getAlakategoriat();
        for($j = 0, $n = count($alacategorylist); $j < $n; $j++)
        {
            echo "<option value=\"" . $alacategorylist[$j]->getKategoria() . "\" id=\"" . $alacategorylist[$j]->getId() . "\"></option>";
        }
    }
                    ?>
                </datalist>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Päivitä tuote</button>
    </form>
<?php
}
else if(isset($_GET['remove']))
{
    if(isset($_GET['comfirm']))
        if($_GET['comfirm'] == "true")
            $framework->removeTuote($_GET['remove']);
        else
            header("Location: " . (explode("&remove", $framework->getCurrentUrlNoAmp())[0]) );
    else
    {
        echo "<h2>Haluatko varmasti poistaa tuotteen?</h2>";
        echo "<a href=\"" . $framework->getCurrentUrl() . "&comfirm=true\" class=\"btn btn-success\">Kyllä</a>";
        echo "<a href=\"" . $framework->getCurrentUrl() . "&comfirm=false\" class=\"btn btn-danger\">Ei</a>";
    }
}
else if(isset($_GET['export']))
{
    echo "<h2><i class=\"fa fa-upload\"></i> Export</h2>";
    echo "<a href=\"" . explode("?",$framework->getCurrentUrl())[0] . "xmlExport.php\" target=\"blank\">XML</a>";
}
else if(isset($_GET['import']))
{
    echo "<h2><i class=\"fa fa-download\"></i> Import</h2>";
    
    if(isset($_FILES['file']) && $_FILES['file']['error'] == 0)
    {
        $xml = simplexml_load_file($_FILES['file']['tmp_name']);
        
        $dom = new DOMDocument;
        
        $dom->loadXML($xml->asXML());
        
        if (!$dom->schemaValidate("documentstructure.xsd")) {
            echo "This document is not valid!\n";
        }
        else
        {
            echo "<h3>Päivitetyt tuotteet</h3>";
            echo "<div class=\"importproducts\">";
            foreach ($xml->children() as $child)
            {
                if($child->attributes()->action == "add")
                {
                    $status = " added";
                    
                    $product = new \MyApp\DataObjects\Tuote();
                    $product->setId($child->attributes()->id);
                    $product->setTuotteennimi($child->name);
                    $product->setHinta($child->price);
                    $product->setKuvaus($child->description);
                    
                    $id = $framework->addProduct($product);
                    
                    foreach ($child->categories->children() as $category)
                    {
                        if($category->attributes()->action == "add")
                        {
                            $framework->addTuotteelleKategoria($id, $category->attributes()->id);
                        }
                    }
                }
                else if($child->attributes()->action == "update")
                {
                    $status = " updated";
                    
                    $product = new \MyApp\DataObjects\Tuote();
                    $product->setId($child->attributes()->id);
                    $product->setTuotteennimi($child->name);
                    $product->setHinta($child->price);
                    $product->setKuvaus($child->description);
                    
                    $framework->updateProduct($product);
                    
                    foreach ($child->categories->children() as $category)
                    {
                        if($category->attributes()->action == "add")
                        {
                            $framework->addTuotteelleKategoria($product->getId(), $category->attributes()->id);
                        }
                        else if($category->attributes()->action == "remove")
                        {
                            $framework->removeTuotteenKategoria($product->getId(), $category->attributes()->id);
                        }
                    }
                }
                else if($child->attributes()->action == "remove")
                {
                    $status = " removed";
                    $framework->removeTuote($child->attributes()->id);
                    $framework->removeTuotteenKategoriat($child->attributes()->id);
                }
                else
                    $status = " none";
                    
                echo "<div class=\"importproduct" . $status . "\">" . $child->name . "</div>";
            }
            echo "</div><hr />";
        }
    }
    
    ?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="file">Tiedoston:</label>
        <input class="form-control" accept="text/xml" type="file" name="file" id="file">
    </div>
    <button type="submit" class="btn">Import</button>
</form>
    <?php
}
else if(isset($_GET['product']))
{
    $tuote = $framework->getTuote();

    echo "<h2>" . $tuote->getTuotteennimi(). "</h2>";
    echo $tuote->getKuvaus();
    echo $tuote->getHinta();
}
else if(isset($_GET['productimage']))
{
    if(isset($_FILES['file']))
    {
        $filename = $_FILES['file']['tmp_name'];
        $fp = fopen($filename , 'r');
        $data = fread($fp, filesize($filename));
        $mime = mime_content_type($filename);
        fclose($fp);

        $framework->updateProductImage($_GET['productimage'], $data, $mime);
        echo "<div class=\"message message-ok\">Tuotekuva päivitetty</div>";
    }
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="file">Tiedoston:</label>
        <input class="form-control" accept="image/*" type="file" name="file" id="file">
    </div>
    <button type="submit" class="btn">Update</button>
</form>
<?php
}
else
{
    echo "<table id=\"productlist\" class=\"table\">";
        echo "<thead>";
            echo "<tr>";
                echo "<th class=\"picture\"></th>";
                echo "<th class=\"product\">Tuote</th>";
                echo "<th class=\"price\">Hinta</th>";
                echo "<th class=\"shoppingcart\">Varasto saldo</th>";
                echo "<th class=\"edit\">&nbsp;</th>";
                echo "<th class=\"remove\">&nbsp;</th>";
            echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
    $tuotteet = $framework->getTuotteet();
    for($i = 0, $c = count($tuotteet); $i < $c; $i++)
    {
            echo "<tr>";
                echo "<td class=\"picture\">";
                    echo "<img src=\"" . $framework->getBasePath() . "productimage.php?product=" . $tuotteet[$i]->getId() . "\" alt=\"\">";
                echo "</td>";
                echo "<td class=\"product\">";
                    echo "<p>";
                        echo "<a href=\"" . $framework->getCurrentUrl() . "&amp;product=" . $tuotteet[$i]->getId() . "\">" . $tuotteet[$i]->getTuotteennimi() . "</a>";
                    echo "</p>";
                    echo "<p>" . $tuotteet[$i]->getKuvaus() . "</p>";
                echo "</td>";
                echo "<td class=\"price\">" . str_replace(".",",", $tuotteet[$i]->getHinta()) . " &euro;</td>";
                echo "<td class=\"shoppingcart\">" . $framework->getVarastoSaldo($tuotteet[$i]->getId()) . " kpl</td>";
                echo "<td class=\"edit\">";
                    echo "<a class=\"btn btn-primary\" href=\"" . $framework->getCurrentUrl() . "&amp;edit=" . $tuotteet[$i]->getId() . "\">Muokkaa</a>";
                    echo "<br />";
                    echo "<a class=\"btn btn-primary\" href=\"" . $framework->getCurrentUrl() . "&amp;productimage=" . $tuotteet[$i]->getId() . "\">Tuotekuva</a>";
                echo "</td>";
                echo "<td class=\"remove\">";
                    echo "<a class=\"btn btn-primary\" href=\"" . $framework->getCurrentUrl() . "&amp;remove=" . $tuotteet[$i]->getId() . "\">Poista</a>";
                echo "</td>";
            echo "</tr>";
    }
        echo "</tbody>";
    echo "</table>";

}
?>
