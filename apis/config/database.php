<?php
class Database{
 
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "kseb_app";
    private $username = "root";
    private $password = "emobitkallan";
    public $conn;
 
    // get the database connection
    public function getConnection(){
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
			error_log('PDOException - ' . $exception->getMessage(), 0);
			http_response_code(500);
			die('Error establishing connection with database');
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}
?>