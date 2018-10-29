<?php
/**
 * View contents of a twig templated page
 */

if(!function_exists('view')) {
    function view($name, $data = [], $use_twig = true) {
        if($use_twig) {
            
            if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/resources/views/$name.php")) {
                $twig = Squared\Templating\TwigHandle::get()->render($name . '.php', $data);
		        echo $twig;
            }else{
		    /* Path to 404 document, Home by default. */
                $twig = Squared\Templating\TwigHandle::get()->render('home' . '.php', []);
                echo $twig;
            }
            
        }else{
            extract($data);
            
            $name = str_replace('.', '/', $name) . ".php";
		
		    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/resources/views/$name")) {
		    	throw new Exception('No views with this name');
		    } 
		
		    require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/views/$name");
        }
    }
}

?>
