<?php
// required header
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// includes
include_once '../config/database.php';
include_once '../objects/modules.php';
 
// initialize database and modules object
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

// initialize 
$modules = new modules($db);
 
 
if(isset($_GET['sec'])){ 
	$sec=validate($_GET['sec']);
	$modules->m_discription=$sec;
	$stmt = $modules->read();
}else{
	die('{"message": "Unable to fetch the data"}');
}




$num = $stmt->rowCount();
 
// check 
if($num>0){
	
    $results_arr=array();
	$results_arr["Modules"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        extract($row);
        //`m_id``m_discription``m_location``lat``lon``api_token`
        $results_item=array(
            "m_id" => $m_id,
            "section" => $m_discription,
			"location" => $m_location,
            "lat" => $lat,
			"lon" => $lon,
			"api_token" => $api_token,
        );
 
        array_push($results_arr["Modules"], $results_item);
    }
 
    echo json_encode($results_arr);
}
 
else{
    echo json_encode(
        array("message" => "No products found.")
    );
}

function validate($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>