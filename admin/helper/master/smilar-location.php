<?php 
require_once("../../config/config.php");require_once("../../config/function.php");header("cache-control:no-cache");
if(empty($_SESSION['islogin'])){
	echo $response = json_encode(array(
			"status" =>false,
			"msg"	 => "Unauthorized Access"
	));
	die(); 
}
$operation =trim($_REQUEST['operation']);
if (empty($operation)){
	echo $response = json_encode(array(
			"status" => false,
			"msg"	 => "Something Wrong"
	));
	die();
}
if ($operation=="fetch"){
	$mainid    =trim($_REQUEST['id']);

	$stmt = $PDO->prepare("SELECT * FROM location_aliases WHERE la_status<>2 AND loc_id_ref_la='$mainid' ORDER BY la_id DESC");
	$stmt->execute(); 
	if($stmt->rowCount()>0){ ?>
	<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="entry_table">
	<thead>
	<tr>
	<th>#</th>
	<th>NAME</th>
	<th>STATUS</th>
	<th>ACTIONS</th>
	</tr>
	</thead>
	<tbody> 
	<?php   
	$i=1;
	while ($row=$stmt->fetch()){
	extract($row); 
	?>
	<td><?php echo $i++; ?></td>
	<td><?php echo $la_name; ?></td>
	<td><?php echo StatusReport($la_status);  ?></td>
	<td>
	<?php  
    if ($la_status==0) { ?>
    <a href="javascript:void(0);" title="Make Active" class="text-success statusup" data-id="<?php echo htmlspecialchars($la_id); ?>" data-operation="active"><i class="fa fa-check"></i> || </a>
    <?php }else if($la_status==1) { ?>
    <a href="javascript:void(0);" title="Make Dective" class="text-danger statusup" data-id="<?php echo $row['la_id']; ?>" data-operation="deactive"><i class="fa fa-lock"></i> || </a>
    <?php } ?>
	<a href="" data-toggle="modal" data-target="#upMod" data-id="<?php echo htmlspecialchars($la_id); ?>" data-name="<?php echo htmlspecialchars($la_name); ?>" class="editbtn" title="Update"><i class="fa fa-edit"></i></a> || 
	<a href="javascript:void(0);" class="statusup" title="Delete" data-id="<?php echo htmlspecialchars($la_id); ?>" data-operation="delete"><i class="fa fa-trash"></i></a>
	</td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
    </div>
	<?php }else{echo '<div class="alert alert-warning"><p>No Category Found</p></div>'; }
}
elseif ($operation=="addnew") {
	$name     = (!empty($_POST['name']))?FilterInput($_POST['name']):null; 
	$mainid   = (!empty($_POST['id']))?FilterInput($_POST['id']):null; 

	if(empty($name)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Enter Name"
		));
		die();
	}
	if(!empty($mainid)) {
		$chk_parent = CheckExists("locations","loc_id = '$mainid' AND loc_status<>2");
		if (empty($chk_parent)) {
			echo $response = json_encode(array(
					"status" => false,
					"msg"	 => "Location Not Found"
			));
			die();
		}
	}
	$sql = "INSERT INTO location_aliases SET
	        loc_id_ref_la = :loc_id_ref_la,
	        la_name       = :la_name";
	        $insert = $PDO->prepare($sql);
	        $insert->bindParam(':loc_id_ref_la',$mainid);
	        $insert->bindParam(':la_name',$name);
	        $insert->execute();
	        if($insert->rowCount() > 0){
	        	echo $response = json_encode(array(
					"status" => true, 
					"msg"	 => "Successfully Added"
				));
	        }else {
	        	echo $response = json_encode(array(
					"status" =>false,
					"msg"	 =>"Something Wrong"
				));
			}
}
elseif($operation=="update") {
	$uptid     = (!empty($_POST['uptid']))?FilterInput($_POST['uptid']):null; 
    $uppname   = (!empty($_POST['upname']))?FilterInput($_POST['upname']):null; 
	$mainid    = (!empty($_POST['id']))?FilterInput($_POST['id']):null; 

	if(empty($uppname)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Enter Name"
		));
		die();
	}
	if(!empty($mainid)) {
		$chk_parent = CheckExists("locations","loc_id = '$mainid' AND loc_status<>2");
		if (empty($chk_parent)) {
			echo $response = json_encode(array(
					"status" => false,
					"msg"	 => "Location Not Found"
			));
			die();
		}
	}
	$chk_id = CheckExists("location_aliases","la_id = '$uptid' AND la_status<>2");
	if (empty($chk_id)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Cant Find this Entry"
		));
		die();
	}
	$sql = "UPDATE location_aliases SET
	            la_name    = :la_name
	            WHERE la_id=:la_id";
	            $insert = $PDO->prepare($sql);
	            $insert->bindParam(':la_name',$uppname);
	            $insert->bindParam(':la_id',$uptid);
		        $insert->execute();
	            if($insert->rowCount() > 0){
	            	echo $response = json_encode(array(
						"status" =>true, 
						"msg"	 => "Successfully Updated"
					));
	            }else {
	            	echo $response = json_encode(array(
						"status" =>false,
						"msg"	 =>"No Change Done"
					));
	   			}
}
elseif ($operation=="active" OR $operation=="deactive" OR $operation=="delete") {

	$id =FilterInput($_POST['id']);
	if(empty($id) AND !is_numeric($id)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Something Wrong"
		));
		die();
	}
	switch ($operation) {
		case 'active':
			$up = 1;
			$msg="Successfully Activated";
			break;
		case 'deactive':
			$up = 0;
			$msg="Successfully Deactivated";
			break;
		case 'delete':
			$up = 2;
			$msg="Successfully Deleted";
			break;
		default:
			$up=1;
			$msg="Something Wrong";
			break;
	}
	$chk_id = CheckExists("location_aliases","la_id = '$id' AND la_status<>2");
	if (empty($chk_id)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Cant Find this Entry"
		));
		die();
	}
	$ad = ($operation=='delete')?", la_delete_at=NOW()":null;
	$sql = "UPDATE location_aliases SET la_status= {$up} ".$ad. " WHERE la_id= {$id}";
			$insert = $PDO->prepare($sql);
			$insert->execute();
			if($insert->rowCount() > 0){
					echo $response = json_encode(array(
					"status" => true, 
					"msg"	 => $msg
				));
			}else {
					echo $response = json_encode(array(
					"status" =>false,
					"msg"	 =>"No Change Done"
				));
			}
}
else {
	echo $response = json_encode(array(
			"status" => false,
			"msg"	 =>" Something Wrong"
	));
	die();
}