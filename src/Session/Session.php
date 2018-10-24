<?php

namespace Squared\Session;

use Squared\Session\SessionException;
use Squared\Security\Encryption;

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
     * If session is initialized
     */
    static $state = false;
    
    
    /**
     * Start session
     */
    public static function init()
    {
        if(!self::getState()) {
            self::start();
        }
    }
    
    public static function start()
    {
        session_start();
        self::setState(true);
    }
    
    /**
     * Set state
     * 
     * @param bool $state
     */
    public static function setState($state)
    {
        self::$state = $state;
    }
    
    /**
     * Get state
     * 
     * @return self::state
     */
    public static function getState()
    {
        return self::$state;
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
        self::setState(false);
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
        if(isset($_SESSION[$this->encrypt->encrypt($this->name)])) {
            throw new SessionException("This session variable already exists");
        }
        $_SESSION[$this->encrypt->encrypt($this->name, true)] = $this->content;
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