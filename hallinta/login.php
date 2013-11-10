<!DOCTYPE HTML>
<?php
    if(isset($_POST['email']) && isset($_POST['passwd']))
    {
        $status = $framework->checkLogin($_POST['email'], $_POST['passwd']);
        
        if(!$status)
            echo "<div class=\"alert alert-danger\">Käyttäjätunnus tai salasana väärin!</div>";
        else
            header("location: " . $framework->getBasePath() . "hallinta");
    }
?>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
        <meta charset="utf-8">
        <title>Framework</title>
        <link href='https://fonts.googleapis.com/css?family=Scada' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo $framework->getBasePath(); ?>MyApp/Themes/extralib/font-awesome/css/font-awesome.min.css" />
        <link rel="stylesheet" href="<?php echo $framework->getBasePath(); ?>hallinta/css/input.css" />
        <link rel="stylesheet" href="<?php echo $framework->getBasePath(); ?>hallinta/css/login.css" />
        <script>var basepath = "<?php echo $framework->getBasePath(); ?>"</script>
    </head>
    <body>
		<div id="container">
			<div class="login-form">
				<form action="" method="POST" class="form-horizontal">
					<div class="control-group header">
							<h3>Tervetuloa!</h3>
							<p>Kirjaudu sisään!</p>
					</div>
					<div class="input-group form-group">
                        <i class="input-group-addon fa fa-user"></i>
                        <input type="text" id="email" class="form-control" placeholder="Käyttäjätunnus" name="email" />
					</div>
					<div class="input-group form-group">
                        <i class="input-group-addon fa fa-key"></i>
                        <input type="password" class="form-control" id="passwd" placeholder="Salasana" name="passwd" />
					</div>
					<div class="input-group form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Kirjaudu sisään</button>
					</div>
				</form>
			</div>
		</div>
    </body>
</html>