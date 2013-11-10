<?php
if(isset($_GET['add']))
{
echo "<h2>Luo uusi työntekijä</h2>";
echo "<br />";

if(isset($_POST['etunimi']) && isset($_POST['sukunimi']) && isset($_POST['email']) && isset($_POST['passwd']))
{
    if($framework->validEmail($_POST['email']))
    {
        $status = $framework->addTyontekija($_POST['etunimi'], $_POST['sukunimi'], $_POST['email'], $_POST['passwd']);
        if($status == -1)
            echo "<div class=\"alert alert-success\">Käyttäjätunnus on jo käytössä!</div>";
        else if($status)
            echo "<div class=\"alert alert-danger\">Käyttäjätunnuksen luonti onnistui!</div>";
        else
            echo "<div class=\"alert alert-danger\">Käyttäjätunnuksen luonnissa tapahtui virhe!</div>";
    }
    else
    {
        echo "<div class=\"alert alert-danger\">Virheellinen sähköpostiosoite!</div>";
    }
}
?>
    <div class="employeeform">
        <form method="post">
            <div class="form-group">
                <label for="etunimi">Etunimi</label>
                <input type="text" class="form-control" id="etunimi" name="etunimi" placeholder="Etunimi" value="<?php echo @$_POST['etunimi']; ?>" required>
            </div>
            <div class="form-group">
                <label for="sukunimi">Sukunimi</label>
                <input type="text" class="form-control" id="sukunimi" name="sukunimi" placeholder="Sukunimi" value="<?php echo @$_POST['sukunimi']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Sähköposti</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Sähköposti" value="<?php echo @$_POST['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Salasana</label>
                <input type="password" class="form-control" id="password" name="passwd" placeholder="Salasana" required>
            </div>
            <button type="submit" class="btn btn-primary">Lisää työntekijä</button>
        </form>
    </div>
<?php
}
else if(isset($_GET['edit']))
{
    $employee = $framework->getUser($_GET['edit']);
    echo "<h2>Päivitä työntekijää</h2>";
    echo "<br />";

if(isset($_POST['etunimi']) && isset($_POST['sukunimi']) && isset($_POST['email']) && isset($_POST['passwd']))
{
    if($framework->validEmail($_POST['email']))
    {
        $status = $framework->addTyontekija($_POST['etunimi'], $_POST['sukunimi'], $_POST['email'], $_POST['passwd']);
        if($status == -1)
            echo "<div class=\"alert alert-success\">Käyttäjätunnus on jo käytössä!</div>";
        else if($status)
            echo "<div class=\"alert alert-danger\">Käyttäjätunnuksen luonti onnistui!</div>";
        else
            echo "<div class=\"alert alert-danger\">Käyttäjätunnuksen luonnissa tapahtui virhe!</div>";
    }
    else
    {
        echo "<div class=\"alert alert-danger\">Virheellinen sähköpostiosoite!</div>";
    }
}
?>
    <div class="employeeform">
        <form method="post">
            <div class="form-group">
                <label for="etunimi">Etunimi</label>
                <input type="text" class="form-control" id="etunimi" name="etunimi" placeholder="Etunimi" value="<?php echo isset($_POST['etunimi']) ? $_POST['etunimi'] : $employee->getEtunimi(); ?>" required>
            </div>
            <div class="form-group">
                <label for="sukunimi">Sukunimi</label>
                <input type="text" class="form-control" id="sukunimi" name="sukunimi" placeholder="Sukunimi" value="<?php echo isset($_POST['sukunimi']) ? $_POST['sukunimi'] : $employee->getSukunimi(); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Sähköposti</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Sähköposti" value="<?php echo isset($_POST['email']) ? $_POST['email'] : $employee->getEmail(); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Salasana</label>
                <input type="password" class="form-control" id="password" name="passwd" placeholder="Salasana" required>
            </div>
            <button type="submit" class="btn btn-primary">Päivitä</button>
        </form>
    </div>
<?php
}
else
{
    echo "<table id=\"employeeslist\" class=\"table\">";
        echo "<thead>";
            echo "<tr>";
                echo "<th>Etunimi</th>";
                echo "<th>Sukunimi</th>";
                echo "<th>Sähköposti</th>";
                echo "<th></th>";
                echo "<th></th>";
            echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
    
        $employeeslist = $framework->getTyontekijat();
    
        for($i = 0, $c = count($employeeslist); $i < $c; $i++)
        {
            echo "<tr>";
                echo "<td>" . $employeeslist[$i]->getEtunimi() . "</td>";
                echo "<td>" . $employeeslist[$i]->getSukunimi() . "</td>";
                echo "<td>" . $employeeslist[$i]->getEmail() . "</td>";
                echo "<td>";
                    echo "<a class=\"btn btn-primary\" href=\"" . $framework->getCurrentUrl() . "&amp;edit=" . $employeeslist[$i]->getId() . "\">Muokkaa</a>";
                echo "</td>";
                echo "<td>";
                    echo "<a class=\"btn btn-primary\" href=\"" . $framework->getCurrentUrl() . "&amp;remove=" . $employeeslist[$i]->getId() . "\">Poisto</a>";
                echo "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
}
?>