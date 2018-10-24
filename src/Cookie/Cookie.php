<?php

namespace Squared\Cookie;

use Squared\Cookie\CookieException;
use Squared\Security\Encryption;

class Cookie
{
    
    /**
     * @var $name
     */
    protected $name;
    
    /**
     * @var $data
     */
    protected $data;
    
    /**
     * @var duration
     */
    protected $duration;
    
    /**
     * @var dir
     */
    protected $dir;
    
    /**
     * Variable for encryption handler
     * @var $encrypt
     */
    private $encrypt;
    
    /**
     * Setup for encrypting cookie data
     */
    public function __construct()
    {
        $this->encrypt = new Encryption();
    }
    
    /**
     * Create a cookie
     * 
     * @param string $name
     * @param mixed  $data
     * @param int    $duration
     * @param string $dir
     */
    public function build($name, $data, $duration = 86400, $dir = '/')
    {
        $this->name = $this->encrypt->encrypt($name);
        $this->data = $data;
        $this->duration = $duration;
        $this->dir = $dir;
        
        $this->set();
    }
    
    /**
     * Set cookie variables and create it
     * 
     * @return bool status
     */
    public function set()
    {
        if(setcookie($this->name, $this->data, $this->duration, $this->dir)) {
            return true;
        }
        throw new CookieException("Failed setting cookie");
    }
    
    /**
     * Get a cookie variables data
     * 
     * @param string $variable
     * 
     * @return data|bool
     */
    public function get($variable)
    {
        if(isset($_COOKIE[$this->encrypt->encrypt($variable)])) {
            return $_COOKIE[$this->encrypt->encrypt($variable)];
        }
        return false;
    }
    
    /**
     * Unset a cookie value
     * 
     * @param string $variable
     * 
     * @return data|bool
     */
    public function delete($variable)
    {
        if(setcookie($this->encrypt->encrypt($variable), null, -1, '/')) {
            return true;
        }
        return false;
    }
    
    
}

?>