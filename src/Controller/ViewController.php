<?php

namespace App\Controller;

use App\Router\Router;

class ViewController extends Controller
{
    /**
     * Here you can add your views
     */
    public function home()
    {
        $this->view('home');
    }
    
}

?>