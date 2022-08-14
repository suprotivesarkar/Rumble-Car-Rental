<?php 
require_once("../../config/config.php");require_once("../../config/function.php");header("cache-control:no-cache");
if(empty($_SESSION['islogin'])){
	echo $response = json_encode(array(
			"status" =>false,
			"msg"	 => "Unauthorized Access"
	));
	die();
} 
$data=$subar=array();
$startpoint = $_GET['term']; 
$locid      = (!empty($_GET['locid']))?FilterInput($_GET['locid']):null;  
$stmt = "SELECT *  FROM locations WHERE loc_name LIKE "."'%".$startpoint."%'  AND loc_status=1 ";
if (!empty($locid) AND is_numeric($locid)) {
    $stmt.=" AND loc_id<>'$locid' ";
}
$stmt.=" ORDER BY RAND() LIMIT 10";
$stmt=$PDO->prepare($stmt);
$stmt->execute();
if($stmt->rowCount()>=0){ 
    while ($row = $stmt->fetch()) {
    	$subar= array(
    		"id"    => $row['loc_id'],
    		"value" => $row['loc_name']
    	);
    	array_push($data,$subar);
    }
}
echo json_encode($data);