<?php include '_auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Rumble|Add Location</title>
<?php  include '_header.php'; ?>
<link rel="stylesheet" type="text/css" href="assets/css/croppie.css">
</head>
<body>
<?php  include '_menu.php'; ?>
<div class="row">
<div class="col-md-12">
<div class="card card-statistics h-100">
<div class="card-title">
<h5>Add New Location <a href="location-add" class="button x-small pull-right"><i class="fa fa-plus"></i> Add New</a></h5>
</div>
<div class="card-body">
<div class="loadpan"></div>
</div>
</div>
</div>				
</div>
<div class="modal fade" id="addMod" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<div class="modal-title"><h4>Add New Location</h4></div>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
<form action="" autocomplete="off" id="addfrm">
<div class="row">
<div class="form-group col-sm-12">
<label for="name">Enter Category Name:</label>
<input type="text" class="form-control" id="name" name="name" required="" autofocus="">
</div>
<div class="form-group col-sm-12">
<label for="nameurl">Category URL:</label>
<input type="text" class="form-control" id="nameurl" name="nameurl" required="">
</div>
<div class="form-group col-sm-12">
<button type="submit" class="button btn-block btn-lg entrybtn">Add Now <i class="fa fa-refresh fa-spin loading"></i></button>
</div>
</div>
</form>
</div>
</div>
</div>
</div> 
<div class="modal fade" id="upMod" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<div class="modal-title"><h4>Update Category</h4></div>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
<form autocomplete="off" id="upfrm">
<input type="hidden" class="form-control" id="uptid" name="uptid" required="">
<div class="form-group">
<label for="upname">Enter Category Name:</label>
<input type="text" class="form-control" id="upname" name="upname" required="" autofocus="">
</div>
<div class="form-group">
<label for="upnameurl">Category URL:</label>
<input type="text" class="form-control" id="upnameurl" name="upnameurl" required="">
</div>
<div class="form-group">
<button type="submit" class="button btn-block btn-lg entrybtn">Update Now <i class="fa fa-refresh fa-spin loading"></i></button>
</div>
</form>
</div>
</div>
</div>
</div>


<div class="modal fade" id="upGal">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<div class="modal-title"><h4>Update Image</h4></div>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
<input type="hidden" name="" id="updateimgid">
<div id="upload-demo-update"></div>
<input type="file" accept="image/*" id="upload-update" value="Choose a file">
<div class="form-group">
<button type="button" class="button btn-block btn-lg entrybtn imgupdate">Update Now <i class="fa fa-refresh fa-spin loading"></i></button>
</div>
</div>
</div>
</div>
</div>
<?php  include '_footer.php'; ?>
<script type="text/javascript" src="assets/js/croppie.js"></script>
<script type="text/javascript">
fetchData();
      //var proid = $("#proid").val();
/*      var $uploadCrop;
      $uploadCrop=$('#upload-demo').croppie({
              enableExif: true,
              enableOrientation: true,    
              viewport: {
                  width: 600,
                  height:322,
                  circle:false
              },
              boundary: {
                  width: 650,
                  height: 350
              }
      });
      var fileTypes = ['jpg', 'jpeg', 'png'];
      $('#upload').on('change', function () { 
              var reader  = new FileReader();
              var file    = this.files[0]; 
              var fileExt = file.type.split('/')[1]; 
              if (fileTypes.indexOf(fileExt) !== -1) {

                  reader.onload = function (e) {
                    result = e.target.result;
                    arrTarget = result.split(';');
                    tipo = arrTarget[0];
                    if (tipo == 'data:image/jpeg' || tipo == 'data:image/png') {
                        $uploadCrop.croppie('bind', {
                            url: e.target.result
                        });
                        $('.upload-demo').addClass('ready');
                    } else {
                        alert('Accept only .jpg o .png image types');
                    }
                  }           
                  reader.readAsDataURL(file);
              }else {
                this.value='';
                alert('File not supported - Allowed JPG, PNG, JPEG');
              }
      });
      $('.imgad').on('click', function (ev) {
              $uploadCrop.croppie('result',{
                  type: 'canvas',
                  format:'jpeg|png',
                  size: 'viewport'
              }).then(function (resp) {
                    var url="helper/master/category";
                    $.ajax({
                      type: "POST",
                      url: url,
                      data:{"operation":"adgallery","imagebase64":resp,"proid":proid},
                      dataType:"json",
                      beforeSend: function(){$('.loading').show();},
                      error: function(res){$('.loading').hide();showToast("Something Wrong Try Later","error");},
                      success: function(res){ 
                        $('.loading').hide();
                        if(res.status){
                          fetchGallery();
                          showToast(res.msg,"success");
                        }else {showToast(res.msg,"error");}
                      }
                    }); 
              });
      });
*/
    var $uploadCropUpdate;
    $uploadCropUpdate=$('#upload-demo-update').croppie({
              enableExif: true,
              enableOrientation: true,    
              viewport: {
                  width: 600,
                  height:322,
                  circle:false
              },
              boundary: {
                  width: 650,
                  height: 350
              }
    });
    var fileTypes = ['jpg', 'jpeg', 'png'];
    $('#upload-update').on('change', function () { 
              var reader  = new FileReader();
              var file    = this.files[0]; 
              var fileExt = file.type.split('/')[1]; 
              if (fileTypes.indexOf(fileExt) !== -1) {

                  reader.onload = function (e) {
                    result = e.target.result;
                    arrTarget = result.split(';');
                    tipo = arrTarget[0];
                    if (tipo == 'data:image/jpeg' || tipo == 'data:image/png') {
                        $uploadCropUpdate.croppie('bind', {
                            url: e.target.result
                        });
                        $('.upload-demo-update').addClass('ready');
                    } else {
                        alert('Accept only .jpg o .png image types');
                    }
                  }           
                  reader.readAsDataURL(file);
              }else {
                this.value='';
                alert('File not supported - Allowed JPG, PNG, JPEG');
              }
      });
    $('.imgupdate').on('click', function (ev) {
              $uploadCropUpdate.croppie('result',{
                  type: 'canvas',
                  format:'jpeg|png',
                  size: 'viewport'
              }).then(function (resp) {
                    var url="helper/master/category";
                    var galid = $("#updateimgid").val();
                    $.ajax({
                      type: "POST",
                      url: url,
                      data:{"operation":"upgallery","imagebase64":resp,"galid":galid},
                      dataType:"json",
                      beforeSend: function(){$('.loading').show();},
                      error: function(res){$('.loading').hide();showToast("Something Wrong Try Later","error");},
                      success: function(res){ 
                        $('.loading').hide();
                        if(res.status){
                          showToast(res.msg,"success");
                        }else {showToast(res.msg,"error");}
                      }
                    }); 
              });
      });

$("#upGal").on('shown.bs.modal',function(e){
var button=$(e.relatedTarget);
$("#updateimgid").val(button.data("id"));
});

$.validator.messages.required = '';
$('#addfrm').validate({});
$("#addfrm").on('submit',(function(e){
e.preventDefault();
if($("#addfrm").valid()){
    var url="helper/master/category";
    var data = new FormData(this);
    data.append("operation","addnew");
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
          fetchData();
          $("#addfrm").trigger('reset');
          showToast(res.msg,"success");
        }else {showToast(res.msg,"error");}
      }
    }); 
}else{return false;}
})); 
$("#upMod").on('shown.bs.modal',function(e){
var button=$(e.relatedTarget);
$("#uptid").val(button.data("id"));
$("#upname").val(button.data("name"));
$("#upnameurl").val(button.data("url"));
});
$('#upfrm').validate({});
$("#upfrm").on('submit',(function(e){
e.preventDefault();
if($("#upfrm").valid()){
    var url="helper/master/category";
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
        if(res.status){fetchData();showToast(res.msg,"success");}
        else{showToast(res.msg,"error");}
      }
    }); 
}else{return false;}
}));
$(".loadpan").delegate('.statusup',"click",function(){
  var id=$(this).data("id");
  var operation=$(this).data("operation");
  if (operation=="delete"){
      swal({title: "Are you sure?",text: "Once deleted, you will not be able to recover",icon: "warning",buttons: true,dangerMode: true,
      }).then((willDelete)=>{if(willDelete){StatusUpdate(id,operation);}});
  }else {StatusUpdate(id,operation);} 
});
function StatusUpdate(id,type){
  var url = "helper/master/category";
  $.ajax({
    type:"POST",
    url:url,
    dataType:"json",
    data:{"id":id,"operation":type},
    beforeSend:function(){},
    error:function(res){$('.loading').hide();showToast("Something Wrong Try Later","error");},
    success:function(res)
    { 
      if(res.status){fetchData();showToast(res.msg,"success");}
      else{showToast(res.msg,"error");}
    }
  });
}
$("#name").keyup(function(){$("#nameurl").val(convertToSlug($(this).val()));});
$("#upname").keyup(function(){$(this).val();$("#upnameurl").val(convertToSlug($(this).val()));});
/*function fetchData(){$.post("helper/master/category",{"operation":"fetch"},function(data){$(".loadpan").html(data);});}*/

function fetchData(){
$(".loadpan").load("helper/master/category?operation=fetch",function(){
$(".loadpan table tbody").sortable({
    axis: 'y',
    update:function(event,ui){
        var data =$(".loadpan table tbody").sortable('toArray');
        $.ajax({
            data:{data:data,"operation":"sort"},
            type: 'POST',
            dataType: 'json',
            url: 'helper/master/category',
            success:function(res){
              fetchData();
              if(res.status){showToast(res.msg,"success");}
              else{showToast(res.msg,"error");}
            }
        });
    }
}); 
});
}
</script>
</body>
</html>