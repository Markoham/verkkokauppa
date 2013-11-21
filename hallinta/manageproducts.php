<?php
if(isset($_GET['add']))
{
    if(isset($_GET['productname']) && isset($_GET['productprice']) && isset($_GET['productdescriptionsource']))
    {
    }
?>
    <form method="post">
        <div class="form-group">
            <label for="productname">Tuotteen nimi</label>
            <input id="productname" class="form-control" type="text" placeholder="Tuotteen nimi" name="productname">
        </div>
        <div class="form-group">
            <label for="productprice">Tuotteen hinta</label>
            <input id="productprice" class="form-control" type="text" placeholder="Tuotteen hinta" name="productprice">
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
                <textarea class="productdescription form-control" id="productdescriptionsource" name="productdescription" placeholder="Tuotteen kuvaus"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="productcategories">Tuotteen kategoriat</label>
            <div id="productcategylist"></div>
            <div id="search">
                <input type="text" class="form-control" id="searchfield"><button type="button" onclick="" class="btn btn-primary">Etsi</button>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Lisää tuote</button>
    </form>
<?php
}
else if(isset($_GET['edit']))
{
    $tuote = $framework->getTuote($_GET['edit']);
    if(isset($_GET['productname']) && isset($_GET['productprice']) && isset($_GET['productdescriptionsource']))
    {
    }
?>
    <form method="post">
        <div class="form-group">
            <label for="productname">Tuotteen nimi</label>
            <input id="productname" class="form-control" type="text" placeholder="Tuotteen nimi" value="<?php echo $tuote->getTuotteennimi(); ?>" name="productname">
        </div>
        <div class="form-group">
            <label for="productprice">Tuotteen hinta</label>
            <input id="productprice" class="form-control" type="text" placeholder="Tuotteen hinta" value="<?php echo $tuote->getHinta(); ?>" name="productprice">
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

        </div>
        <button class="btn btn-primary" type="submit">Lisää tuote</button>
    </form>
<?php
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
        <input class="form-control" type="file" name="file" id="file">
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
                    echo "<img src=\"" . $framework->getProductThumbImage($tuotteet[$i]->getId()) . "\" alt=\"\">";
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
