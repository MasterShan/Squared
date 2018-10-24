<?php

namespace Squared;

use Squared\Security\CsrfToken;
use Squared\Session\Session;
use Squared\Redirect\Redirect;

class Bootstrap
{
    
    /*
    +-------------------------------------------------------------------------------
    | Stitch the app together
    +-------------------------------------------------------------------------------
    |
    | Make the app have different variables for different
    | instances of classes.
    |
    */
    
    /**
     * @var router
     */
    public $router;
    
    /**
     * @var csrf
     */
    public $csrf;
    
    /**
     * @var session
     */
    public $session;
    
    /**
     * @var redirect
     */
    
    /**
     * Create and import instances of classes
     */
    public function __construct()
    {
        $this->router  = require $_SERVER['DOCUMENT_ROOT'] . "/resources/routes/app.php";
        $this->csrf = new CsrfToken();
        $this->session = new Session();
        $this->redirect = new Redirect();
    }
    
}

?>