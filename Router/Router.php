<?php

namespace App\Router;

use App\Router\Route;

class Router
{
    
    /**
     * Url to pass parameters to
     * 
     * @var string $url
     */
    private static $url;
    
    /**
     * Table of defined routes
     * 
     * @var array $routes
     */
    private static $routes = [];
    
    /**
     * Initialize router
     */
    public static function init()
    {
        self::$url = $_GET['url'];
    }
    
    /**
     * Retrieve a page using GET
     * 
     * @param string $path
     * @param function $callback
     * @param array $params
     * 
     * @return function
     */
    public static function get($path, $callback, $params = [])
    {
        return self::add($path, $callback, $params, 'GET');
    }
    
    /**
     * Retrieve a page using POST
     * 
     * @param string $path
     * @param function $callback
     * @param array $params
     * 
     * @return function
     */
    public static function post($path, $callback, $params = [])
    {
        return self::add($path, $callback, $params, 'POST');
    }
    
    /**
     * Add a route to routes array
     * 
     * @param string $path
     * @param function $callback
     * @param string $method
     */
    public static function add($path, $callback, $params = [], $method)
    {
        $route = new Route($path, $callback, $params);
        self::$routes[$method][] = $route;
        
        return $route;
    }
    
    /**
     * Run the router
     * 
     * @return void
     */
    public static function run()
    {
        if(!isset(self::$routes[$_SERVER['REQUEST_METHOD']])) {
            throw new RouterException('Invalid REQUEST_METHOD passed');
        }
        
        foreach(self::$routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if($route->match(self::$url)) {
                return $route->call();
            }
        }
    }
    
}

?>