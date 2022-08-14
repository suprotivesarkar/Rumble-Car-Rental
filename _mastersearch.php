<?php 
require_once("admin/config/config.php");  
require_once("admin/config/function.php"); 
$lid     = (!empty($_REQUEST['lid']))?FilterInput($_REQUEST['lid']):null; 
$keyword = (!empty($_REQUEST['query']))?FilterInput(strval($_REQUEST['query'])):null; 
$type    = (!empty($_REQUEST['type']))?FilterInput(strval($_REQUEST['type'])):null; 
if ($type=="end") {
	$ad = " AND locations.loc_id=rent_list.rent_epoint ";
	if (!empty($lid) AND is_numeric($lid)) {
	    $ad.=" AND rent_list.rent_spoint='$lid' ";
	}
}
else{
	$ad = " AND locations.loc_id=rent_list.rent_spoint ";
}
$qu="SELECT DISTINCT locations.loc_id, locations.loc_name FROM locations INNER JOIN rent_list ON locations.loc_name LIKE "."'%".$keyword."%'";
$qu.=$ad;
if (!empty($lid) AND is_numeric($lid)) {
    $qu.=" AND loc_id<>'$lid' ";
}
//echo $qu;
$run = $PDO->prepare($qu);
$run->execute();
$data=$subar=array();
if ($run->rowCount()>0){
    while($row   = $run->fetch()) {
    	$subar= array(
    		"nm" => $row['loc_name'],
    		"id" => $row['loc_id']
    	);
    	array_push($data,$subar);
    }
    echo json_encode($data);
}
else {
	if ($type=="end") {
		$ad = " AND location_aliases.loc_id_ref_la=rent_list.rent_epoint ";
	}
	else{
		$ad = " AND location_aliases.loc_id_ref_la=rent_list.rent_spoint ";
	}
	$qu="SELECT DISTINCT location_aliases.la_id, location_aliases.loc_id_ref_la, location_aliases.la_name FROM location_aliases INNER JOIN rent_list ON location_aliases.la_name LIKE "."'%".$keyword."%' AND location_aliases.la_status=1 ";
	$qu.=$ad;
	$run = $PDO->prepare($qu);
	$run->execute();
	$data=$subar=array();
	if ($run->rowCount()>0){
	    while($row   = $run->fetch()) {
	    	$subar= array(
	    		"nm" => $row['la_name'],
	    		"id" => $row['loc_id_ref_la']
	    	);
	    	array_push($data,$subar);
	    }
	    echo json_encode($data);
	}
	else {
		$keyword = "not";
		$subar   = array(
	    	"nm" => "Not Found",
	    	"id" => "0"
	    );
	    array_push($data,$subar);
		echo json_encode($data);
	}
}
die();