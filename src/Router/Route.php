<?php

namespace App\Router;

class Route
{
    
    /**
     * Store the path
     *
     * @var string $path
     */
    private $path;
    
    /**
     * Store callback function
     * 
     * @var function $callback
     */
    private $callback;
    
    /**
     * Hold onto callback parameters
     */
    private $params = [];
    
    /**
     * Create new instance
     * 
     * @param string $path
     * @param function $callback
     */
    public function __construct($path, $callback, $params = [])
    {
        $path = trim($path, '/');
        $this->callback = $callback;
        $this->params = $params;
        
        if($path === '') {
            $this->path = '/';
        }else{
            $this->path = $path;
        }
    }
    
    /**
     * Check if passed url is instance url
     *
     * @param string $url
     * 
     * @return bool
     */
    public function match($url)
    {
        $url = trim($url, '/');
        if($url === '') {
            $url = '/';
        }
        
        if($url == $this->path) {
            return true;
        }
        return false;
    }
    
    /**
     * Call the callback
     * 
     * @return function
     */
    public function call()
    {
        return call_user_func_array($this->callback, $this->params);
    }
    
}