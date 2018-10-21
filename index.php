<?php
/*
+-------------------------------------------------------------------------------
| Require composer's autoloader. 
+-------------------------------------------------------------------------------
|
| Nothing special here, just grabbing the autoloader..
|
*/
require __DIR__ . "/vendor/autoload.php";

/*
+-------------------------------------------------------------------------------
| Initialize the framework using our bootstrapper.
+-------------------------------------------------------------------------------
|
| We require our bootstrapper so your glorious app will start running
|
*/
$app = require $_SERVER['DOCUMENT_ROOT'] . "/bootstrap/app.php";