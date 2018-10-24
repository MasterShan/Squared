<?php

namespace Squared\Database;

use \PDO;
use \PDOException;
use Squared\Config;

class Database
{
     
    /**
     * The SQL query to be executed
     * @var $query
     */
    private $query;
    
    /**
     * Query action (rowcount, fetch)
     * @var $action
     */
    private $action;
    
    /**
     * Values for prepared statements
     * @var $values
     */
    private $values = [];
    
    /**
     * Limit query results
     * @var $limit
     */
    private $limit = false;
    
    /**
     * @var db connections
     */
    private $server   = Config::SERVER;
    private $database = Config::DATABASE;
    private $username = Config::USERNAME;
    private $password = Config::PASSWORD;
    
    /**
     * Instantiate PDO connection
     */
    public function __construct()
    {
        /* Set our connection dsn */
        $dsn = "mysql:host=" . $this->server . ";dbname=" . $this->database . ";charset=utf8";
        
        /* Setup connection */
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password);
        }catch(PDOException $e) {
            die($e->getMessage);
        }
        
        /* Set fetch to FETCH_ASSOC by default */
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		
		/* Remove in production */
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }
    
    /**
     * Set method to fetch one row
     * 
     * @param string $query
     * 
     * @return this
     */
    public function fetch($query) {
        /* Start query building */
        $this->query = $query;
        
        /* Set execution action to fetch data */
        $this->action = 'fetch';
        
        /* Return self */
        return $this;
    }
    
    /**
     * Run any query
     * 
     * @param string $query
     * 
     * @return this
     */
    public function runQuery($query)
    {
        /* Start building query */
        $this->query = $query;
        
        /* Return self */
        return $this;
    }
    
    /**
     * Insert into table
     * 
     * @param string $table
     * @param array  $args
     * 
     * @return this
     */
    public function insert($table, $args = [])
    {
        /* Placeholders for inserting data */
        $fields = [];
        $params = [];
        
        /* Turn array into query values */
        foreach($args as $k => $v) {
            $fields[] = $this->backtick($k);
            $params[] = '?';
        }
        
        /* Implode arrays into strings to insert */
        $fields = implode($fields, ',');
        $params = implode($params, ',');
        
        /* Backtick table name */
        $table = $this->backtick($table);
        
        /* Start building query */
        $this->query = "INSERT INTO $table ($fields) VALUES ($params)";
        
        /* Set query values */
        $this->args(array_values($args));
        
        /* Return self */
        return $this;
    }
    
    /**
     * Get amount of rows
     * 
     * @param string $query
     * 
     * @return this
     */
    public function rows($query)
    {
        /* Start building query */
        $this->query = $query;
        
        /* Set execution action to count rows */
        $this->action = 'rows';
        
        /* Return self */
        return $this;
    }
    
    /**
     * Delete row(s) from given table
     * 
     * @param string $table
     *
     * @return this
     */
    public function delete($table)
    {
        /* Backtick table name */
        $table = $this->backtick($table);
        
        /* Start building query */
        $this->query = 'DELETE FROM ' . $table;
        
        /* Return self */
        return $this;
    }
    
    /**
     * Update row(s) in given table
     * 
     * @param string $table
     * @param array  $args
     * 
     * @return this
     */
    public function update($table, $args = [])
    {
        /* Placeholder for our fields */
        $fields = [];
        
        /* Turn array into value => key and put inside
           Our placeholder array */
        foreach($args as $k => $v) {
            $fields[] = $k . ' = ?';
        }
        
        /* Implode our fields to fit query */
        $fields = implode($fields, ', ');
        
        /* Backtick table name */
        $table = $this->backtick($table);
        
        /* Start building query */
        $this->query = 'UPDATE ' . $table . ' SET ' . $fields;
        
        /* Set values for execution */
        $this->args(array_values($args));
        
        /* Return self */
        return $this;
    }
    
    /**
     * Where clause
     * 
     * @param $field
     * @param $operator
     * @param $value
     * 
     * @return this
     */
    public function where($field, $operator, $value, $args = false)
    {
        /* Quote if string */
        if(is_string($value)) {
            $value = $this->quote($value);
        }
        
        /* If special arguments do action */
        if($args) {
            switch(strtolower($args)) {
                case "not":
                    /* Start building query */
                    $this->query .= ' WHERE NOT ('. $field.' '. $operator .' '. $value .')';
                    break;
                default:
                    /* Throw error if special action not found */
                    throw new DatabaseException("Invalid argument method.");
            }
        }else{
            /* Start building query */
            $this->query .= ' WHERE ('. $field.' '. $operator .' '. $value .')';
        }
        
        /* Return self */
        return $this;
    }
    
    /**
     * And clause
     * 
     * @param $field
     * @param $operator
     * @param $value
     * 
     * @return this
     */
    public function and($field, $operator, $value)
    {
        /* Quote if string */
        if(is_string($value)) {
            $value = $this->quote($value);
        }
        /* Start building query */
        $this->query .= ' AND ('. $field.' '. $operator .' '. $value .')';
        
        /* Return self */
        return $this;
    }
    
    /**
     * Between clause
     * 
     * @param string $field
     * @param mixed  $value1
     * @param mixed  $value2
     * @param bool   $not
     * 
     * @return this
     */
    public function between($field, $value1, $value2, $not = false)
    {
        /* Quote if string */
        if(is_string($value1)) {
            $value1 = $this->quote($value1);
        }
        
        /* Quote if string */
        if(is_string($value2)) {
            $value2 = $this->quote($value2);
        }
        
        /* If not query then add not clause */
        if(!$not) {
            /* Start building query */
            $this->query .= ' WHERE (' . $field . ' BETWEEN ' . $value1 . ' AND ' . $value2 .')';
        }else{
            /* Start building query */
            $this->query .= ' WHERE (' . $field . ' NOT BETWEEN ' . $value1 . ' AND ' . $value2 .')';
        }
        
        /* Return self */
        return $this;
    }
    
    /**
     * Set execute args
     * 
     * @param array $args
     * 
     * @return this
     */
    public function args($args = [])
    {
        /* Set arguments array for execution */
        $this->values = $args;
        
        /* Return self */
        return $this;
    }
    
    /**
     * Get current query (debugging)
     * 
     * @return this->query
     */
    public function getQuery()
    {
        /* Return self->query */
        return $this->query;
    }
    
    /**
     * Add backticks
     * 
     * @param string $input
     * 
     * @return string input
     */
    public function backtick($input) {
        /* If the input is a ? placeholder => don't */
        if(!($input == "?")) {
            /* Return backticked string */
            return "`".str_replace("`", "``", $input)."`";
        }
        
        /* Return input, sanitized or not */
        return $input;
    }
    
    /**
     * Add doublequotes to input
     * 
     * @param string $inpit
     * 
     * @return string input
     */
    public function quote($input) {
        /* If te input is a ? placeholder => don't */
        if(!($input == "?")) {
            /* Return doublequoted string */
            return '"'.str_replace('"', '""', $input).'"';
        }
        /* Return input, sanitized or not */
        return $input;
    }
    
    /**
     * Set a limit to fetch
     * 
     * @param $limit
     * 
     * @return this
     */
    public function limit($max)
    {
        $this->limit = intval($max);
        return $this;
    }
    
    /**
     * Run query from self->query
     * 
     * @return int|array|this
     */
    public function execute()
    {
        /* If there's a select limit, capitalize on it */
        if($this->limit) {
            $this->query .= ' LIMIT ' . $this->limit;
        }
        
        /* If executement arguments has values, execute statement with
           the values */
        if(count($this->values) != 0) {
            /* Execute query in prepared format */
            $request = $this->pdo->prepare($this->getQuery());
            
            /* Append values to execute */
            $request->execute($this->values);
        }else if(count($this->values) == 0) {
            /* Run query if values is empty */
            $request = $this->pdo->query($this->getQuery());
        }
        /* Reset values array for next query */
        $this->values = [];
        
        /* If execution action is fetch, return ->fetchAll(); */
        if($this->action == 'fetch') {
            return $request->fetchAll();
        }
        
        /* If execution action is rows, return ->rowCount(); */
        if($this->action == 'rows') {
            return $request->rowCount();
        }
        
        /* Else return self */
        return $this;
    }
    
}

?>