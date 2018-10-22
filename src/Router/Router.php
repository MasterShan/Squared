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
     * Variable for named routes
     */
    public static $names = [];
    
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
    public static function get($path, $callback, $params = [], $name = false)
    {
        if($name) {
            static::$names['get'][$name] = $path;
        }
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
    public static function post($path, $callback, $params = [], $name = false)
    {
        if($name) {
            static::$names['post'][$name] = $path;
        }
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
    
    public static function getUrl($method, $name)
    {
        if(isset(static::$names[$method][$name])) {
            return static::$names[$method][$name];
        }
        return false;
    }
    
}

?>