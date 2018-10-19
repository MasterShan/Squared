<?php

namespace App\Database;

use \PDO;
use \PDOException;
use App\Config;

class Database
{
    
    /**
     * @var query
     */
    private $query;
    
    /**
     * @var db connections
     */
    private $server   = $this->config['DB_HOST'];
    private $database = $this->config['DB_NAME'];
    private $username = $this->config['DB_USER'];
    private $password = $this->config['DB_PASS'];
    
    /**
     * Instantiate PDO connection
     */
    public function __construct()
    {
        $this->config = include(__DIR__ . "/../../config.php");
        $dsn = "mysql:host=" . $this->server . ";dbname=" . $this->database . ";charset=utf8";
        
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password);
        }catch(PDOException $e) {
            die($e->getMessage);
        }
        
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		
		/* Remove in production */
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }
    
    /**
     * Set method to fetch one row
     */
    public function fetch($query) {
        
    }
    
    /**
     * Where clause
     */
    public function where($field, $operator, $value)
    {
        
    }
    
}

?>