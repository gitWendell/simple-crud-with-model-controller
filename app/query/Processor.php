<?php

namespace app\query;

use app\config\Connection;
use Exception;

class Processor extends Connection{
    protected $query;
    protected $connection;
    protected $table;
    protected $sql;
    public $print;

    public function __construct($query) {
        $connection = new Connection();

        $this->connection = $connection->connect();
        $this->query = $query;
        $this->table = $query['table'];
        $this->printOnly = false;
    }

    public function process() {
        $action = strtoupper($this->query['action']);

        if($action == "SELECT") return $this->select();
        if($action == "INSERT") return $this->insert();
        if($action == "UPDATE") return $this->update();
        if($action == "DELETE") return $this->delete();

        throw new Exception("Could not fine action");
    }

    public function select() {
        $selector = $this->query['selector'];
        $this->sql = "SELECT $selector FROM $this->table";

        if($this->query['where']) $this->addWhere();

        return $this->execute()->fetchAll();
    }

    public function insert() {
        $this->sql = "INSERT INTO $this->table (".$this->query['columns'].") 
                      VALUES (" .$this->query['values'].")";
        return $this->execute();
    }

    public function update() {
        $this->sql = "UPDATE $this->table SET " . $this->query['values'];

        if($this->query['where']) $this->addWhere();

        return $this->execute();
    }
    
    public function delete() {
        $this->sql = "DELETE FROM $this->table";

        if($this->query['where']) $this->addWhere();

        return $this->execute();
    }

    public function execute() {
        
        if($this->print) echo $this->sql;

        return $this->connection->query($this->sql);
    }

    public function addWhere() {
        $this->sql = $this->sql . ' WHERE ' . $this->query['where'];

        return $this;
    }

}

?>