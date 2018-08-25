<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate kseb object
include_once '../objects/kseb.php';
 
$database = new Database();
$db = $database->getConnection();
 
$kseb = new kseb($db);
date_default_timezone_set("Asia/Calcutta"); 

if(isset($_GET['m_id'])){
	if(isset($_GET['token'])){
    $query = "SELECT * FROM modules WHERE m_id='" . validate($_GET['m_id']) . "'" ;
    $stmt = $db->prepare($query);
    $stmt->execute();
	$num = $stmt->rowCount();
	if($num>0){
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row['api_token']!==validate($_GET['token'])){
			die('{"message": "Unable to connect"}');
		}
	}else{
	die('{"message": "Unable to connect"}');
}	
	}else{
	die('{"message": "Unable to connect"}');
}	
}else{
	die('{"message": "Unable to connect"}');
}




// set kseb property values
//$kseb->sn = isset($_GET['sn']) ? $_GET['sn'] : die();
$kseb->times = time();
$kseb->m_id = isset($_GET['m_id']) ? $_GET['m_id'] : die();
$kseb->bvolt = isset($_GET['bvolt']) ? $_GET['bvolt'] : die();
$kseb->cvolt = isset($_GET['cvolt']) ? $_GET['cvolt'] : die();
$kseb->pvolt = isset($_GET['pvolt']) ? $_GET['pvolt'] : die();
$kseb->svolt = isset($_GET['svolt']) ? $_GET['svolt'] : die();
$kseb->interrupt = isset($_GET['interrupt']) ? $_GET['interrupt'] : die();
$kseb->flevel = isset($_GET['flevel']) ? $_GET['flevel'] : die();
 
// create the kseb
if($kseb->create()){
    echo '{';
        echo '"message": "kseb was created on ';
		echo date("Y-m-d h:i:s a",$kseb->times); 
		echo '"';
    echo '}';
}
 
// if unable to create the kseb, tell the user
else{
    echo '{';
        echo '"message": "Unable to create kseb."';
    echo '}';
}

function validate($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>