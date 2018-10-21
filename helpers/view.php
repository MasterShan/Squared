<?php
/**
 * View contents of a twig templated page
 */

if(!function_exists('view')) {
    function view($name, $data = []) {
		$twig = App\Templating\TwigHandle::get()->render($name . '.php', $data);
		
		echo $twig;
    }
}

?>