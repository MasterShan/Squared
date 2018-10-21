<?php

namespace App\Security;

use App\Session\Session;
use App\Config;

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
        
        if(is_null($session->get('_ex_csrf'))) {
            $session->build('_ex_csrf', bin2hex(random_bytes(32)));
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
        if($token === $session->get('_ex_csrf')) {
            return true;
        }
        return false;
    }
    
}

?>