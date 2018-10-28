<?php

namespace Squared\Templating;

use Squared\Session\Session;
use Squared\Security\CsrfToken;


class TwigHandle
{
    
    /**
     * Create twig template handler
     * 
     * @return class
     */
    public static function get()
    {
        /**
         * Instantiate a new session and set CSRF if not set already.
         */
        if(!Session::getState()) {
            Session::init();
        }
        $session = new Session();
        
        if(is_null($session->get('_ex_csrf'))) {
            $session->build('_ex_csrf', CsrfToken::make());
        }
        
        /**
         * Creates the Twig Templating environment
         */
        $loader = new \Twig_Loader_Filesystem($_SERVER['DOCUMENT_ROOT'] . '/resources/views/');
        $twig = new \Twig_Environment($loader, ['cache' => $_SERVER['DOCUMENT_ROOT'] . '/resources/cache/']);
        
        /**
         * Adds the csrf input function
         */
        $twig->addFunction(new \Twig_SimpleFunction('get_csrf', function() {
            $session = new \App\Session\Session();
            echo '<input type="hidden" name="ex_csrf" value="'.$session->get('_ex_csrf').'">';
        }));
        
        /**
         * Adds the Router::getUrl function
         */
        $twig->addFunction(new \Twig_SimpleFunction('getUrl', function($method, $route) {
            return \Squared\Router\Router::getUrl($method, $route);
        }));
        
        /**
         * Returns self
         */
        return $twig;
    }
    
}

?>
