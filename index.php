<?php

require __DIR__ . "/vendor/autoload.php";

use App\Router\Router;

use App\Config;

use App\Session\Session;

/*
|-------------------------------------------------------------------------------
| Initialize the router and session
|-------------------------------------------------------------------------------
| Here we initialize the router so we can get our different views and pages.
| We also start our session.
*/
Router::init();
Session::init();


/*
|-------------------------------------------------------------------------------
| Define our routes
|-------------------------------------------------------------------------------
| Let's define some routes for our beautiful webpage
|
| We can define the callbacks in src/Controller/ViewController.
*/
Router::get('/', 'ViewController@home', 'home');


/*
|-------------------------------------------------------------------------------
| Run our router
|-------------------------------------------------------------------------------
| Running our router so everything is good to go.
*/
Router::run();