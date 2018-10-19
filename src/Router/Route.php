<?php 

namespace App\Router;

use App\Router\RouterException;

class Route {

	/**
	 * Path to route
	 * @var string $path
	 */
	private $path;

	/**
	 * Callback function
	 * @var function $callable
	 */
	private $callable;

	/**
	 * Matches of routes
	 * @var array
	 */
	private $matches = [];

	/**
	 * Route parameters
	 * @var array
	 */
	private $params = [];

	/**
	 * @param string
	 * @param function
	 */
	public function __construct($path, $callable) {
		$this->path = trim($path, '/');
		$this->callable = $callable;
	}

	/**
	 * Add conditions to route
	 * @param  param $param
	 * @param  regex expression $regex
	 * @return route
	 */
	public function with($param, $regex) {
		$this->params[$param] = str_replace('(', '(?:', $regex);
		return $this;
	}

	/**
	 * Check if we find a match
	 * @param  url
	 * @return boolean
	 */
	public function match($url) {
		$url = trim($url, '/');
		$path = preg_replace_callback('#{([\w]+)}#', [$this, 'paramMatch'], $this->path);
		$regex = "#^$path$#i";

		if (!preg_match($regex, $url, $matches)) {
			return false;
		}

		array_shift($matches);
		$this->matches = $matches;

		return true;
	}

	/**
	 * Check if match params matches our array
	 * @param  match
	 * @return regex
	 */
	private function paramMatch($match) {
		if (isset($this->params[$match[1]])) {
			return '(' . $this->params[$match[1]] . ')';
		}

		return '([^/]+)';
	}

	/**
	 * We call the function callback passed in the constructor
	 * @return function
	 */
	public function call() {
		if (is_string($this->callable)) {
			$params = explode('@', $this->callable);
			$controller = "App\\Controller\\" . $params[0];

			$controller = new $controller();
			
			return call_user_func_array([$controller, $params[1]], $this->matches);
		} else {
			return call_user_func_array($this->callable, $this->matches);
		}
	}

	/**
	 * Returns the route with given params
	 * @param  array
	 * @return string
	 */
	public function getUrl($params) {
		$path = $this->path;
		foreach($params as $k => $v) {
			$path = str_replace("{" . $k . "}", $v, $path);
		}

		if (isset($_SERVER['HTTPS'])) {
			return 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . $path;
		}
		
		return 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . $path;
	} 

}