<?php
/*
+-------------------------------------------------------------------------------
| Require composer's autoloader. 
+-------------------------------------------------------------------------------
|
| Nothing special here, we're just including the autoloader.
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
| The bootstrapper class contains the following classes.
|   - Router
|   - Session
|   - CSRF Tokens
|
| This means you can use the $app to access these classes or you can make
| your own instances of them.
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