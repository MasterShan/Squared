<?php

namespace App\Controller;

use App\Router\Router;

class ViewController extends Controller
{
    /**
     * Here you can add your views
     * 
     * These are the callback functions to the router
     */
    public function home()
    {
        $this->view('header');
        $this->view('home');
    }
    
}

?>