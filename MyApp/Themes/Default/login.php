<h1>Kirjaudu sisään</h1>
<br />
<?php
    if(isset($_POST['email']) && isset($_POST['passwd']))
    {
        $status = $framework->checkLogin($_POST['email'], $_POST['passwd']);
        
        if(!$status)
            echo "<div class=\"alert alert-danger\">Käyttäjätunnus tai salasana väärin!</div>";
        else
            header("location: " . $framework->getBasePath());
    }
?>
<div class="loginform">
    <form method="post">
        <div class="form-group">
            <label for="email">Sähköposti</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Sähköposti" value="<?php @$_POST['email']; ?>">
        </div>
        <div class="form-group">
            <label for="password">Salasana</label>
            <input type="password" class="form-control" id="password" name="passwd" placeholder="Salasana">
        </div>
        <button type="submit" class="btn btn-primary">Kirjaudu sisään</button>
    </form>
</div>
<p>Unohditko salasanasi? Ei hätää, tilaa uusi salasana sähköpostiisi <a href="?lostpassword">tästä</a></p>
<p>Eikö vielä tunnusta? Ei hätää, luo itsellesi tunnus <a href="?register">tästä</a></p>
<script>
    document.getElementById("email").focus();
</script>