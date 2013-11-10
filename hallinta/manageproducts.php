<?php
if(isset($_GET['add']))
{
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
        </div>
        <button class="btn btn-primary" type="submit">Lisää tuote</button>
    </form>
<script>
    (function ($) {
        $(document).on('change keydown keypress input', 'div[data-placeholder]', function() {
            if (this.textContent) {
                this.dataset.divPlaceholderContent = 'true';
            }
            else {
                delete(this.dataset.divPlaceholderContent);
            }
        });
    })(jQuery);
    
    function showMarkdown()
    {
        document.getElementById("linkproductdescriptionlive").className = "";
        document.getElementById("linkproductdescriptionsource").className = "active";
        
        var elem = document.getElementById("productdescriptionsource");
        elem.style.visibility = "visible";
        elem.style.display = "inherit";
        
        var elem2 = document.getElementById("productdescriptionlive");
        elem2.style.visibility = "hidden";
        elem2.style.display = "none";
    }
    
    function showLive()
    {
        document.getElementById("linkproductdescriptionlive").className = "active";
        document.getElementById("linkproductdescriptionsource").className = "";
        
        var elem = document.getElementById("productdescriptionlive");
        elem.style.visibility = "visible";
        elem.style.display = "inherit";
        
        var elem2 = document.getElementById("productdescriptionsource");
        elem2.style.visibility = "hidden";
        elem2.style.display = "none";
    }
</script>
<?php
}
else if(isset($_GET['edit']))
{
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
            <textarea class="form-control" id="productdescription" name="productdescription" placeholder="Tuotteen kuvaus"></textarea>
        </div>
        <div class="form-group">
            <label for="productcategories">Tuotteen kategoriat</label>

        </div>
        <button class="btn btn-primary" type="submit">Lisää tuote</button>
    </form>
<?php
}
else if(isset($_GET['import']))
{
    echo "<h2><i class=\"fa fa-download\"></i> Import</h2>";
}
else if(isset($_GET['export']))
{
    echo "<h2><i class=\"fa fa-upload\"></i> Export</h2>";
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