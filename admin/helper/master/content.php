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
 
	$sid   = (!empty($_POST['sid']))?FilterInput($_POST['sid']):null;
	$eid   = (!empty($_POST['eid']))?FilterInput($_POST['eid']):null;

	$sql ="SELECT * FROM rent_list WHERE rent_status<>2 ";

	if (!empty($sid) AND is_numeric($sid)) {
		$sql.=" AND rent_spoint='$sid' ";
	}
	if (!empty($eid) AND is_numeric($eid)) {
		$sql.=" AND rent_epoint='$eid' ";
	}

	$sql .=" ORDER BY rent_id DESC";

	$stmt = $PDO->prepare($sql);
	$stmt->execute(); 
	if($stmt->rowCount()>0){ ?>
	<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="entry_table">
	<thead>
	<tr>
	<th>#</th>
	<th>SPOINT</th>
	<th>EPOINT</th>
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
	<tr>
	<td><?php echo $i++; ?></td>
	<td><?php echo LocationName($rent_spoint); ?></td>
	<td><?php echo LocationName($rent_epoint); ?></td>
	<td><?php echo StatusReport($rent_status);  ?></td>
	<td>
	<?php 
    if ($rent_status==0) { ?>
    <a href="javascript:void(0);" title="Make Active" class="text-success statusup" data-id="<?php echo htmlspecialchars($rent_id); ?>" data-operation="active"><i class="fa fa-check"></i> || </a>
    <?php }else if($rent_status==1) { ?>
    <a href="javascript:void(0);" title="Make Dective" class="text-danger statusup" data-id="<?php echo $row['rent_id']; ?>" data-operation="deactive"><i class="fa fa-lock"></i> || </a>
    <?php } ?>
	<a href="content-update?id=<?php echo $rent_id; ?>" class="editbtn" title="Update"><i class="fa fa-edit"></i></a> || 
	<a href="javascript:void(0);" class="statusup" title="Delete" data-id="<?php echo htmlspecialchars($rent_id); ?>" data-operation="delete"><i class="fa fa-trash"></i></a>
	</td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
    </div>
	<?php }else{echo '<div class="alert alert-warning"><p>No Category Found</p></div>'; }
}
elseif ($operation=="addnew") {
	$spoint    = (!empty($_POST['spoint']))?FilterInput($_POST['spoint']):null; 
	$sid       = (!empty($_POST['sid']))?FilterInput($_POST['sid']):null; 
	$epoint    = (!empty($_POST['epoint']))?FilterInput($_POST['epoint']):null; 
	$eid       = (!empty($_POST['eid']))?FilterInput($_POST['eid']):null; 
	$det       = (!empty($_POST['det']))?$_POST['det']:null; 

	$hatchnonac    = (!empty($_POST['hatchnonac']))?$_POST['hatchnonac']:0; 
	$sedannonac    = (!empty($_POST['sedannonac']))?$_POST['sedannonac']:0; 
	$standardnonac = (!empty($_POST['standardnonac']))?$_POST['standardnonac']:0; 
	$luxurynonac   = (!empty($_POST['luxurynonac']))?$_POST['luxurynonac']:0; 

	$hatchac       = (!empty($_POST['hatchac']))?$_POST['hatchac']:0; 
	$sedanac       = (!empty($_POST['sedanac']))?$_POST['sedanac']:0; 
	$standardac    = (!empty($_POST['standardac']))?$_POST['standardac']:0; 
	$luxuryac      = (!empty($_POST['luxuryac']))?$_POST['luxuryac']:0; 

	$metatitle = (!empty($_POST['metatitle']))?FilterInput($_POST['metatitle']):null; 
	$metadesc  = (!empty($_POST['metadesc']))?FilterInput($_POST['metadesc']):null; 
	$keywords  = (!empty($_POST['keywords']))?FilterInput($_POST['keywords']):null; 

	$metatitlesocial = (!empty($_POST['metatitlesocial']))?FilterInput($_POST['metatitlesocial']):null; 
	$metadescsocial  = (!empty($_POST['metadescsocial']))?FilterInput($_POST['metadescsocial']):null; 

	if(empty($spoint) OR empty($sid) OR !is_numeric($sid)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Enter Start Point"
		));
		die();
	}
	if(empty($epoint) OR empty($eid) OR !is_numeric($eid)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Enter End Point"
		));
		die();
	}
	if(empty($det)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Enter Details"
		));
		die();
	}
	$chk_exists = CheckExists("rent_list","rent_spoint = '$sid' AND rent_epoint = '$eid' AND rent_status<>2");
	if (!empty($chk_exists)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "This is already Exists"
		));
		die();
	}

	$fbimg=NULL;
	if(!empty($_FILES['fbimg']['name'])) {
		$imgnm     = stripslashes($_FILES['fbimg']['name']);
		$ext       = strtolower(pathinfo($imgnm, PATHINFO_EXTENSION));
		$filename  = "himalayan_wheels_".time().rand(10000,999999999).'.'.$ext;
		if (move_uploaded_file($_FILES['fbimg']['tmp_name'], "../../../images/social/$filename")) {
	        $fbimg = $filename;
	    }
	}
	$twimg=NULL;
	if(!empty($_FILES['twimg']['name'])){
		$imgnm     = stripslashes($_FILES['twimg']['name']);
		$ext       = strtolower(pathinfo($imgnm, PATHINFO_EXTENSION));
		$filename  = "himalayan_wheels_".time().rand(10000,999999999).'.'.$ext;
		if (move_uploaded_file($_FILES['twimg']['tmp_name'], "../../../images/social/$filename")) {
	        $twimg = $filename;
	    }
	}
	$sql = "INSERT INTO rent_list SET
	        rent_spoint          = :rent_spoint,
	        rent_epoint          = :rent_epoint,
	        rent_description     = :rent_description,
	        rent_hatchback_price_nonac = :rent_hatchback_price_nonac,
	        rent_sedan_price_nonac     = :rent_sedan_price_nonac,
	        rent_standard_price_nonac  = :rent_standard_price_nonac,
	        rent_luxury_price_nonac    = :rent_luxury_price_nonac,
	        rent_hatchback_price_ac   = :rent_hatchback_price_ac,
	        rent_sedan_price_ac       = :rent_sedan_price_ac,
	        rent_standard_price_ac    = :rent_standard_price_ac,
	        rent_luxury_price_ac      = :rent_luxury_price_ac,
	        rent_fb_img               = :rent_fb_img,
	        rent_twiter_img           = :rent_twiter_img,
	        rent_metatitle       = :rent_metatitle,
	        rent_metadescription = :rent_metadescription,
	        rent_metakeywords    = :rent_metakeywords,
	        rent_social_metatitle = :rent_social_metatitle,
	        rent_social_metadesc  = :rent_social_metadesc";
	        $insert = $PDO->prepare($sql);
	        $insert->bindParam(':rent_spoint',$sid);
	        $insert->bindParam(':rent_epoint',$eid);
	        $insert->bindParam(':rent_description',$det);
	        $insert->bindParam(':rent_hatchback_price_nonac',$hatchnonac);
	        $insert->bindParam(':rent_sedan_price_nonac',$sedannonac);
	        $insert->bindParam(':rent_standard_price_nonac',$standardnonac);
	        $insert->bindParam(':rent_luxury_price_nonac',$luxurynonac);
	        $insert->bindParam(':rent_hatchback_price_ac',$hatchac);
	        $insert->bindParam(':rent_sedan_price_ac',$sedanac);
	        $insert->bindParam(':rent_standard_price_ac',$standardac);
	        $insert->bindParam(':rent_luxury_price_ac',$luxuryac);

	        $insert->bindParam(':rent_fb_img',$fbimg);
	        $insert->bindParam(':rent_twiter_img',$twimg);

	        $insert->bindParam(':rent_metatitle',$metatitle);
	        $insert->bindParam(':rent_metadescription',$metadesc);
	        $insert->bindParam(':rent_metakeywords',$keywords);

	        $insert->bindParam(':rent_social_metatitle',$metatitlesocial);
	        $insert->bindParam(':rent_social_metadesc',$metadescsocial);
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
    $spoint    = (!empty($_POST['spoint']))?FilterInput($_POST['spoint']):null; 
	$sid       = (!empty($_POST['sid']))?FilterInput($_POST['sid']):null; 
	$epoint    = (!empty($_POST['epoint']))?FilterInput($_POST['epoint']):null; 
	$eid       = (!empty($_POST['eid']))?FilterInput($_POST['eid']):null; 
	$det       = (!empty($_POST['det']))?$_POST['det']:null; 

	$hatchnonac    = (!empty($_POST['hatchnonac']))?$_POST['hatchnonac']:0; 
	$sedannonac    = (!empty($_POST['sedannonac']))?$_POST['sedannonac']:0; 
	$standardnonac = (!empty($_POST['standardnonac']))?$_POST['standardnonac']:0; 
	$luxurynonac   = (!empty($_POST['luxurynonac']))?$_POST['luxurynonac']:0; 

	$hatchac    = (!empty($_POST['hatchac']))?$_POST['hatchac']:0; 
	$sedanac    = (!empty($_POST['sedanac']))?$_POST['sedanac']:0; 
	$standardac = (!empty($_POST['standardac']))?$_POST['standardac']:0; 
	$luxuryac   = (!empty($_POST['luxuryac']))?$_POST['luxuryac']:0; 


	$metatitle = (!empty($_POST['metatitle']))?FilterInput($_POST['metatitle']):null; 
	$metadesc  = (!empty($_POST['metadesc']))?FilterInput($_POST['metadesc']):null; 
	$keywords  = (!empty($_POST['keywords']))?FilterInput($_POST['keywords']):null; 

	$metatitlesocial = (!empty($_POST['metatitlesocial']))?FilterInput($_POST['metatitlesocial']):null; 
	$metadescsocial  = (!empty($_POST['metadescsocial']))?FilterInput($_POST['metadescsocial']):null; 

	if(empty($uptid) OR !is_numeric($uptid)) {
		echo $response = json_encode(array(
			"status" => false,
			"msg"	 => "Cant find"
		));
		die();
	}
	if (!is_numeric($hatchnonac) OR !is_numeric($sedannonac) OR !is_numeric($standardnonac) OR !is_numeric($luxurynonac) OR !is_numeric($hatchac) OR !is_numeric($sedanac) OR !is_numeric($standardac) OR !is_numeric($luxuryac)) {
		echo $response = json_encode(array(
			"status" => false,
			"msg"	 => "Price Should be in Numeric Form"
		));
		die();
	}
	$rentdet = CheckExists("rent_list","rent_id = '$uptid' AND rent_status<>2");
	if (empty($rentdet)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Cant find"
		));
		die();
	}
	if(empty($spoint) OR empty($sid) OR !is_numeric($sid)) {
		echo $response = json_encode(array(
			"status" => false,
			"msg"	 => "Enter Start Point"
		));
		die();
	}
	$chk_spoint = CheckExists("locations"," loc_id<>'$sid' AND loc_status<>2");
	if (empty($chk_spoint)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Start Pont Cant Find"
		));
		die();
	}
	if(empty($epoint) OR empty($eid) OR !is_numeric($eid)) {
		echo $response = json_encode(array(
			"status" => false,
			"msg"	 => "Enter End Point"
		));
		die();
	}
	$chk_epoint = CheckExists("locations"," loc_id<>'$eid' AND loc_status<>2");
	if (empty($chk_epoint)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "End Pont Cant Find"
		));
		die();
	}
	if(empty($det)) {
		echo $response = json_encode(array(
			"status" => false,
			"msg"	 => "Enter Details"
		));
		die();
	}
	$chk_exists = CheckExists("rent_list","rent_spoint = '$sid' AND rent_epoint = '$eid' AND rent_id<>'$uptid' AND rent_status<>2");
	if (!empty($chk_exists)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "This is already Exists"
		));
		die();
	}


	$fbimg=$rentdet['rent_fb_img'];
	if(!empty($_FILES['fbimg']['name'])) {
		$imgnm     = stripslashes($_FILES['fbimg']['name']);
		$ext       = strtolower(pathinfo($imgnm, PATHINFO_EXTENSION));
		$filename  = "himalayan_wheels_".time().rand(10000,999999999).'.'.$ext;
		if (move_uploaded_file($_FILES['fbimg']['tmp_name'], "../../../images/social/$filename")) {
	        $fbimg = $filename;
	        if ((!empty($rentdet['rent_fb_img'])) AND file_exists("../../../images/social/".$rentdet['rent_fb_img'])) {
				@unlink("../../../images/social/".$rentdet['rent_fb_img']);
			}
	    }
	}

	$twimg=$rentdet['rent_twiter_img'];
	if(!empty($_FILES['twimg']['name'])){
		$imgnm     = stripslashes($_FILES['twimg']['name']);
		$ext       = strtolower(pathinfo($imgnm, PATHINFO_EXTENSION));
		$filename  = "himalayan_wheels_".time().rand(10000,999999999).'.'.$ext;
		if (move_uploaded_file($_FILES['twimg']['tmp_name'], "../../../images/social/$filename")) {
	        $twimg = $filename;
	        if ((!empty($rentdet['rent_twiter_img'])) AND file_exists("../../../images/social/".$rentdet['rent_twiter_img'])) {
				unlink("../../../images/social/".$rentdet['rent_twiter_img']);
			}
	    }
	}

	$sql = "UPDATE rent_list SET
	        rent_spoint          = :rent_spoint,
	        rent_epoint          = :rent_epoint,
	        rent_description     = :rent_description,
	        rent_metatitle       = :rent_metatitle,
	        rent_metadescription = :rent_metadescription,
	        rent_metakeywords    = :rent_metakeywords,
	        rent_hatchback_price_nonac = :rent_hatchback_price_nonac,
	        rent_sedan_price_nonac     = :rent_sedan_price_nonac,
	        rent_standard_price_nonac  = :rent_standard_price_nonac,
	        rent_luxury_price_nonac    = :rent_luxury_price_nonac,
	        rent_hatchback_price_ac   = :rent_hatchback_price_ac,
	        rent_sedan_price_ac       = :rent_sedan_price_ac,
	        rent_standard_price_ac    = :rent_standard_price_ac,
	        rent_luxury_price_ac      = :rent_luxury_price_ac,
	        rent_social_metatitle 	  = :rent_social_metatitle,
	        rent_social_metadesc      = :rent_social_metadesc,
	        rent_fb_img               = :rent_fb_img,
	        rent_twiter_img           = :rent_twiter_img
	        WHERE rent_id=:rent_id";
	        $insert = $PDO->prepare($sql);
	        $insert->bindParam(':rent_spoint',$sid);
	        $insert->bindParam(':rent_epoint',$eid);
	        $insert->bindParam(':rent_description',$det);
	        $insert->bindParam(':rent_metatitle',$metatitle);
	        $insert->bindParam(':rent_metadescription',$metadesc);
	        $insert->bindParam(':rent_metakeywords',$keywords);

	        $insert->bindParam(':rent_hatchback_price_nonac',$hatchnonac);
	        $insert->bindParam(':rent_sedan_price_nonac',$sedannonac);
	        $insert->bindParam(':rent_standard_price_nonac',$standardnonac);
	        $insert->bindParam(':rent_luxury_price_nonac',$luxurynonac);
	        $insert->bindParam(':rent_hatchback_price_ac',$hatchac);
	        $insert->bindParam(':rent_sedan_price_ac',$sedanac);
	        $insert->bindParam(':rent_standard_price_ac',$standardac);
	        $insert->bindParam(':rent_luxury_price_ac',$luxuryac);
	        
	        $insert->bindParam(':rent_social_metatitle',$metatitlesocial);
	        $insert->bindParam(':rent_social_metadesc',$metadescsocial);

	        $insert->bindParam(':rent_fb_img',$fbimg);
	        $insert->bindParam(':rent_twiter_img',$twimg);

	        $insert->bindParam(':rent_id',$uptid);
	        $insert->execute();
	        if($insert->rowCount() > 0){
	        	echo $response = json_encode(array(
					"status" => true, 
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
	$chk_id = CheckExists("rent_list","rent_id = '$id' AND rent_status<>2");
	if (empty($chk_id)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Cant Find this Entry"
		));
		die();
	}
	$ad = ($operation=='delete')?", rent_delete_at=NOW()":null;
	$sql = "UPDATE rent_list SET rent_status= {$up} ".$ad. " WHERE rent_id= {$id}";
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