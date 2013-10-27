<?php
session_start();
ob_start();
error_reporting(E_ALL);
ini_set('display_errors','On');

if(@$_SERVER["HTTPS"] != "on")
    header("location: https://".$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]);

spl_autoload_register(function($class) {
    $file = "../" . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

    if (is_file($file)) {
        include $file;
    }
});

$framework = new \MyApp\Hallinta();

if($framework->getUser())
    include("main.php");
else
    include("login.php");

ob_end_flush();
?>