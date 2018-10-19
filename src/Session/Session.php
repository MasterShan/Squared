<?php

namespace App\Session;

use App\Session\SessionException;

class Session
{
    
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
    
}

?>