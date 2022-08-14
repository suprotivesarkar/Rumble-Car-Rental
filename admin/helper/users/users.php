<?php 
require_once("../../config/config.php");require_once("../../config/function.php");header("cache-control:no-cache");
if(empty($_SESSION['islogin'])){
	echo $response = json_encode(array(
			"status" =>false,
			"msg"	 => "Unauthorized Access"
	));
	die();
}
$operation =trim($_POST['operation']);
if (empty($operation)){
	echo $response = json_encode(array(
			"status" => false,
			"msg"	 => "Something Wrong"
	));
	die(); 
}
if ($operation=="fetch"){
	$stmt = $PDO->prepare("SELECT * FROM members WHERE member_status<>2  ORDER BY member_create_at DESC");
	$stmt->execute(); 
	if($stmt->rowCount()>0){ ?>
	<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="entry_table">
	<thead>
	<tr>
	<th>#</th>
	<th>NAME</th>
	<th>PHONE</th>
	<th>EMAIL</th>
	<th>STATUS</th>
	<th>ACTIONS</th>
	</tr>
	</thead>
	<tbody> 
	<?php   
	$i=1;
	while ($row=$stmt->fetch()){extract($row); ?> 
	<tr>
	<td><?php echo $i++; ?></td>
	<td><?php echo $member_name; ?></td>
	<td><?php echo $member_phone; ?></td>
	<td><?php echo $member_email; ?></td>
	<td><?php echo StatusReport($member_status);  ?></td>
	<td>
	<?php 
    if ($member_status==0) { ?>
    <a href="javascript:void(0);" title="Make Active" class="text-inverse statusup" data-id="<?php echo htmlspecialchars($member_id); ?>" data-operation="active"><i class="fa fa-check"></i> || </a>
    <?php }else if($member_status==1) { ?>
    <a href="javascript:void(0);" title="Make Dective" class="text-inverse statusup" data-id="<?php echo $row['member_id']; ?>" data-operation="deactive"><i class="fa fa-lock"></i> || </a>
    <?php } ?>
	<a href="javascript:void(0);" class="statusup" title="Delete" data-id="<?php echo htmlspecialchars($member_id); ?>" data-operation="delete"><i class="fa fa-trash"></i></a>
	</td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
    </div>
	<?php }else{echo '<div class="alert alert-warning"><p>No Color Found</p></div>'; }
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
	$stmt = $PDO->prepare("SELECT * FROM members WHERE member_id=:id");
	$stmt->execute(['id' => $id]); 
	if ($stmt->rowCount()!=1){ 
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => " Cant Find to Activate"
		));
		die();
	}
	$ad = ($operation=='delete')?", member_delete_at=NOW()":null;
	$sql = "UPDATE members SET member_status= {$up} ".$ad. " WHERE member_id= {$id}";
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
}else {
	echo $response = json_encode(array(
			"status" => false,
			"msg"	 =>" Something Wrong"
	));
	die();
}