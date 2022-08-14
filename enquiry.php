<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="keywords" content="#">
	<meta name="description" content="#">
	<title>Rumble - Car Rental Booking HTML Template | Cab Enquiry</title>
	<?php include '_header.php'; ?>
	<link href="assets/css/bootstrap-clockpicker.min.css" rel="stylesheet"> 
	<style>
		.sightseeingpan{
			display:none;
		}
	</style>
</head>
<body>
<?php include '_menu.php'; ?>
	<div class="subheader normal-bg section-padding">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h1 class="text-custom-white">Cab Enquiry</h1>
					<ul class="custom-flex justify-content-center">
						<li class="fw-500"> <a href="./" class="text-custom-white">Home</a>
						</li>
						<li class="active fw-500">Cab Enquiry</li>
					</ul>
				</div>
			</div>
		</div>
    </div>
    <section class="section-padding">
        <div class="container">
            <div class="row">
            <div class="col-sm-12">
<div class="card card-default mypanel">
<div class="card-body">
<form id="bookingfrm" class="bookingfrm" method="POST">
<div class="row">
<div class="form-group col-sm-4">
<label for="fromloc">Start Location<span class="req"> *</span></label>
<input type="text" class="form-control form-control-custom" id="fromloc" name="fromloc" placeholder="From" required=""> 
</div> 
<div class="form-group col-sm-4">
<label for="toloc">Drop Location<span class="req"> *</span></label>
<input type="text" class="form-control form-control-custom" id="toloc" name="toloc" placeholder="To" required="">
</div>
<div class="group-form col-sm-4">
<label for="date">Journey Date<span class="req"> *</span></label>
<input type="text" class="form-control form-control-custom datepickr" id="date" name="date" placeholder="Select Date" readonly="" required="">
<span class="input-group-append calicon"><i class="far fa-calendar"></i></span>
</div> 
<div class="form-group col-sm-4">
<label for="people">Total People<span class="req"> *</span></label>
<input type="number" min="1" class="form-control form-control-custom" id="people" name="people" placeholder="Total Number of Member" required=""> 
</div>
<div class="form-group col-sm-4">
<label for="vehical">Vehicle Type<span class="req"> *</span></label>
<select class="form-control form-control-custom" id="vehical" name="vehical" required="">
<option value="">--Select Type--</option>
<option value="1">Hatchback - Wagnor/ Indica/ Alto (4+1)</option>
<option value="2">Sedan - Swift/ Dzire/ Indigo (4+1)</option>
<option value="3">Standard - Sumo/ Bolero/ Maxx (8+1)</option>
<option value="4">Luxury - Innova/ Xylo (6+1)</option>
</select> 
</div> 
<div class="form-group col-sm-4">
<label for="service">Service Needed<span class="req"> *</span></label>
<select class="form-control form-control-custom" id="service" name="service" required="">
<option value="">--Select Type--</option>
<option value="1">One Way Transfer</option>
<option value="2">Return Only</option>
<option value="3">Tour Package</option>
</select> 
</div>
</div>
<div class="checkbox">
<label><input type="checkbox" value="1" name="wantsightseeing"> Want to Add Sightseeing</label>
</div>
<div class="sightseeingpan">
<div class="row">
<div class="form-group col-sm-4">
<label>Select Date</label>
<input type="text" readonly="" class="form-control form-control-custom datepickr" name="sightseeing[0][jdate]" placeholder="Select Date">
</div>
<div class="form-group col-sm-8">
<label>Where you want to Visit</label>
<input type="text" class="form-control form-control-custom" name="sightseeing[0][visitloc]" placeholder="Visit Location"> 
</div>
</div>
<div class="append"></div>
<button type="button" class="btn btn-info admorebtn"><i class="fa fa-plus"></i> Add More</button>
</div>
<div class="clearfix"></div>
<div class="formsec">
<hr class="formhr">
<p class="formsechd"><span>Contact Details</span></p>	
</div>
<div class="row">
<div class="form-group col-sm-4">
<label>Your Name<span class="req"> *</span></label>
<input type="text" class="form-control form-control-custom" name="name" placeholder="Your Name" required=""> 
</div>
<div class="form-group col-sm-4">
<label>Your Phone<span class="req"> *</span></label>
<input type="text" class="form-control form-control-custom" name="phone" placeholder="Your Phone" required=""> 
</div>
<div class="form-group col-sm-4">
<label>Your Email<span class="req"> *</span></label>
<input type="text" class="form-control form-control-custom" name="emailid" placeholder="Your Email ID" required=""> 
</div>
<div class="form-group col-sm-4">
<label>Your Address<span class="req"> *</span></label>
<input type="text" class="form-control form-control-custom" name="address" placeholder="Your Address" required=""> 
</div>
<div class="form-group col-sm-4">
<label>Alternative Phone</label>
<input type="text" class="form-control form-control-custom" name="altphone" placeholder="Any alternative phone number"> 
</div>
<div class="form-group col-sm-4">
<label>Pickup Point</label>
<input type="text" class="form-control form-control-custom" name="pickpoint" placeholder="Pickup Point" required=""> 
</div>
<div class="form-group col-sm-4">
<label>Pickup Time</label>
<input type="text" class="form-control form-control-custom clockpicker" required="" readonly="" name="picktime" placeholder="Time"> 
</div>
<div class="form-group col-sm-8">
<label>Any Message</label>
<input type="text" class="form-control form-control-custom" name="message" placeholder="If you have any Message" > 
</div>
</div>
<div class="form-group">
<button type="submit" class="btn-first btn-submit btn-block">SEND NOW</button>
</div>
<div class="frmmsg"></div>
</form>
</div>
</div>
</div>
            </div>
        </div>
    </section>
	<?php include '_footer.php'; ?>
	<script src="assets/js/bootstrap-clockpicker.min.js"></script>
	<script>
$(document).ready(function(){
    $('.clockpicker').clockpicker({autoclose: true,'default': 'now'});
    $('input[type="checkbox"]').click(function(){
        if($(this).prop("checked") == true){$('.sightseeingpan').fadeIn(300);}
        else if($(this).prop("checked") == false){$('.sightseeingpan').fadeOut(300);}
    });
    var date = new Date();
    date.setDate(date.getDate() + 2);
   // $('[data-toggle="datepickr"]').datepicker({format:'dd-mm-yyyy',autoHide:true,startDate:date});
    var j=1;
    $(".admorebtn").click(function(event){
        $(".append").append('<div class="row"><div class="form-group col-sm-4"> <label>Select Date</label> <input type="text" readonly="" class="form-control form-control-custom datepickr" name="sightseeing['+j+'][jdate]" placeholder="Select Date"></div><div class="form-group col-sm-7"> <label>Where you want to Visit</label> <input type="text" class="form-control form-control-custom" name="sightseeing['+j+'][visitloc]" placeholder="Visit Location"></div><div class="form-group col-sm-1"><br /><span class="btn btn-danger removebtn"><i class="fa fa-trash"></i></span></div></div>');
        event.preventDefault();
		j++;
		$('.datepickr').datepicker({
	      timepicker: false,
		  minDate: new Date(),
		  autoClose: true,
	    });
   
    });
    $(document).on('click','.removebtn',function(){
        $(this).parent().parent().fadeOut(300);
	});

	$("#bookingfrm").on('submit',(function(e){
    e.preventDefault();
    var url="_bookcheck";
    var data = new FormData(this);
    $.ajax({
      type: "POST",
      url: url,
      data: data,
      contentType: false,
      cache: false,
      processData:false, 
      dataType:"json",
      beforeSend: function(){$('.actionbtn').addClass('is-loading');},
      error: function(res){$('.actionbtn').removeClass('is-loading');},
      success: function(res){
        $('.actionbtn').removeClass('is-loading');
        if(res.status){location.href = res.msg;}else{$(".outmsg").html(res.msg);}
      }
	})
  }));
});
</script>
</body>
</html>