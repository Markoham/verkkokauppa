<?php
    if($_GET['manage'] == "products")
    {
        echo "<h1>Tuotteiden hallinta</h1>";
        include("manageproducts.php");
    }
    else if($_GET['manage'] == "categories")
    {
        echo "<h1>Kategorioiden hallinta</h1>";
        include("managecategories.php");
    }
    else if($_GET['manage'] == "employees")
    {
        echo "<h1><i class=\"fa fa-users\"></i> Työntekijöiden hallinta</h1>";
        include("manageemployees.php");
    }
    else if($_GET['manage'] == "orders")
    {
        echo "<h1><i class=\"fa fa-truck\"></i> Tilausten hallinta</h1>";
        include("manageorders.php");
    }
    else if($_GET['manage'] == "settings")
    {
        echo "<h1><i class=\"fa fa-wrench\"></i> Asetukset</h1>";
    }
    else
    {
        echo "Sivua ei löydy!";
    }
?>