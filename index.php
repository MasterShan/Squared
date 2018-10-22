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
| We require our bootstrapper so your glorious app will start be initiated
| and be ready to run.
|
*/
$app = require __DIR__ . "/bootstrap.php";

/*
+-------------------------------------------------------------------------------
| Running the router
+-------------------------------------------------------------------------------
|
| We run the router so the routes will work
| Routes can be edited in /resources/routes/app.php
|
*/
$app->router::run();

?>