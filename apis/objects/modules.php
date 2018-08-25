<?php
class modules{
 
    // database connection and table name
    private $conn;
    private $table_name = "modules";
 
	//`m_id``m_discription``m_location``lat``lon``api_token`
    // object properties
    public $m_id;
    public $m_discription;
    public $m_location;
    public $lat;
	public $lon;
	public $api_token;
 
    public function __construct($db){
        $this->conn = $db;
    }
 
	
	public function read(){
    //select all data
    $query = "SELECT * FROM " . $this->table_name . " WHERE m_discription='" . $this->m_discription . "'";
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
 
    return $stmt;
	}

	
	function create(){
	// query to insert record
    $query = "INSERT INTO " . $this->table_name . "(m_id,m_discription,m_location,lat,lon,api_token) VALUES (:m_id,:m_discription,:m_location,:lat,:lon,:api_token) ";
    // prepare query
    $stmt = $this->conn->prepare($query);
    // sanitize m_id
    $this->m_id=htmlspecialchars(strip_tags($this->m_id));
	$this->m_discription=htmlspecialchars(strip_tags($this->m_discription));
    $this->m_location=htmlspecialchars(strip_tags($this->m_location));
    $this->lat=htmlspecialchars(strip_tags($this->lat));
    $this->lon=htmlspecialchars(strip_tags($this->lon));
    $this->api_token=htmlspecialchars(strip_tags($this->api_token));
    // bind values
    $stmt->bindParam(":m_id", $this->m_id);
	$stmt->bindParam(":m_discription", $this->m_discription);
    $stmt->bindParam(":m_location", $this->m_location);
    $stmt->bindParam(":lat", $this->lat);
    $stmt->bindParam(":lon", $this->lon);
    $stmt->bindParam(":api_token", $this->api_token);	
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}


}
?>