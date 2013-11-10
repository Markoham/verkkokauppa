<h1>Luo uusi käyttäjätunnus</h1>
<br />
<?php
if(isset($_POST['etunimi']) && isset($_POST['sukunimi']) && isset($_POST['email']) && isset($_POST['passwd']))
{
    if($framework->validEmail($_POST['email']))
    {
        $status = $framework->addAsiakkas($_POST['etunimi'], $_POST['sukunimi'], $_POST['email'], $_POST['passwd']);
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
<div class="loginform">
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
        <button type="submit" class="btn btn-primary">Kirjaudu sisään</button>
    </form>
</div>