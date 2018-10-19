<?php 

namespace App\Router;

use App\Router\Route;
use App\Router\RouterException;

class Router {

	/**
	 * URL parameter
	 * @var string
	 */
	private static $url;

	/**
	 * Array of routes
	 * @var array
	 */
	private static $routes = [];

	/**
	 * Routes names
	 * @var array
	 */
	private static $namedRoutes = [];

	/**
	 * Initialize the router
	 * @return void
	 */
	public static function init() {
		self::$url = $_GET['url'];
	}

	/**
	 * Retrieve a GET page
	 * @param  string
	 * @param  function
	 * @return route
	 */
	public static function get($path, $callable, $name = null) {
		return self::add($path, $callable, $name, 'GET');
	}

	/**
	 * Retrive a POST page
	 * @param  string
	 * @param  function
	 * @return route
	 */
	public static function post($path, $callable, $name = null) {
		return self::add($path, $callable, $name, 'POST');
	}

	/**
	 * Add a page to router
	 * @param string
	 * @param function
	 * @param string 'GET, POST, ...'
	 */
	private static function add($path, $callable, $name, $method) {
		$route = new Route($path, $callable);
		self::$routes[$method][] = $route;

		if ($name) {
			self::$namedRoutes[$name] = $route;
		}

		return $route;
	}

	/**
	 * Run router
	 * @return function
	 */
	public static function run() {
		if (!isset(self::$routes[$_SERVER['REQUEST_METHOD']])) {
			throw new RouterException('REQUEST_METHOD doesn\'t exist');
		}

		foreach(self::$routes[$_SERVER['REQUEST_METHOD']] as $route) {
			if ($route->match(self::$url)) {
				return $route->call();
			}
		}
		throw new RouterException('No matching routes');
	}

	/**
	 * Return URL if match was found
	 * @param  string
	 * @param  array
	 * @return string
	 */
	public static function url($name, $params = []) {
		if (!isset(self::$namedRoutes[$name])) {
			throw new RouterException("No routes matches this name '$name'.");
		}

		return self::$namedRoutes[$name]->getUrl($params);
	}

}