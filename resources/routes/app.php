<?php

use Squared\Router\Router;

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
| $router::request_method('path', 'callback fn', [fn params,optional])
|
| The callback can either be defined inline or name of an external function
| that can be found in a controller.
|
| Ex: $router::get('path', function() {
|         echo 'Hello world!';
|     });
|
| Ex: $router::post('path', 'MyController@setName', ['My name']);
|
| The view function defaults to using twig, if you don't want to use twig
| as a templating engine, add a false to the third view parameter.
|
*/
$router::get('/', function() {
    view('home', ['title' => 'Squared Project']);
}, 'home');

/*
+-------------------------------------------------------------------------------
| Return router
+-------------------------------------------------------------------------------
|
| Return the router so it'll be available with include/require.
|
*/
return $router;