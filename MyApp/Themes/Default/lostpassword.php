<h1>Tilaa uusi salasana sähköpostiisi</h1>
<br />
<?php
    if(isset($_POST['email']))
    {
        
    }
    else
    {
?>
<div class="lostpasswordform">
    <form method="post">
        <div class="form-group">
            <label for="email">Sähköposti</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Sähköposti">
        </div>
        <button type="submit" class="btn btn-primary">Tilaa salasana</button>
    </form>
</div>
<?php
    }
?>