<?php

namespace app\config;

use Exception;
use PDO;

class Connection {
    protected $servername = "localhost";
    protected $database = "practices";
    protected $username = "root";
    protected $password = "@dm1n";

    public function __construct($servername = "localhost", $database = "practices", $username = "root", $password = "@dm1n") {
        $this->servername = $servername;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
    }

    public function connect() {
        try {
            
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $conn;
        } catch (Exception $e) {
            echo "Error caught: " . $e->getMessage();
        }
    }
}

?>