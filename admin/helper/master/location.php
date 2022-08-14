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
	$stmt = $PDO->prepare("SELECT * FROM locations WHERE loc_status<>2 ORDER BY loc_id DESC");
	$stmt->execute(); 
	if($stmt->rowCount()>0){ ?>
	<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="entry_table">
	<thead>
	<tr>
	<th>#</th>
	<th>BELONGS</th>
	<th>NAME</th>
	<th>URL</th>
	<th>SIMILAR</th>
	<th>STATUS</th>
	<th>ACTIONS</th>
	</tr>
	</thead>
	<tbody> 
	<?php   
	$i=1;
	while ($row=$stmt->fetch()){
	extract($row);
	if (empty($loc_parent_id)) {
			$parentname = null;
	}else{
		$parentdet = LocationParentDetails($loc_parent_id);
		if(!empty($parentdet)) {
			$parentname = $parentdet['loc_name'];
		}else{
			$parentname = null;
		}
	}
	?> 
	<tr>
	<td><?php echo $i++; ?></td>
	<td><?php echo $parentname; ?></td>
	<td><?php echo $loc_name; ?></td>
	<td><?php echo $loc_slug; ?></td>
	<td>
	<?php 
	$findtotal = $PDO->prepare("SELECT count(*) as total FROM location_aliases WHERE la_status<>2 AND loc_id_ref_la='$loc_id'");
	$findtotal->execute(); 
	$rowslist = $findtotal->fetch();
	echo $rowslist['total'];
	?>	
	</td>
	<td><?php echo StatusReport($loc_status);  ?></td>
	<td>
    <a href="similar-locations?id=<?php echo htmlspecialchars($loc_id); ?>" title="Add Similar Locations" class="text-success"><i class="fa fa-plus"></i> || </a>
	<?php  
    if ($loc_status==0) { ?>
    <a href="javascript:void(0);" title="Make Active" class="text-success statusup" data-id="<?php echo htmlspecialchars($loc_id); ?>" data-operation="active"><i class="fa fa-check"></i> || </a>
    <?php }else if($loc_status==1) { ?>
    <a href="javascript:void(0);" title="Make Dective" class="text-danger statusup" data-id="<?php echo $row['loc_id']; ?>" data-operation="deactive"><i class="fa fa-lock"></i> || </a>
    <?php } ?>
	<a href="" data-toggle="modal" data-target="#upMod" data-id="<?php echo htmlspecialchars($loc_id); ?>" data-pid="<?php echo htmlspecialchars($loc_parent_id); ?>" data-pname="<?php echo htmlspecialchars($parentname); ?>" data-name="<?php echo htmlspecialchars($loc_name); ?>" data-url="<?php echo htmlspecialchars($loc_slug); ?>" class="editbtn" title="Update"><i class="fa fa-edit"></i></a> || 
	<a href="javascript:void(0);" class="statusup" title="Delete" data-id="<?php echo htmlspecialchars($loc_id); ?>" data-operation="delete"><i class="fa fa-trash"></i></a>
	</td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
    </div>
	<?php }else{echo '<div class="alert alert-warning"><p>No Category Found</p></div>'; }
}
elseif ($operation=="addnew") {
	$pname    = (!empty($_POST['pname']))?FilterInput($_POST['pname']):null; 
	$pid      = (!empty($_POST['pid']))?FilterInput($_POST['pid']):null; 
	$name     = (!empty($_POST['name']))?FilterInput($_POST['name']):null; 
	$nameurl  = (!empty($_POST['nameurl']))?FilterInput($_POST['nameurl']):null; 
	if(empty($name) OR empty($nameurl)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Enter Name"
		));
		die();
	}
	if(!empty($pid)) {
		$chk_parent = CheckExists("locations","loc_id = '$pid' AND loc_status<>2");
		if (empty($chk_parent)) {
			echo $response = json_encode(array(
					"status" => false,
					"msg"	 => "Parent Not Found"
			));
			die();
		}
	}
	$chk_slug = CheckExists("locations","(loc_slug = '$nameurl' OR loc_name = '$name') AND loc_status<>2");
	if (!empty($chk_slug)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "This Name Already Exists"
		));
		die();
	}
	$sql = "INSERT INTO locations SET
	        loc_parent_id = :loc_parent_id,
	        loc_slug      = :loc_slug,
	        loc_name      = :loc_name";
	        $insert = $PDO->prepare($sql);
	        $insert->bindParam(':loc_parent_id',$pid);
	        $insert->bindParam(':loc_slug',$nameurl);
	        $insert->bindParam(':loc_name',$name);
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
    $uppname   = (!empty($_POST['uppname']))?FilterInput($_POST['uppname']):null; 
    $uppid     = (!empty($_POST['uppid']))?FilterInput($_POST['uppid']):null; 
	$upname    = (!empty($_POST['upname']))?FilterInput($_POST['upname']):null; 
	$upnameurl = (!empty($_POST['upnameurl']))?FilterInput($_POST['upnameurl']):null; 

	if(empty($uptid) OR empty($upname) OR empty($upnameurl) OR !is_numeric($uptid)){
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Fields is Empty"
		));
		die();
	}
	$chk_id = CheckExists("locations","loc_id = '$uptid' AND loc_status<>2");
	if (empty($chk_id)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Cant Find this Entry"
		));
		die();
	}
	$chk_slug = CheckExists("locations","(loc_slug = '$upnameurl' OR loc_name = '$upname') AND loc_id<>'$uptid' AND loc_status<>2");
	if (!empty($chk_slug)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "This Name Already Exists"
		));
		die();
	}
	$sql = "UPDATE locations SET
	            loc_parent_id = :loc_parent_id,
		        loc_slug      = :loc_slug,
		        loc_name      = :loc_name
	            WHERE loc_id=:loc_id";
	            $insert = $PDO->prepare($sql);
	            $insert->bindParam(':loc_parent_id',$uppid);
		        $insert->bindParam(':loc_slug',$upnameurl);
		        $insert->bindParam(':loc_name',$upname);
	            $insert->bindParam(':loc_id',$uptid);
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
	$chk_id = CheckExists("locations","loc_id = '$id' AND loc_status<>2");
	if (empty($chk_id)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Cant Find this Entry"
		));
		die();
	}
	$ad = ($operation=='delete')?", loc_delete_at=NOW()":null;
	$sql = "UPDATE locations SET loc_status= {$up} ".$ad. " WHERE loc_id= {$id}";
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