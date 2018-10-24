<?php
/**
 * View contents of a twig templated page
 */

if(!function_exists('view')) {
    function view($name, $data = [], $use_twig = true) {
        if($use_twig) {
            $twig = Squared\Templating\TwigHandle::get()->render($name . '.php', $data);
		    echo $twig;
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