<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/kseb.php';
 
// instantiate database and kseb object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$kseb = new kseb($db);
 
// query products

if(isset($_GET['id'])){
	if(isset($_GET['token'])){
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
}else{
	die('{"message": "Unable to connect"}');
}

if(isset($_GET['mode'])){ //mode1:last entry. mode2:between timestamps. mode3:last 1 minute
	$m=validate($_GET['mode']);
		if($m==1){
			if(isset($_GET['m_id'])){
				$kseb->m_id=validate($_GET['m_id']);
			}
			$stmt = $kseb->read_last();
			}
		elseif($m==2){
			if(isset($_GET['m_id'])){
				$kseb->m_id=validate($_GET['m_id']);
			}
			if(isset($_GET['st'])){
				$kseb->starttime=validate($_GET['st']);
			}
			if(isset($_GET['et'])){
				$kseb->endtime=validate($_GET['et']);
			}
			$stmt = $kseb->read_between();
			}
		elseif($m==3){
			if(isset($_GET['m_id'])){
				$kseb->m_id=validate($_GET['m_id']);
			}
			$stmt = $kseb->read_minute();
			}
		else{$stmt = $kseb->read();}
}else{
	$stmt = $kseb->read();
}

$num = $stmt->rowCount();

// check if found
if($num>0){
	
    // result array
    $result_arr=array();
	$result_arr["Faults"]=array();
   
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // this will make $row['name'] to
        // just $name only
        extract($row);
        //`sn``time``battery_volt``charger_volt``present_volt``set_volt``interrupt``fault_level`
        $result_item=array(
            "sn" => $sn,
			"times" => $times,
			"m_id" => $m_id,
            "bvolt" => $battery_volt,
            "cvolt" => $charger_volt,
            "pvolt" => $present_volt,
            "svolt" => $set_volt,
            "interrupt" => $interrupt,
			"flevel" => $fault_level
        );
 
        array_push($result_arr["Faults"], $result_item);
    }
 
    echo json_encode($result_arr);
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