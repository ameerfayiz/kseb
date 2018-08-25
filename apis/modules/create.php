<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 

// get database connection
include_once '../config/database.php';
 
// instantiate modules object
include_once '../objects/modules.php';
 
$database = new Database();
$db = $database->getConnection();
 
 
 if(isset($_GET['token']) AND isset($_GET['id'])){
    $query = "SELECT * FROM users WHERE example1='" . validate($_GET['id']) . "'" ;
    $stmt = $db->prepare($query);
    $stmt->execute();
	$num = $stmt->rowCount();
	if($num>0){
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row['example2']!==validate($_GET['token'])){
			die('{"message": "Unable to connect"}');
		}
	}else{
	die('{"message": "Unable to connect"}');
}	
	}else{
	die('{"message": "Unable to connect"}');
}

$modules = new modules($db);
date_default_timezone_set("Asia/Calcutta"); 



// set modules property values
//`m_id``m_discription``m_location``lat``lon``api_token`

$modules->m_id = isset($_GET['m_id']) ? validate($_GET['m_id']) : die();
$modules->m_discription = isset($_GET['sec']) ? validate($_GET['sec']) : die();
$modules->m_location = isset($_GET['loc']) ? validate($_GET['loc']) : die();
$modules->lat = isset($_GET['lat']) ? validate($_GET['lat']) : '0';
$modules->lon = isset($_GET['lon']) ? validate($_GET['lon']) : '0';
$modules->api_token = isset($_GET['api_token']) ? validate($_GET['api_token']) : die();

 
// create the modules
if($modules->create()){
    echo '{';
        echo '"message": "module was created on ';
		echo date("Y-m-d h:i:s a",time()); 
		echo '"';
    echo '}';
}
 
// if unable to create the modules, tell the user
else{
    echo '{';
        echo '"message": "Unable to create modules."';
    echo '}';
}

function validate($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>