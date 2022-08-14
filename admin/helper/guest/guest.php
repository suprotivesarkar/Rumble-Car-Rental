<?php
require_once "../../config/config.php";require_once "../../config/function.php";
header("cache-control:no-cache");
if (empty($_SESSION['islogin'])) {
	echo $response = json_encode(array(
		"status" => false,
		"msg" => "Unauthorized Access",
	));
	die();
}
$memid = $_SESSION['memberid'];
$memdet = MemberDetails($memid);
$memtype = $memdet['member_type'];
$memname = $memdet['member_name'];
$operation = trim($_POST['operation']);
if (empty($operation)) {
	echo $response = json_encode(array(
		"status" => false,
		"msg" => "Something Wrong",
	));
	die();
}

if ($operation == "fetch") {
	$sql = "SELECT * FROM guest_details
					    inner join destinations on destination=destination_id
					    inner join members on guest_details.guest_by=members.member_id
					    WHERE ";
	if ($memtype == 2) {
		$sql .= " guest_by='$memid' AND ";
	}
	$sql .= " guest_status=1 ORDER BY guest_id DESC ";

	$stmt = $PDO->prepare($sql);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		?>
	<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="entry_table">
	<thead>
	<tr>
	<th>#</th>
	<th>TYPE</th>
	<th>NAME</th>
	<th>PHONE</th>
	<th>EMAIL</th>
	<?php echo ($memtype == 1) ? '<th>BY</th>' : null; ?>
	<th>STATUS</th>
	<th>ACTIONS</th>
	</tr>
	</thead>
	<tbody>
	<?php
$i = 1;
		while ($row = $stmt->fetch()) {
			extract($row);?>
	<tr>
	<td><?php echo $i++; ?></td>
	<td><?php echo ($tour_type == 1) ? "Day" : date('d-M-y', strtotime($start_date)); ?></td>
	<td><?php echo $guest_name; ?></td>
	<td><?php echo $guest_phone; ?></td>
	<td><?php echo $guest_email; ?></td>
	<?php echo ($memtype == 1) ? '<td>'.$member_name.'</td>' : null; ?>
	<td>
		<?php
		if ($email_status == 1) {
			echo '<i class="fa fa-envelope-o green"></i> | ';
		} else {
			echo '<i class="fa fa-envelope-o red emailbtn" data-id="'.$guest_id.'" data-type="email"></i> | ';
		}
		if ($print_status == 1) {
			echo '<i class="fa fa-save green"></i>';
		} else {
			echo '<i class="fa fa-save red printbtn" data-id="'.$guest_id.'" data-type="print"></i>';
		}
		?>
	</td>
	<td>
	<a href="build-itinerary?id=<?php echo $guest_id; ?>" class="text-success" title="Build Itinerary" data-id="<?php echo $row['guest_id']; ?>"><i class="fa fa-cog"></i> ||</a>
	<a target="_blank" href="print?id=<?php echo $guest_id; ?>" class="text-success printbtn" title="Print Itinerary" data-id="<?php echo $guest_id; ?>" data-type="print"><i class="fa fa-print"></i> ||</a>
	<a href="#" class="editbtn" data-toggle="modal" data-target="#upMod" title="Update" data-id="<?php echo $guest_id; ?>" data-desid="<?php echo $destination_id; ?>" data-saluation="<?php echo $saluation; ?>" data-desname="<?php echo $destination_name; ?>"  data-name="<?php echo $guest_name; ?>" data-phone="<?php echo htmlspecialchars($guest_phone); ?>" data-email="<?php echo htmlspecialchars($guest_email); ?>" data-addr="<?php echo htmlspecialchars($guest_address); ?>"><i class="fa fa-edit"></i></a> ||
	<a href="javascript:void(0);" class="delbtn" title="Delete" data-id="<?php echo $row['guest_id']; ?>"><i class="fa fa-trash"></i></a>
	</td>
	</tr>
	<?php }?>
	</tbody>
	</table>
    </div>
	<?php } else {echo '<div class="alert alert-warning"><p>No Guest Found</p></div>';}
} elseif ($operation == "addnew") {
	$itinerarytype = FilterInput($_POST['itinerarytype']);
	$daylabel = (isset($_POST['daylebel'])) ? FilterInput($_POST['daylebel']) : null;
	$destinationid = FilterInput($_POST['destinationid']);
	$saluation = FilterInput($_POST['saluation']);
	$gname = FilterInput($_POST['gname']);
	$gphone = FilterInput($_POST['gphone']);
	$gemail = FilterInput($_POST['gemail']);
	$gaddr = FilterInput($_POST['gaddr']);

	if (empty($itinerarytype) OR empty($gname) OR empty($gphone) OR empty($gemail) OR empty($gaddr)) {
		echo $response = json_encode(array(
			"status" => false,
			"msg" => "Fields is Empty",
		));
		die();
	}

	if (empty($destinationid) OR !is_numeric($destinationid)) {
		echo $response = json_encode(array(
			"status" => false,
			"msg" => "Destination Not Found",
		));
		die();
	}
	if ($itinerarytype == 2 && empty($daylabel)) {
		echo $response = json_encode(array(
			"status" => false,
			"msg" => "Date is Empty",
		));
		die();
	} else {
		$daylabel = date('Y-m-d', strtotime($daylabel));
	}

	$sql = "INSERT INTO guest_details SET
	            tour_type       = :tour_type,
	            start_date      = :start_date,
	            destination     = :destinationid,
	            saluation       = :saluation,
	            guest_name      = :guest_name,
	            guest_phone     = :guest_phone,
	            guest_email     = :guest_email,
	            guest_address   = :guest_address,

	            guest_by        = :guest_by";
	$insert = $PDO->prepare($sql);
	$insert->bindParam(':tour_type', $itinerarytype);
	$insert->bindParam(':start_date', $daylabel);
	$insert->bindParam(':destinationid', $destinationid);
	$insert->bindParam(':saluation', $saluation);
	$insert->bindParam(':guest_name', $gname);
	$insert->bindParam(':guest_phone', $gphone);
	$insert->bindParam(':guest_email', $gemail);
	$insert->bindParam(':guest_address', $gaddr);

	$insert->bindParam(':guest_by', $memid);
	$insert->execute();
	if ($insert->rowCount() > 0) {
		echo $response = json_encode(array(
			"status" => true,
			"msg" => "Successfully Added",
		));
	} else {
		echo $response = json_encode(array(
			"status" => false,
			"msg" => "Something Wrong",
		));
	}
} elseif ($operation == "update") {

	$uptid = FilterInput($_POST['uptid']);
	$itinerarytype = FilterInput($_POST['upitinerarytype']);
	$daylabel = (isset($_POST['updaylebel'])) ? FilterInput($_POST['updaylebel']) : null;
	$updestinationid = FilterInput($_POST['updestinationid']);
	$saluation = FilterInput($_POST['upsaluation']);
	$gname = FilterInput($_POST['upgname']);
	$gphone = FilterInput($_POST['upgphone']);
	$gemail = FilterInput($_POST['upgemail']);
	$gaddr = FilterInput($_POST['upgaddr']);

	if (empty($uptid) OR empty($itinerarytype) OR empty($gname) OR empty($gphone) OR empty($gemail) OR empty($gaddr)) {
		echo $response = json_encode(array(
			"status" => false,
			"msg" => "Fields is Empty",
		));
		die();
	}

	if (empty($updestinationid) OR !is_numeric($updestinationid)) {
		echo $response = json_encode(array(
			"status" => false,
			"msg" => "Destination Not Found",
		));
		die();
	}

	if ($itinerarytype == 2 AND empty($daylabel)) {
		echo $response = json_encode(array(
			"status" => false,
			"msg" => "Date is Empty",
		));
		die();
	} else {
		$daylabel = date('Y-m-d', strtotime($daylabel));
	}

	$stmt = $PDO->prepare("SELECT * FROM guest_details WHERE guest_id=:uptid AND guest_by=:memid AND guest_status=1");
	$stmt->execute(['uptid' => $uptid, 'memid' => $memid]);
	if ($stmt->rowCount() == 1) {
		$sql = "UPDATE `guest_details` SET
	            tour_type       = :tour_type,
	            start_date      = :start_date,
	            destination     = :updestinationid,
	            saluation       = :saluation,
	            guest_name      = :guest_name,
	            guest_phone     = :guest_phone,
	            guest_email     = :guest_email,
	            guest_address   = :guest_address

	            WHERE guest_id=:uptid";
		$insert = $PDO->prepare($sql);
		$insert->bindParam(':tour_type', $itinerarytype);
		$insert->bindParam(':start_date', $daylabel);
		$insert->bindParam(':updestinationid', $updestinationid);
		$insert->bindParam(':saluation', $saluation);
		$insert->bindParam(':guest_name', $gname);
		$insert->bindParam(':guest_phone', $gphone);
		$insert->bindParam(':guest_email', $gemail);
		$insert->bindParam(':guest_address', $gaddr);

		$insert->bindParam(':uptid', $uptid);
		$insert->execute();
		if ($insert->rowCount() > 0) {
			echo $response = json_encode(array(
				"status" => true,
				"msg" => "Successfully Updated",
			));
		} else {
			echo $response = json_encode(array(
				"status" => false,
				"msg" => "No Change Done",
			));
		}
	} else {
		echo $response = json_encode(array(
			"status" => false,
			"msg" => "Cant Find For Update",
		));
		die();
	}

} elseif ($operation == "delete") {

	$id = trim($_POST['id']);
	if (empty($id) AND !is_numeric($id)) {
		echo $response = json_encode(array(
			"status" => false,
			"msg" => "Something Wrong",
		));
		die();
	}
	$stmt = $PDO->prepare("SELECT * FROM guest_details WHERE guest_id=:uptid AND guest_by=:memid AND guest_status=1");
	$stmt->execute(['uptid' => $id, 'memid' => $memid]);
	if ($stmt->rowCount() == 1) {
		$sql = "UPDATE `guest_details` SET
	            guest_status            = '0',
	            guest_delete_at   = '" . date("Y-m-d H:i:s") . "'
	            WHERE guest_id = {$id}";
		$insert = $PDO->prepare($sql);
		$insert->execute();
		if ($insert->rowCount() > 0) {
			echo $response = json_encode(array(
				"status" => true,
				"msg" => "Successfully Deleted",
			));
		} else {
			echo $response = json_encode(array(
				"status" => false,
				"msg" => "No Change Done",
			));
		}
	} else {
		echo $response = json_encode(array(
			"status" => false,
			"msg" => " Cant Find to Delete",
		));
		die();
	}
} else {
	echo $response = json_encode(array(
		"status" => false,
		"msg" => " Something Wrong",
	));
	die();
}