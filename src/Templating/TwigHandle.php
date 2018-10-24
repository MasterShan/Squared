<?php

namespace Squared\Templating;

use Squared\Session\Session;


class TwigHandle
{
    
    /**
     * Create twig template handler
     * 
     * @return class
     */
    public static function get()
    {
        if(!Session::getState()) {
            Session::init();
        }
        $session = new Session();
        
        if(is_null($session->get('_ex_csrf'))) {
            $session->build('_ex_csrf', bin2hex(random_bytes(32)));
        }
        
        $loader = new \Twig_Loader_Filesystem($_SERVER['DOCUMENT_ROOT'] . '/resources/views/');
        $twig = new \Twig_Environment($loader, ['cache' => $_SERVER['DOCUMENT_ROOT'] . '/resources/cache/']);
        
        $function = new \Twig_SimpleFunction('get_csrf', function() {
            $session = new \App\Session\Session();
            echo '<input type="hidden" name="ex_csrf" value="'.$session->get('_ex_csrf').'">';
        });
        
        $twig->addFunction($function);
        
        return $twig;
    }
    
}

?>