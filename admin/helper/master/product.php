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
	$stmt = $PDO->prepare("SELECT * FROM product_list INNER JOIN category ON category.category_id = product_list.category_id_ref_product  WHERE product_status<>2 ORDER BY product_id DESC");
	$stmt->execute(); 
	if($stmt->rowCount()>0){ ?>
	<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="entry_table">
	<thead>
	<tr>
	<th>#</th>
	<th>CATEGORY</th>
	<th>NAME</th>
	<th>PRICE</th>
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
	<td><?php echo $category_name; ?></td>
	<td style="text-align:left;"><?php echo $product_name; ?></td>
	<td><?php echo $product_selling_price.' | <small><strike>'.$product_mrp.'</strike></small>'; ?></td>
	<td><?php echo StatusReport($product_status);  ?></td>
	<td>
	<a href="product-view?id=<?php echo htmlspecialchars($product_id); ?>" class="editbtn" title="Update"><i class="fa fa-cog"></i></a> || 
	<?php 
    if ($product_status==0) { ?>
    <a href="javascript:void(0);" title="Make Active" class="text-inverse statusup" data-id="<?php echo htmlspecialchars($product_id); ?>" data-operation="active"><i class="fa fa-check"></i> || </a>
    <?php }else if($product_status==1) { ?>
    <a href="javascript:void(0);" title="Make Dective" class="text-inverse statusup" data-id="<?php echo $row['product_id']; ?>" data-operation="deactive"><i class="fa fa-lock"></i> || </a>
    <?php } ?>
	<a href="product-update?id=<?php echo htmlspecialchars($product_id); ?>" class="editbtn" title="Update"><i class="fa fa-edit"></i></a> || 
	<a href="javascript:void(0);" class="statusup" title="Delete" data-id="<?php echo htmlspecialchars($product_id); ?>" data-operation="delete"><i class="fa fa-trash"></i></a>
	</td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
    </div>
	<?php }else{echo '<div class="alert alert-warning"><p>No Saree Found</p></div>'; }
}
elseif ($operation=="fetchsubcategory") {
	$catid=(!empty($_POST['catid']))?FilterInput($_POST['catid']):null;
	$stmt = $PDO->prepare("SELECT * FROM sub_category WHERE parent_category_id_ref='$catid' AND s_category_status=1 ORDER BY s_category_name ASC");
	$stmt->execute(); 
	if($stmt->rowCount()>0){
	        echo  '<option value=""> --Please Select-- </option>';
	      while ($row=$stmt->fetch()){ ?>
	        <option value="<?php echo $row['s_category_id']; ?>"><?php echo $row['s_category_name']; ?></option>
	      <?php } 
	}else {
	    echo  '<option value=""> --No Data Found-- </option>';
	}
}
elseif ($operation=="fetchsubsubcategory") {
	$catid=(!empty($_POST['catid']))?FilterInput($_POST['catid']):null;
	$stmt = $PDO->prepare("SELECT * FROM sub_sub_category WHERE sub_parent_category_id_ref='$catid' AND s_s_category_status=1 ORDER BY s_s_category_name ASC");
	$stmt->execute(); 
	if($stmt->rowCount()>0){
	        echo  '<option value=""> --Please Select-- </option>';
	      while ($row=$stmt->fetch()){ ?>
	        <option value="<?php echo $row['s_s_category_id']; ?>"><?php echo $row['s_s_category_name']; ?></option>
	      <?php } 
	}else {
	    echo  '<option value=""> --No Data Found-- </option>';
	}
}
elseif ($operation=="fetchgal"){
	$proid = (!empty($_POST['protid']))?FilterInput($_POST['protid']):null;
	if(empty($proid) AND !is_numeric($proid)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Image Not Found"
		));
		die();
	}
	$stmt = $PDO->prepare("SELECT * FROM product_images WHERE product_id_ref_gallery='$proid' ORDER BY image_id DESC");
	$stmt->execute(); 
	if($stmt->rowCount()>0){ ?>
	<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="entry_table">
	<thead>
	<tr>
	<th>#</th>
	<th>LARGE</th>
	<th>MEDIUM</th>
	<th>THUMB</th>
	<th>SMALL</th>
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
	<td><img height="20" src="<?php echo "../upload/products/large/".$image_large; ?>"></td>
	<td><img height="20" src="<?php echo "../upload/products/medium/".$image_main; ?>"></td>
	<td><img height="20" src="<?php echo "../upload/products/thumb/".$image_thumb; ?>"></td>
	<td><img height="20" src="<?php echo "../upload/products/small/".$image_small; ?>"></td>
	<td><?php echo StatusReport($image_status);  ?></td>
	<td>
	<?php 
    if ($image_status==0) { ?>
    <a href="javascript:void(0);" title="Make Active" class="text-inverse statusup" data-id="<?php echo htmlspecialchars($image_id); ?>" data-operation="activegal"><i class="fa fa-check"></i> || </a>
    <?php }else if($image_status==1) { ?>
    <a href="javascript:void(0);" title="Make Dective" class="text-inverse statusup" data-id="<?php echo $row['image_id']; ?>" data-operation="deactivegal"><i class="fa fa-lock"></i> || </a>
    <?php } ?>
	<a href="" data-toggle="modal" data-target="#upGal" data-id="<?php echo htmlspecialchars($image_id); ?>" class="editbtn" title="Update"><i class="fa fa-edit"></i></a> || 
	<a href="javascript:void(0);" class="statusup" title="Delete" data-id="<?php echo htmlspecialchars($image_id); ?>" data-operation="deletegal"><i class="fa fa-trash"></i></a>
	</td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
    </div>
	<?php }else{echo '<div class="alert alert-warning"><p>No Image Found</p></div>'; }
}
elseif ($operation=="activegal" OR $operation=="deactivegal" OR $operation=="deletegal") {

	$id =FilterInput($_POST['id']);
	if(empty($id) AND !is_numeric($id)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Something Wrong"
		));
		die();
	}
	$stmt = $PDO->prepare("SELECT * FROM product_images WHERE image_id=:id");
	$stmt->execute(['id' => $id]); 
	if ($stmt->rowCount()!=1){ 
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => " Cant Find Image"
		));
		die();
	}
	$imgdet = $stmt->fetch();
	extract($imgdet);
	if ($operation=="activegal" OR $operation=="deactivegal") {
		$up=1;
		if ($operation=="deactivegal") {$up=0;}
		$sql = "UPDATE product_images SET image_status= {$up}  WHERE image_id= {$id}";
			$insert = $PDO->prepare($sql);
			$insert->execute();
			if($insert->rowCount() > 0){
					echo $response = json_encode(array(
					"status" => true, 
					"msg"	 => "Success"
				));
			}else {
				echo $response = json_encode(array(
					"status" =>false,
					"msg"	 =>"No Change Done"
				));
			}
	}
	if ($operation=="deletegal") {
		$sql = "DELETE FROM product_images WHERE image_id= {$id};";
			$insert = $PDO->prepare($sql);
			$insert->execute();
			if($insert->rowCount() > 0){
				echo $response = json_encode(array(
					"status" => true, 
					"msg"	 => "Success"
				));

				@unlink('../../../upload/products/large/'.$image_large);
				@unlink('../../../upload/products/medium/'.$image_main);
				@unlink('../../../upload/products/thumb/'.$image_thumb);
				@unlink('../../../upload/products/small/'.$image_small);

			}else {
				echo $response = json_encode(array(
					"status" =>false,
					"msg"	 =>"No Change Done"
				));
			}
	}
}
elseif ($operation=="addnew") {
	$category       = (!empty($_POST['category']))?FilterInput($_POST['category']):null; 
	$subcategory    = (!empty($_POST['subcategory']))?FilterInput($_POST['subcategory']):null; 
	$subsubcategory = (!empty($_POST['subsubcategory']))?FilterInput($_POST['subsubcategory']):null; 

	$pname      = (!empty($_POST['pname']))?FilterInput($_POST['pname']):null; 
	$purl       = (!empty($_POST['purl']))?FilterInput($_POST['purl']):null;

	$type       = (!empty($_POST['type']))?implode(',',$_POST['type']):null; 
	$work       = (!empty($_POST['work']))?implode(',',$_POST['work']):null; 
	$fabric     = (!empty($_POST['fabric']))?implode(',',$_POST['fabric']):null; 
	$occasion   = (!empty($_POST['occasion']))?implode(',',$_POST['occasion']):null; 
	
	$color      = (!empty($_POST['color']))?$_POST['color']:null; 

	$mrp   = (!empty($_POST['mrp']))?FilterInput($_POST['mrp']):null; 
	$sp    = (!empty($_POST['sp']))?FilterInput($_POST['sp']):null;

	$high  = (!empty($_POST['high']))?$_POST['high']:null; 
	$desc  = (!empty($_POST['desc']))?$_POST['desc']:null; 

	$metatitle = (!empty($_POST['metatitle']))?FilterInput($_POST['metatitle']):null; 
	$metadesc  = (!empty($_POST['metadesc']))?FilterInput($_POST['metadesc']):null; 
	$keywords  = (!empty($_POST['keywords']))?FilterInput($_POST['keywords']):null; 


	if(empty($category) OR empty($pname) OR empty($purl) OR empty($mrp) OR empty($sp)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Enter * Marked All Fields"
		));
		die();
	}

	$chk_category = CheckExists("category","category_id = {$category} AND category_status=1");
	if(!is_numeric($category) OR empty($chk_category)){
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Main Category Not Found"
		));
		die();
	}
	
	if(!is_numeric($mrp) OR $mrp<=0){
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Price Should Be Positive & Numeric"
		));
		die();
	}
	if(!is_numeric($sp) OR $sp<=0){
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Selling Price Should Be Positive & Numeric"
		));
		die();
	}
	if( $mrp<$sp){
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Selling Price Should Be Less than MRP"
		));
		die();
	}
	$chk_slug = CheckExists("product_list","product_slug = '$purl' AND product_status<>2");
	if (!empty($chk_slug)){
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Change URL...its Exists"
		));
		die();
	}
    $sql = "INSERT INTO product_list SET
	        category_id_ref_product  = :category_id_ref_product,
	        sub_category_ref_product  = :sub_category_ref_product,
	        sub_sub_category_ref_product      = :sub_sub_category_ref_product,
	        product_name  = :product_name,
	        product_slug    = :product_slug,
	        types_ref_product     = :types_ref_product,
	        work_ref_product  = :work_ref_product,
	        fabrics_ref_product      = :fabrics_ref_product,
	        color_ref_product            = :color_ref_product,
	        occasions_ref_product  = :occasions_ref_product,
	        product_mrp  = :product_mrp,
	        product_selling_price   = :product_selling_price,
	        product_highlights      = :product_highlights,
	        product_description     = :product_description,
	        product_metatitle       = :product_metatitle,
	        product_metadescripton  = :product_metadescripton,
	        product_keywords        = :product_keywords";
	        $insert = $PDO->prepare($sql);
	        $insert->bindParam(':category_id_ref_product',$category);
	        $insert->bindParam(':sub_category_ref_product',$subcategory);
	        $insert->bindParam(':sub_sub_category_ref_product',$subsubcategory);
	        $insert->bindParam(':product_name',$pname);
	        $insert->bindParam(':product_slug',$purl);
	        $insert->bindParam(':types_ref_product',$type);
	        $insert->bindParam(':work_ref_product',$work);
	        $insert->bindParam(':fabrics_ref_product',$fabric);
	        $insert->bindParam(':color_ref_product',$color);
	        $insert->bindParam(':occasions_ref_product',$occasion);
	        $insert->bindParam(':product_mrp',$mrp);
	        $insert->bindParam(':product_selling_price',$sp);
	        $insert->bindParam(':product_highlights',$high);
	        $insert->bindParam(':product_description',$desc);
	        $insert->bindParam(':product_metatitle',$metatitle);
	        $insert->bindParam(':product_metadescripton',$metadesc);
	        $insert->bindParam(':product_keywords',$keywords);
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
	$tid            = (!empty($_POST['tid']))?FilterInput($_POST['tid']):null; 
    $category       = (!empty($_POST['category']))?FilterInput($_POST['category']):null; 
	$subcategory    = (!empty($_POST['subcategory']))?FilterInput($_POST['subcategory']):null; 
	$subsubcategory = (!empty($_POST['subsubcategory']))?FilterInput($_POST['subsubcategory']):null; 

	$pname      = (!empty($_POST['pname']))?FilterInput($_POST['pname']):null; 
	$purl       = (!empty($_POST['purl']))?FilterInput($_POST['purl']):null;

	$type       = (!empty($_POST['type']))?implode(',',$_POST['type']):null; 
	$work       = (!empty($_POST['work']))?implode(',',$_POST['work']):null; 
	$fabric     = (!empty($_POST['fabric']))?implode(',',$_POST['fabric']):null; 
	$occasion   = (!empty($_POST['occasion']))?implode(',',$_POST['occasion']):null; 
	
	$color      = (!empty($_POST['color']))?$_POST['color']:null; 

	$mrp   = (!empty($_POST['mrp']))?FilterInput($_POST['mrp']):null; 
	$sp    = (!empty($_POST['sp']))?FilterInput($_POST['sp']):null;

	$high  = (!empty($_POST['high']))?$_POST['high']:null; 
	$desc  = (!empty($_POST['desc']))?$_POST['desc']:null; 

	$metatitle = (!empty($_POST['metatitle']))?FilterInput($_POST['metatitle']):null; 
	$metadesc  = (!empty($_POST['metadesc']))?FilterInput($_POST['metadesc']):null; 
	$keywords  = (!empty($_POST['keywords']))?FilterInput($_POST['keywords']):null; 


	if(empty($category) OR empty($pname) OR empty($purl) OR empty($mrp) OR empty($sp)) {
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Enter * Marked All Fields"
		));
		die();
	}

	$chk_pro = CheckExists("product_list","product_id = {$tid} AND product_status<>2");
	if(empty($chk_pro)){
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Product Not Found"
		));
		die();
	}

	$chk_category = CheckExists("category","category_id = {$category} AND category_status=1");
	if(!is_numeric($category) OR empty($chk_category)){
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Main Category Not Found"
		));
		die();
	}
	
	if(!is_numeric($mrp) OR $mrp<=0){
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Price Should Be Positive & Numeric"
		));
		die();
	}
	if(!is_numeric($sp) OR $sp<=0){
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Selling Price Should Be Positive & Numeric"
		));
		die();
	}
	if( $mrp<$sp){
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Selling Price Should Be Less than MRP"
		));
		die();
	}
	$chk_slug = CheckExists("product_list","product_slug = '$purl' AND product_id<>'$tid' AND product_status<>2");
	if (!empty($chk_slug)){
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => "Change URL...its Exists"
		));
		die();
	}
    $sql = "UPDATE product_list SET
	        category_id_ref_product      = :category_id_ref_product,
	        sub_category_ref_product     = :sub_category_ref_product,
	        sub_sub_category_ref_product = :sub_sub_category_ref_product,
	        product_name                 = :product_name,
	        product_slug                 = :product_slug,
	        types_ref_product            = :types_ref_product,
	        work_ref_product             = :work_ref_product,
	        fabrics_ref_product          = :fabrics_ref_product,
	        color_ref_product            = :color_ref_product,
	        occasions_ref_product        = :occasions_ref_product,
	        product_mrp                  = :product_mrp,
	        product_selling_price   = :product_selling_price,
	        product_highlights      = :product_highlights,
	        product_description     = :product_description,
	        product_metatitle       = :product_metatitle,
	        product_metadescripton  = :product_metadescripton,
	        product_keywords        = :product_keywords
	        WHERE product_id=:product_id";
	        $insert = $PDO->prepare($sql);
	        $insert->bindParam(':category_id_ref_product',$category);
	        $insert->bindParam(':sub_category_ref_product',$subcategory);
	        $insert->bindParam(':sub_sub_category_ref_product',$subsubcategory);
	        $insert->bindParam(':product_name',$pname);
	        $insert->bindParam(':product_slug',$purl);
	        $insert->bindParam(':types_ref_product',$type);
	        $insert->bindParam(':work_ref_product',$work);
	        $insert->bindParam(':fabrics_ref_product',$fabric);
	        $insert->bindParam(':color_ref_product',$color);
	        $insert->bindParam(':occasions_ref_product',$occasion);
	        $insert->bindParam(':product_mrp',$mrp);
	        $insert->bindParam(':product_selling_price',$sp);
	        $insert->bindParam(':product_highlights',$high);
	        $insert->bindParam(':product_description',$desc);
	        $insert->bindParam(':product_metatitle',$metatitle);
	        $insert->bindParam(':product_metadescripton',$metadesc);
	        $insert->bindParam(':product_keywords',$keywords);
	        $insert->bindParam(':product_id',$tid);
	        $insert->execute();
	        if($insert->rowCount() > 0){
	        		echo $response = json_encode(array(
						"status" => true, 
						"msg"	 => "Successfully Update"
					));
	        }else {
	        	echo $response = json_encode(array(
					"status" =>false,
					"msg"	 =>"No Change Done"
				));
			}

			die();
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
	$stmt = $PDO->prepare("SELECT * FROM product_list WHERE product_id=:id");
	$stmt->execute(['id' => $id]); 
	if ($stmt->rowCount()!=1){ 
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => " Cant Find to Activate"
		));
		die();
	}
	$ad = ($operation=='delete')?", saree_delete_at=NOW()":null;
	$sql = "UPDATE product_list SET product_status= {$up} ".$ad. " WHERE product_id= {$id}";
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
}elseif ($operation=="adgallery") {
	
    $data  = $_POST['imagebase64'];
    $proid = $_POST['proid'];

    if (empty($proid) OR !is_numeric($proid)) {
    	echo $response = json_encode(array(
					"status" =>false,
					"msg"	 =>"Poduct Not Found"
				));
    	die();
    }

    list($type,$data) = explode(';', $data);
    list(, $data)     = explode(',', $data);
    $imgdata          = base64_decode($data);

    $mainimg = imagecreatefromstring($imgdata);
    if($mainimg == false) {
    	echo $response = json_encode(array(
			"status" => false,
			"msg"	 => "Something Problem in Image try new"
		));
		die();
    }
    $width   = imagesx($mainimg);
    $height  = imagesy($mainimg);
    $dir="../../../upload/products/medium/";
    $imgnamemain = $width.'x'.$height.'_'.time().rand(10000,99999999).'.'."jpg";
    $save    = imagejpeg($mainimg,$dir.$imgnamemain,60);

    $dir="../../../upload/products/large/";
    $new_w=550;$new_h=733;
	$largeimg = $new_w.'x'.$new_h.'_'.time().rand(10000,99999999).'.'."jpg";
    $newimg = imagecreatetruecolor($new_w,$new_h);
	imagecopyresampled($newimg, $mainimg, 0, 0, 0, 0, $new_w, $new_h, $width, $height);
	imagejpeg($newimg, $dir.$largeimg, 60);

	$dir="../../../upload/products/thumb/";
    $new_w=300;$new_h=400;
    $thumb = $new_w.'x'.$new_h.'_'.time().rand(10000,99999999).'.'."jpg";
    $newimg = imagecreatetruecolor($new_w,$new_h);
	imagecopyresampled($newimg, $mainimg, 0, 0, 0, 0, $new_w, $new_h, $width, $height);
	imagejpeg($newimg, $dir.$thumb, 60);

	$dir="../../../upload/products/small/";
    $new_w=80;$new_h=107;
    $small = $new_w.'x'.$new_h.'_'.time().rand(10000,99999999).'.'."jpg";
    $newimg = imagecreatetruecolor($new_w,$new_h);
	imagecopyresampled($newimg, $mainimg, 0, 0, 0, 0, $new_w, $new_h, $width, $height);
	imagejpeg($newimg, $dir.$small, 50);

	imagedestroy($mainimg);
	imagedestroy($newimg);

	$sql = "INSERT INTO product_images SET
	        product_id_ref_gallery  = :product_id_ref_gallery,
	        image_large  = :image_large,
	        image_main   = :image_main,
	        image_thumb  = :image_thumb,
	        image_small  = :image_small";
	        $insert = $PDO->prepare($sql);
	        $insert->bindParam(':product_id_ref_gallery',$proid);
	        $insert->bindParam(':image_large',$largeimg);
	        $insert->bindParam(':image_main',$imgnamemain);
	        $insert->bindParam(':image_thumb',$thumb);
	        $insert->bindParam(':image_small',$small);
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
elseif ($operation=="upgallery") {
	
    $data  = $_POST['imagebase64'];
    $galid = $_POST['galid'];

    if (empty($galid) OR !is_numeric($galid)) {
    	echo $response = json_encode(array(
					"status" =>false,
					"msg"	 =>"Image Not Found"
				));
    	die();
    }

    $stmt = $PDO->prepare("SELECT * FROM product_images WHERE image_id=:id");
	$stmt->execute(['id' => $galid]); 
	if ($stmt->rowCount()!=1){ 
		echo $response = json_encode(array(
				"status" => false,
				"msg"	 => " Cant Find Image"
		));
		die();
	}
	$imgdet = $stmt->fetch();
	extract($imgdet);

    list($type,$data) = explode(';', $data);
    list(, $data)     = explode(',', $data);
    $imgdata          = base64_decode($data);

    $mainimg = imagecreatefromstring($imgdata);
    if($mainimg == false) {
    	echo $response = json_encode(array(
			"status" => false,
			"msg"	 => "Something Problem in Image try new"
		));
		die();
    }
    $width   = imagesx($mainimg);
    $height  = imagesy($mainimg);
    $dir="../../../upload/products/medium/";
    $imgnamemain = $width.'x'.$height.'_'.time().rand(10000,99999999).'.'."jpg";
    $save    = imagejpeg($mainimg,$dir.$imgnamemain,60);

    $dir="../../../upload/products/large/";
    $new_w=550;$new_h=733;
	$largeimg = $new_w.'x'.$new_h.'_'.time().rand(10000,99999999).'.'."jpg";
    $newimg = imagecreatetruecolor($new_w,$new_h);
	imagecopyresampled($newimg, $mainimg, 0, 0, 0, 0, $new_w, $new_h, $width, $height);
	imagejpeg($newimg, $dir.$largeimg, 60);

	$dir="../../../upload/products/thumb/";
    $new_w=300;$new_h=400;
    $thumb = $new_w.'x'.$new_h.'_'.time().rand(10000,99999999).'.'."jpg";
    $newimg = imagecreatetruecolor($new_w,$new_h);
	imagecopyresampled($newimg, $mainimg, 0, 0, 0, 0, $new_w, $new_h, $width, $height);
	imagejpeg($newimg, $dir.$thumb, 60);

	$dir="../../../upload/products/small/";
    $new_w=80;$new_h=107;
    $small = $new_w.'x'.$new_h.'_'.time().rand(10000,99999999).'.'."jpg";
    $newimg = imagecreatetruecolor($new_w,$new_h);
	imagecopyresampled($newimg, $mainimg, 0, 0, 0, 0, $new_w, $new_h, $width, $height);
	imagejpeg($newimg, $dir.$small, 50);

	imagedestroy($mainimg);
	imagedestroy($newimg);

	$sql = "UPDATE product_images SET
	        image_large  = :image_large,
	        image_main   = :image_main,
	        image_thumb  = :image_thumb,
	        image_small  = :image_small

	        WHERE image_id=:galid";
	        $insert = $PDO->prepare($sql);
	        $insert->bindParam(':image_large',$largeimg);
	        $insert->bindParam(':image_main',$imgnamemain);
	        $insert->bindParam(':image_thumb',$thumb);
	        $insert->bindParam(':image_small',$small);
	        $insert->bindParam(':galid',$galid);
	        $insert->execute();
	        if($insert->rowCount() > 0){
	        		echo $response = json_encode(array(
						"status" => true, 
						"msg"	 => "Successfully Added"
					));

	        	@unlink('../../../upload/products/large/'.$image_large);
				@unlink('../../../upload/products/medium/'.$image_main);
				@unlink('../../../upload/products/thumb/'.$image_thumb);
				@unlink('../../../upload/products/small/'.$image_small);


	        }else {
	        	echo $response = json_encode(array(
					"status" =>false,
					"msg"	 =>"Something Wrong"
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