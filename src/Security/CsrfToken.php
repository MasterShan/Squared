<?php

namespace Squared\Security;

use Squared\Session\Session;
use Squared\Config;

class CsrfToken
{
    
    /**
     * Variable to hold our session
     * 
     * @var class $session
     */
    private $session;
    
    /**
     * Setup for CSRF
     * 
     * Make new token if not already declared
     */
    public function __construct()
    {
        $this->session = new Session();
        if(!Session::getState()) {
            Session::init();
        }
        
        if(is_null($this->session->get('_ex_csrf'))) {
            $this->session->build('_ex_csrf', self::make());
        }

    }
    
    /**
     * Match if token given is matching session
     * 
     * @param mixed $token
     * 
     * @return bool
     */
    public function match($token)
    {
        if($token === $this->session->get('_ex_csrf')) {
            return true;
        }
        return false;
    }
    
    /**
     * Create new token
     *
     * @return token
     */
    public static function make()
    {
        return bin2hex(random_bytes(32));
    }
    
}

?>