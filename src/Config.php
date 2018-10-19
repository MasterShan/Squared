<?php

namespace App;

class Config
{
    
    /**
     * @var config
     */
    public $config;
    
    /**
     * Set config with constructor
     */
    public function __construct()
    {
        $this->config = include(__DIR__ . "/../config.php");
    }
    
}