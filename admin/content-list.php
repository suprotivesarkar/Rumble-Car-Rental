<?php include '_auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Rumble</title>
<?php  include '_header.php'; ?>
<style type="text/css">
.sbtn{border-radius:0;padding:8px 15px;}
</style>
</head>
<body>
<?php  include '_menu.php'; ?>
<div class="row">
<div class="col-md-12">
<div class="card card-statistics h-100">
<div class="card-title">
<div class="row">
<div class="col-sm-3">
<h5>Content List</h5>
</div>
<div class="col-sm-6">
<form class="form-inline" id="filterform">
<input type="text" class="form-control" id="spoint" placeholder="Start Point">
<input type="hidden" class="form-control" id="sid">
<input type="text" class="form-control" id="epoint" placeholder="End Point">
<input type="hidden" class="form-control" id="eid">
<button type="submit" class="btn btn-primary sbtn">Search</button>
</form>
</div>
<div class="col-sm-3">
<a href="content-add" class="button x-small pull-right"><i class="fa fa-plus"></i> Add New</a>
</div>
</div>
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
<label for="pname">Select Parent Location:</label>
<input type="text" class="form-control" id="pname" name="pname">
<input type="hidden" class="form-control" id="pid" name="pid">
</div>
<div class="form-group col-sm-12">
<label for="name">Enter Location Name:</label>
<input type="text" class="form-control" id="name" name="name" required="">
</div>
<div class="form-group col-sm-12">
<label for="nameurl">Location URL:</label>
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
<div class="modal-title"><h4>Update Location</h4></div>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
<form autocomplete="off" id="upfrm">
<input type="hidden" class="form-control" id="uptid" name="uptid" required="">
<div class="form-group col-sm-12">
<label for="uppname">Select Parent Location:</label>
<input type="text" class="form-control" id="uppname" name="uppname">
<input type="hidden" class="form-control" id="uppid" name="uppid">
</div>
<div class="form-group col-sm-12">
<label for="upname">Enter Location Name:</label>
<input type="text" class="form-control" id="upname" name="upname" required="">
</div>
<div class="form-group col-sm-12">
<label for="upnameurl">Location URL:</label>
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
<?php  include '_footer.php'; ?>
<script type="text/javascript">
src = 'helper/search/search_location';
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
fetchData();
var sid = $("#sid").val();
var eid = $("#eid").val();
$('#pname').on('input',function(){if(!$('#pname').val()){$('#pid').val('');}});
url = 'helper/search/search_location';
$("#pname").autocomplete({
  source: function(request,response){
      $.ajax({
          url:url,
          dataType:"json",
          data:{term:request.term},
          success:function(data){response(data);}
      });
  },
  minLength:0,
  limit:2,
  autoFocus:true,
  select: function(event,ui){
    $('#pname').val(ui.item.value);
    $('#pid').val(ui.item.id);
    return false;
  }
}).click(function(){$(this).autocomplete('search');});
$(".loadpan").delegate('.statusup',"click",function(){
  var id=$(this).data("id");
  var operation=$(this).data("operation");
  if (operation=="delete"){
      swal({title: "Are you sure?",text: "Once deleted, you will not be able to recover",icon: "warning",buttons: true,dangerMode: true,
      }).then((willDelete)=>{if(willDelete){StatusUpdate(id,operation);}});
  }else {StatusUpdate(id,operation);} 
});
function StatusUpdate(id,type){
  var url = "helper/master/content";
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
$("#filterform").on('submit',(function(e){
e.preventDefault();
sid = $("#sid").val();
eid = $("#eid").val();
fetchData();
}));
function fetchData(){$.post("helper/master/content",{"operation":"fetch","sid":sid,"eid":eid},function(data){$(".loadpan").html(data);$('#entry_table').DataTable({stateSave:true});});}
</script>
</body>
</html>