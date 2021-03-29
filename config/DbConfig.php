<?php

class DbConfig {

protected $host;
protected $username;
protected $password;
protected $db;
protected $conn;

function __construct(){
	   $this->host = 'localhost';
       $this->username = 'root' ;
       $this->password = '' ;
       $this->db = 'sage' ;      
       $this->connect();
      
}

public function connect(){

        $this->conn = mysqli_connect("localhost", "root", "", "sage");
        return $this->conn;
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
}

public function pdoConnect(){

		//$dsn = 'mysql:dbname=sage;host=localhost;';
        try {
        $this->conn = 	new PDO("mysql:host=localhost;dbname=sage", "root", "");
       return $this->conn;
		 return $this->conn;
		} catch(PDOException $e) {
		  echo "Error: " . $e->getMessage() . "<br>";
		  die();
		}
} 
}
?>