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
	$stmt = $PDO->prepare("SELECT * FROM enquiry WHERE enq_status<>2 AND enq_subject IS NOT NULL ORDER BY enq_id DESC");
	$stmt->execute(); 
	if($stmt->rowCount()>0){ ?>
	<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="entry_table">
	<thead>
	<tr>
	<th>#</th>
	<th>Name</th>
	<th>Email</th>
	<th>Phone</th>
	<th>Subject</th>
	<th>&nbsp</th>
	</tr>
	</thead>
	<tbody> 
	<?php   
	$i=1;
	while ($row=$stmt->fetch()){
	extract($row);
	?>
	<tr>
	<td><?php echo $i++; ?></td>
	<td><?php echo $enq_name; ?></td>
	<td><?php echo $enq_email; ?></td>
	<td><?php echo $enq_phone; ?></td>
	<td><?php echo $enq_subject; ?></td>
	<td>
	<a href="" data-toggle="modal" data-target="#viewMod" data-id="<?php echo htmlspecialchars($enq_id); ?>" title="View More"><i class="fa fa-eye"></i></a> || 
	<a href="javascript:void(0);" class="statusup" title="Delete" data-id="<?php echo htmlspecialchars($enq_id); ?>" data-operation="delete"><i class="fa fa-trash"></i></a>
	</td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
    </div>
	<?php }else{echo '<div class="alert alert-warning"><p>No Enquiry Found</p></div>'; }
}
elseif ($operation=="viewmore") {
	$id    = (!empty($_POST['id']))?FilterInput($_POST['id']):null; 
	$stmt = $PDO->prepare("SELECT * FROM enquiry WHERE enq_status<>2 AND enq_subject IS NOT NULL AND enq_id='$id'");
	$stmt->execute(); 
	if($stmt->rowCount()!=1){
		echo '<h1>Not Found</h1>';
		die();
	}
	$det = $stmt->fetch();
	extract($det);
	$sighttxtemail = null;
	?>
	<div class="table-responsive">
	<table class="table table-bordered">
	<tbody>
	  <tr>
	    <td>Name</td>
	    <td><?php echo $enq_name; ?></td>
	    <td>Phone</td>
	    <td><?php echo $enq_phone; ?></td>
	  </tr>
	 <tr>
	    <td>Email</td>
	    <td><?php echo $enq_email; ?></td>
	  </tr>
	  <td>Subject</td>
	    <td><?php echo $enq_subject; ?></td>
	  </tr>
	   <tr>
	    <td>Message</td>
	    <td colspan="3"><?php echo $enq_message; ?></td>
	  </tr>
	  <tr> 
	    <td>IP</td>
	    <td><?php echo $enq_ip; ?></td>
	  </tr> 
	</tbody>
	</table>
	</div>

<?php
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
	$chk_id = CheckExists("enquiry","enq_id = '$id' AND enq_status<>2 AND enq_subject IS NOT NULL");
	if (empty($chk_id)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Cant Find this Entry"
		));
		die();
	}
	$ad = ($operation=='delete')?", enq_delete_at=NOW()":null;
	$sql = "UPDATE enquiry SET enq_status = {$up} ".$ad. " WHERE enq_id= {$id}";
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