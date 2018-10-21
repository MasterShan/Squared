<?php

namespace App\Controller;

class Controller
{
    /**
     * Run a view
     */
    public function view($name, $data = []) {
    	extract($data);
    
    	$name = str_replace('.', '/', $name) . ".php";
    		
    	if (!file_exists("resources/views/$name")) {
    		throw new ControllerException('No views with this name');
    	} 
		
    	require_once("resources/views/$name");
    }
    
}