<?php include '_auth.php'; ?>
<?php
$id=FilterInput($_GET['id']);
if(!is_numeric($id)){include '../404.php';die();}
$chk_exists = CheckExists("rent_list","rent_id = '$id' AND rent_status<>2");
if(empty($chk_exists)){include '../404.php';die();}
extract($chk_exists);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Rumble</title>
<?php include '_header.php'; ?>
<style type="text/css">
label {}
.custom-control-label::after{position:absolute;top:0rem;left:20px;display:block;width:1.5rem;height:1.5rem;content:"";background-repeat:no-repeat;background-position:center center;background-size:64% 100%}
.custom-control-label::before{position:absolute;top:0rem;left:20px;display:block;width:1.5rem;height:1.5rem;pointer-events:none;content:"";-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;background-color:#dee2e6}
.custom-control{position:relative;display:block;min-height:1.5rem;padding-left:3.5rem}
</style>
</head>
<body>
<?php  include '_menu.php'; ?>
<div class="row">
<div class="col-md-12">
<div class="card card-statistics h-100">
<div class="card-title">
<h5>Update Content <a href="content-list" class="button x-small pull-right"><i class="fa fa-long-arrow-left"></i> Back</a></h5>
</div> 
<div class="card-body">
<form action="" autocomplete="off" id="addfrm">
<input type="hidden" name="uptid" value="<?php echo $rent_id; ?>">
<div class="row">
<div class="form-group col-sm-6 ui-widget">
<label for="spoint">Start Point:<span class="req">*</span></label>
<input type="text" class="form-control" id="spoint" name="spoint" required="" value="<?php echo LocationName($rent_spoint); ?>">
<input type="hidden" class="form-control" id="sid" name="sid" value="<?php echo $rent_spoint; ?>">
</div>
<div class="form-group col-sm-6">
<label for="epoint">End Point:<span class="req">*</span></label>
<input type="text" class="form-control" id="epoint" name="epoint" required="" value="<?php echo LocationName($rent_epoint); ?>">
<input type="hidden" class="form-control" id="eid" name="eid" value="<?php echo $rent_epoint; ?>">
</div>
<div class="form-group col-sm-12">
<label for="det">Content Details:</label>
<textarea class="form-control editor" rows="7" id="det" name="det"><?php echo $rent_description; ?></textarea>
</div>
<div class="form-group col-sm-3 ui-widget">
<label for="hatchnonac">Hatchback Price(NON-AC):<span class="req">*</span></label>
<input type="text" class="form-control" id="hatchnonac" name="hatchnonac" required="" value="<?php echo $rent_hatchback_price_nonac; ?>">
</div>
<div class="form-group col-sm-3 ui-widget">
<label for="sedannonac">Sedan Price(NON-AC):<span class="req">*</span></label>
<input type="text" class="form-control" id="sedannonac" name="sedannonac" required="" value="<?php echo $rent_sedan_price_nonac; ?>">
</div>
<div class="form-group col-sm-3 ui-widget">
<label for="standardnonac">Standard Price(NON-AC):<span class="req">*</span></label>
<input type="text" class="form-control" id="standardnonac" name="standardnonac" required="" value="<?php echo $rent_standard_price_nonac; ?>">
</div>
<div class="form-group col-sm-3 ui-widget">
<label for="luxurynonac">Luxury Price(NON-AC):<span class="req">*</span></label>
<input type="text" class="form-control" id="luxurynonac" name="luxurynonac" required="" value="<?php echo $rent_luxury_price_nonac; ?>">
</div>
<div class="form-group col-sm-3 ui-widget">
<label for="hatchac">Hatchback Price(AC):<span class="req">*</span></label>
<input type="text" class="form-control" id="hatchac" name="hatchac" required="" value="<?php echo $rent_hatchback_price_ac; ?>">
</div>
<div class="form-group col-sm-3 ui-widget">
<label for="sedanac">Sedan Price(AC):<span class="req">*</span></label>
<input type="text" class="form-control" id="sedanac" name="sedanac" required="" value="<?php echo $rent_sedan_price_ac; ?>">
</div>
<div class="form-group col-sm-3 ui-widget">
<label for="standardac">Standard Price(AC):<span class="req">*</span></label>
<input type="text" class="form-control" id="standardac" name="standardac" required="" value="<?php echo $rent_standard_price_ac; ?>">
</div>
<div class="form-group col-sm-3 ui-widget">
<label for="luxuryac">Luxury Price(AC):<span class="req">*</span></label>
<input type="text" class="form-control" id="luxuryac" name="luxuryac" required="" value="<?php echo $rent_luxury_price_ac; ?>">
</div>
<div class="form-group col-sm-6 ui-widget">
<label for="fbimg">Facebook Image:</label>
<input type="file" class="form-control" id="fbimg" name="fbimg">
<small>Size: 1200 x 628</small>
</div>
<div class="form-group col-sm-6 ui-widget">
<label for="twimg">Twitter Image:</label>
<input type="file" class="form-control" id="twimg" name="twimg">
<small>Size: 1024 x 512</small>
</div>
<div class="form-group col-sm-12">
<label for="metatitle">Meta Title:</label>
<textarea class="form-control" rows="2" id="metatitle" name="metatitle"><?php echo $rent_metatitle; ?></textarea>
<small class="form-text text-muted">Title of the Page <span class="pull-right titlemsg"></span></small>
</div>
<div class="form-group col-sm-12">
<label for="metadesc">Meta Description:</label>
<textarea class="form-control" rows="3" id="metadesc" name="metadesc"><?php echo $rent_metadescription; ?></textarea>
<small class="form-text text-muted">Briefly Describe About Page <span class="pull-right descmsg"></span></small>
</div>
<div class="form-group col-sm-12">
<label for="keywords">Keywords:</label>
<textarea class="form-control" rows="2" id="keywords" name="keywords"><?php echo $rent_metakeywords; ?></textarea>
</div>
<div class="form-group col-sm-12">
<label for="metatitlesocial">Title for Social:</label>
<textarea class="form-control" rows="2" id="metatitlesocial" name="metatitlesocial"><?php echo $rent_social_metatitle; ?></textarea>
<small class="form-text text-muted">Title for Social <span class="pull-right titlemsgforsocial"></span></small>
</div>
<div class="form-group col-sm-12">
<label for="metadescsocial">Description For Social:</label>
<textarea class="form-control" rows="3" id="metadescsocial" name="metadescsocial"><?php echo $rent_social_metadesc; ?></textarea>
<small class="form-text text-muted">Briefly Describe About Social Share <span class="pull-right descmsgsocial"></span></small>
</div>
<div class="form-group col-sm-12">
<button type="submit" class="button btn-block btn-lg entrybtn floatbtn">Update Now <i class="fa fa-refresh fa-spin loading"></i></button>
</div>
</div>
</form>
</div>
</div>
</div>        
</div>
<?php  include '_footer.php'; ?>
<script type="text/javascript" src="assets/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
$(document).ready(function(){
surl = 'helper/search/search_location';
$('#spoint').on('input',function(){if(!$('#spoint').val()){$('#sid').val('');}});
$("#spoint").autocomplete({
  source: function(request,response){
    $.ajax({
      url:surl,
      dataType:"json",
      data:{term:request.term,"locid":$("#eid").val()},
      success:function(data){response(data);}
    });
  },
  minLength:0,
  limit:2,
  autoFocus:true,
  select: function(event,ui){
    $('#spoint').val(ui.item.value);
    $('#sid').val(ui.item.id);
    return false;
  } 
}).click(function(){$(this).autocomplete('search');});
$('#epoint').on('input',function(){if(!$('#epoint').val()){$('#eid').val('');}});
$("#epoint").autocomplete({
  source: function(request,response){
    $.ajax({
      url:surl,
      dataType:"json",
      data:{term:request.term,"locid":$("#sid").val()},
      success:function(data){response(data);}
    });
  },
  minLength:0,
  limit:2,
  autoFocus:true,
  select: function(event,ui){
    $('#epoint').val(ui.item.value);
    $('#eid').val(ui.item.id);
    return false;
  } 
}).click(function(){$(this).autocomplete('search');});
$(".editor").each(function(){CKEDITOR.replace($(this).attr("name"));});
$("#addfrm").on('submit',(function(e){
for(instance in CKEDITOR.instances){CKEDITOR.instances[instance].updateElement();}
e.preventDefault();
if($("#addfrm").valid()){
    var url="helper/master/content";
    var data = new FormData(this);
    data.append("operation","update");
    $.ajax({
      type: "POST",
      url: url,
      data: data,
      contentType: false,
      cache: false,
      processData:false, 
      dataType:"json",
      beforeSend: function(){$('.loading').show();},
      error: function(res){$('.loading').hide();showToast("Something Wrong Try Later","error");},
      success: function(res)
      {
        $('.loading').hide();
        if(res.status){
          showToast(res.msg,"success");
          $("#fbimg").val('');
          $("#twimg").val('');
        }else {showToast(res.msg,"error");}
      }
    }); 
}else{return false;}
})); 
$('.titlemsg').html((160 - $('#metatitle').val().length) + ' remaining');
$('#metatitle').keyup(function(){$('.titlemsg').html((60-$('#metatitle').val().length)+' remaining');});
$('.titlemsgforsocial').html((160 - $('#metatitlesocial').val().length) + ' remaining');
$('#metatitlesocial').keyup(function(){$('.titlemsgforsocial').html((60-$('#metatitlesocial').val().length)+' remaining');});
$('.descmsgsocial').html((160 - $('#metadescsocial').val().length) + ' remaining');
$('#metadescsocial').keyup(function(){$('.descmsgsocial').html((160-$('#metadescsocial').val().length)+' remaining');});
$('.descmsg').html((160 - $('#metadesc').val().length) + ' remaining');
$('#metadesc').keyup(function(){$('.descmsg').html((160-$('#metadesc').val().length)+' remaining');});
});
</script>
</body>
</html>