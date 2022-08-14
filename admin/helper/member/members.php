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
	$stmt = $PDO->prepare("SELECT * FROM members WHERE mem_status<>2 ORDER BY mem_id DESC");
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
	<th>ADDRESS</th>
	<th>ACTIONS</th>
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
	<td><?php echo $mem_name; ?></td>
	<td><?php echo $mem_phone.((!empty($mem_alternative_phone))?"/ ".$mem_alternative_phone:null); ?></td>
	<td><?php echo $mem_email; ?></td>
	<td><?php echo $mem_address; ?></td>
	<td> 
	<a href="javascript:void(0);" class="statusup" title="Delete" data-id="<?php echo htmlspecialchars($mem_id); ?>" data-operation="delete"><i class="fa fa-trash"></i></a>
	</td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
    </div>
	<?php }else{echo '<div class="alert alert-warning"><p>No Member Found</p></div>'; }
}
elseif ($operation=="viewmore") {
	$id    = (!empty($_POST['id']))?FilterInput($_POST['id']):null; 
	$stmt = $PDO->prepare("SELECT * FROM enquiry WHERE enq_status<>2 AND enq_id='$id'");
	$stmt->execute(); 
	if($stmt->rowCount()!=1){
		echo '<h1>Not Found</h1>';
		die();
	}
	$det = $stmt->fetch();
	extract($det);
	?>
	<div class="table-responsive">
	<table class="table table-bordered">
	<tbody>
	  <tr>
	    <td>Name</td>
	    <td><?php echo $enq_name; ?></td>
	    <td>Phone</td>
	    <td><?php echo $enq_phone; ?><?php  echo (!empty($enq_alt_phone))?" / ".$enq_alt_phone:null; ?></td>
	  </tr>
	  <tr>
	    <td>Email</td>
	    <td><?php echo $enq_email; ?></td>
	    <td>Address</td>
	    <td><?php echo $enq_address; ?></td>
	  </tr>
	  <tr>
	    <td>Message</td>
	    <td colspan="3"><?php echo $enq_message; ?></td>
	  </tr>
	  <tr>
	    <td>PICKUP</td>
	    <td><?php echo $enq_pickup_loc; ?></td>
	    <td>DROP</td>
	    <td><?php echo $enq_drop_loc; ?></td>
	  </tr>
	  <tr>
	    <td>JDATE</td>
	    <td><?php echo date('d-M-Y', strtotime($enq_journey_date)); ?></td>
	    <td>VEHICAL</td>
	    <td><?php echo $enq_total_people.' | '.$enq_vehical_type; ?></td>
	  </tr>
	  <?php 
	  	if(!empty($enq_sightseeing)){ 
	  	$sightarr = explode('~@~',$enq_sightseeing); 
	  ?>
	  <tr> 
	    <td colspan="4">Sightseeing</td>
	  </tr>
	  <?php foreach ($sightarr as $sights){ $now= explode('|',$sights); ?>
	  <tr>
	    <td><?php echo date('d-M-Y', strtotime($now[0]));  ?></td>
	    <td colspan="3"><?php echo $now[1]; ?></td>
	  </tr>
	  <?php } } ?>
	  <tr>
	    <td>TIME</td>
	    <td><?php echo date('d-M-Y', strtotime($enq_create_at)); ?></td>
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
	$chk_id = CheckExists("members","mem_id = '$id' AND mem_status<>2");
	if (empty($chk_id)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Cant Find this Entry"
		));
		die();
	}
	$ad = ($operation=='delete')?", mem_delete_at=NOW()":null;
	$sql = "UPDATE members SET mem_status= {$up} ".$ad. " WHERE mem_id= {$id}";
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