<?php
/**
 * Package helper functions
 */
if(!function_exists('view')) {
    function view($name, $data = []) {
		// Remplace l'appel des variables de $data['donnee'] à $donnee
		extract($data);

		$name = str_replace('.', '/', $name) . ".php";
		
		if (!file_exists(__DIR__ . "/resources/views/$name")) {
			die("Invalid view");
		} 
		
		require_once(__DIR__ . "/resources/views/$name");
	}
}

?>