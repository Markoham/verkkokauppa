<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
        <meta charset="utf-8">
        <title>Framework</title>
        <?php $framework->importExtralibs(); ?>
        <link rel="stylesheet" href="<?php echo $framework->getThemeUrlPath(); ?>css/style.css" />
        <script type="text/javascript" href="<?php echo $framework->getThemeUrlPath(); ?>js/menu.js"></script>
    </head>
    <body>
        <div class="grid-container">
          <div class="grid-100">
            <div id="logo"><h1><a href="<?php echo $framework->getBasePath(); ?>">Kahvimaailma</a></h1></div>
          </div>
          <div class="grid-20">
              <div id="nav"><?php $framework->getKategoriat(); ?></div>
          </div>
          <div class="grid-80">
              <div id="content"><?php $framework->getPageContent(); ?></div>
          </div>
        </div>
        <script>
        
var linkit = document.querySelectorAll("#nav a.paakategoria");
for(var i = 0, l = linkit.length; i < l; i++)
{
    link = linkit[i];
    
    link.addEventListener('click', function(e){
        console.log(link.className);
    });
}
        </script>
    </body>
</html>