<?php
class kseb{
 
    // database connection and table name
    private $conn;
    private $table_name = "kseb1";
 
    //`sn`times``m_id``battery_volt``charger_volt``present_volt``set_volt``interrupt``fault_level`
    // object properties
    public $sn;
	public $times;
	public $m_id;
    public $bvolt;
    public $cvolt;
    public $pvolt;
    public $svolt;
    public $interrupt;
    public $flevel;
	public $starttime;
	public $endtime;

    // constructor with $db as database connection
    public function __construct($db){
		$this->m_id=-1;
		date_default_timezone_set("Asia/Calcutta"); 
		$this->endtime=time();
		$this->starttime=$this->endtime-60;
        $this->conn = $db;
    }
	
function read(){
    // select all query
    $query = "SELECT * FROM " . $this->table_name . " ORDER BY " . $this->table_name . ".sn ASC";
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    return $stmt;
}

function read_last(){
	//eg: SELECT * FROM kseb1 WHERE times =(SELECT MAX(times) FROM kseb1 WHERE m_id=2 GROUP BY m_id)	
	$query = "SELECT * FROM " . $this->table_name . " WHERE times =(SELECT MAX(times) FROM " . $this->table_name . " WHERE m_id=" . $this->m_id . " GROUP BY m_id)";
	// prepare query statement
    $stmt = $this->conn->prepare($query);
	// execute query
    $stmt->execute();
    return $stmt;
}

function read_between(){
	//eg: SELECT * FROM kseb1 WHERE times IN (SELECT times FROM kseb1 WHERE (m_id=0) AND (times BETWEEN 1531914596 AND 1531918502) GROUP BY m_id)	
	$query = "SELECT * FROM " . $this->table_name . " WHERE times IN (SELECT times FROM " . $this->table_name . " WHERE (m_id=" . $this->m_id . ") AND (times BETWEEN " . $this->starttime . " AND " . $this->endtime . ") GROUP BY m_id)";
	// prepare query statement
    $stmt = $this->conn->prepare($query);
	// execute query
    $stmt->execute();
    return $stmt;
}

function read_minute(){
	$this->endtime=time();
	$this->starttime=$this->endtime-60;
	//SELECT * FROM kseb1 WHERE times IN (SELECT times FROM kseb1 WHERE (m_id=0) AND (times BETWEEN 1531914596 AND 1531918502) GROUP BY m_id)	
	$query = "SELECT * FROM " . $this->table_name . " WHERE times IN (SELECT times FROM " . $this->table_name . " WHERE (m_id=" . $this->m_id . ") AND (times BETWEEN " . $this->starttime . " AND " . $this->endtime . ") GROUP BY m_id)";
	// prepare query statement
    $stmt = $this->conn->prepare($query);
	// execute query
    $stmt->execute();
    return $stmt;
}


// create entry
function create(){
	// query to insert record
    $query = "INSERT INTO " . $this->table_name . "(times,m_id,battery_volt,charger_volt,present_volt,set_volt,interrupt,fault_level) VALUES (:times,:m_id,:bvolt,:cvolt,:pvolt,:svolt,:interrupt,:flevel) ";
    // prepare query
    $stmt = $this->conn->prepare($query);
    // sanitize m_id
    $this->times=htmlspecialchars(strip_tags($this->times));
	$this->m_id=htmlspecialchars(strip_tags($this->m_id));
    $this->bvolt=htmlspecialchars(strip_tags($this->bvolt));
    $this->cvolt=htmlspecialchars(strip_tags($this->cvolt));
    $this->pvolt=htmlspecialchars(strip_tags($this->pvolt));
    $this->svolt=htmlspecialchars(strip_tags($this->svolt));
	$this->interrupt=htmlspecialchars(strip_tags($this->interrupt));
    $this->flevel=htmlspecialchars(strip_tags($this->flevel));
    // bind values
    $stmt->bindParam(":times", $this->times);
	$stmt->bindParam(":m_id", $this->m_id);
    $stmt->bindParam(":bvolt", $this->bvolt);
    $stmt->bindParam(":cvolt", $this->cvolt);
    $stmt->bindParam(":pvolt", $this->pvolt);
    $stmt->bindParam(":svolt", $this->svolt);
	$stmt->bindParam(":interrupt", $this->interrupt);
    $stmt->bindParam(":flevel", $this->flevel);
	
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
	
	}