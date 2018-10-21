<?php

use App\Router\Router;

/*
+-------------------------------------------------------------------------------
| Create our instance of the Router class
+-------------------------------------------------------------------------------
|
| We create a handle for the router class.
|
*/
$router = new Router();

/*
+-------------------------------------------------------------------------------
| Initializing our router
+-------------------------------------------------------------------------------
|
| This starts our router.
|
*/
$router::init();

/*
+-------------------------------------------------------------------------------
| Add your own routes
+-------------------------------------------------------------------------------
|
| Here you can create your own routes. The format for a route is as follows
|
| $router::request_method('path', 'callback fn', [function params,optional])
|
| The callback can either be defined inline or name of an external function
| Ex: $router::get('path', function() {
|         echo 'Hello world!';
|     });
|
| Ex: $router::post('path', 'is_string', ['mystring']);
|
*/
$router::get('/', function() {
    view('header');
    view('home', ['name' => 'Grecko']);
});
/*
+-------------------------------------------------------------------------------
| Running the router
+-------------------------------------------------------------------------------
|
| We run the router so the routes will work
|
*/
$router::run();

/*
+-------------------------------------------------------------------------------
| Return router
+-------------------------------------------------------------------------------
|
| Return the router so it'll be available with include/require.
|
*/
return $router;