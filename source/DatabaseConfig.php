<?php

class DatabaseConfig {

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
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db);
        return $this->conn;
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
function getData($table, $where=''){
        $whereCond = '';
        $response = array();
        if($where) {
            $whereCond = " Where" .$where;
        }
        $sql = "SELECT * FROM ".$table."".$whereCond;  
        $sql = $this->conn->query($sql);
        while($row = $sql->fetch_assoc()){
             $response[] = $row;
        }

        return $response;
}
function updateData($table, $update_value, $where){
        $this->connect();
        $sql = "UPDATE ".$table." SET ".$update_value." WHERE ".$where;        
        $sql = $this->conn->query($sql);
        if($sql == true){
            return true;
        }else{
            return false;
        }
    }
function createData($table, $columns, $values){
        $this->connect();
        $sql = "INSERT INTO ".$table." ( ".$columns." ) VALUES ( ".$values.")";   
        $sql = $this->conn->query($sql);
        if($sql == true){
            return $this->conn->insert_id;
        }else{
            return false;
        }
    }
function deleteData($table, $filter){
       
        $this->connect();
        $sql =  "DELETE FROM ".$table." ".$filter;  
        $sql = $this->conn->query($sql);
        if($sql == true){
            return true;
        }else{
            return false;
        }
    }

function getById($table, $where=''){
        $whereCond = '';
        $response = array();
        if($where) {
            $whereCond = " Where" .$where;
        }
        $sql = "SELECT * FROM ".$table."".$whereCond;         
        $sql = $this->conn->query($sql);
        $response = $sql->fetch_assoc();
        return $response;
}
   
}
