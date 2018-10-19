<?php

namespace App\Controller;

class Controller
{
    
    /**
     * Create view
     */
    public function view($name, $data = []) {
		// Remplace l'appel des variables de $data['donnee'] à $donnee
		extract($data);

		$name = str_replace('.', '/', $name) . ".php";
		
		if (!file_exists("resources/views/$name")) {
			throw new ControllerException('No views with this name');
		} 
		
		require_once("resources/views/$name");
	}
    
}