<?php

namespace App\Session;

use App\Session\SessionException;
use App\Security\Encryption;

class Session
{
    
    /**
     * Handler for encryption object
     */
    protected $encrypt;
    
    /**
     * Name for session variable
     * @var $name
     */
    protected $name;
    
    /**
     * Content for session variable
     * @var $content
     */
    protected $content;
    
    /**
     * Start session
     */
    public static function init()
    {
        session_start();
    }
    
    /**
     * End session
     */
    public static function end()
    {
        foreach($_SESSION as $v => $k)
        {
            unset($_SESSION[$v]);
        }
        session_destroy();
    }
    
    /**
     * Instantiate the encryption object
     */
    public function __construct()
    {
        $this->encrypt = new Encryption();
    }
    
    /**
     * Create a session variable
     * 
     * @param string $name
     * @param mixed  $content
     */
    public function build($name, $content)
    {
        $this->name = $name;
        $this->content = $content;
        
        $this->set();
    }
    
    /**
     * Set variable
     */
    public function set()
    {
        if(isset($_SESSION[$this->name])) {
            throw new SessionException("This session variable already exists");
        }
        $_SESSION[$this->encrypt->encrypt($this->name, true)] = $this->encrypt->encrypt($this->content, true);
    }
    
    /**
     * Get variable
     * 
     * @param string $name
     * @return $data|void
     */
    public function get($name)
    {
        $name = $this->encrypt->encrypt($name, true);
        if(isset($_SESSION[$name])) {
            return $this->encrypt->decrypt($_SESSION[$name], true);
        }
        
        return null;
    }
    
    /**
     * Unset variable
     * 
     * @param string $name
     */
    public function delete($name)
    {
        $name = $this->encrypt->encrypt($name, true);
        if(isset($_SESSION[$name])) {
            unset($_SESSION[$name]);
        }
    }
    
}

?>