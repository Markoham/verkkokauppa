<?php
error_reporting(E_ALL);
ini_set('display_errors','On');

spl_autoload_register(function($class) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

    // NOTE: Ladataan tiedosto vain, jos se on olemassa. Mikäli tiedostoa ei löydy,
    // ei tehdä mitään, koska sovelluksessa voi olla useita autoloadereita,
    // joista jokin myöhemmin triggeröitävä osaa ladata luokan.
    if (is_file($file)) {
        include $file;
    }
});

$framework = new \MyApp\Verkkokauppa();

include($framework->getThemepath() . "index.php");
// http://www.ohjelmointiputka.net/keskustelu/26544-oman-funktiokirjaston-rakentaminen/sivu-1
?>