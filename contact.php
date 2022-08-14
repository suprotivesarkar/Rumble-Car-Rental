<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="keywords" content="#">
	<meta name="description" content="#">
	<title>Rumble - Car Rental Booking HTML Template | Contact Us</title>
	<?php include '_header.php'; ?>
</head>
<body>
<?php include '_menu.php'; ?>
	<div class="subheader normal-bg section-padding">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h1 class="text-custom-white">Contact Us</h1>
					<ul class="custom-flex justify-content-center">
						<li class="fw-500"> <a href="./" class="text-custom-white">Home</a>
						</li>
						<li class="active fw-500">Contact Us</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="section-padding contact-form-map">
		<div class="container">
			<div class="row">
				<div class="col-lg-7">
					<div class="section-header style-left">
						<div class="section-heading">
							<h3 class="text-custom-black">Get In Touch</h3>
							<div class="section-description">
                <div class="card contactcard">
                <i class="fa fa-map-marker-alt boxicon"></i>
                <div class="card-body ">
                <p class="text-light-dark">1st Floor, Dutta Building, Beside New Bombay Store, Hill Cart Road, P.C. - Siliguri, Dist : Darjeeling, Pin Code - 734001
                   </div>
                </div>
                <div class="card contactcard">
                <span><i class="fa fa-phone topcallicon boxicon"></i></span>
                <div class="card-body ">
                <p class="text-light-dark">
                +91-97334 12340 <br>+91-90022 00045</p>
                   </div>
                </div>
							</div>
						</div>
					</div>
					<form class="mb-md-80" id="contactus">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<input type="text" name="name" class="form-control form-control-custom" placeholder="Name" required="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<input type="email" name="emailid" class="form-control form-control-custom" placeholder="Email I'd" required="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<input type="text" name="subject" class="form-control form-control-custom" placeholder="Subject" required="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<input type="text" name="phone" class="form-control form-control-custom" placeholder="Phone No." required="">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<textarea name="message" rows="5" class="form-control form-control-custom" placeholder="Message" required=""></textarea>
                </div>
                
								<button type="submit" class="btn-first btn-submit">Submit</button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-lg-5">
					<div class="contact-map full-height">
          <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14256.235188726578!2d88.41676132269289!3d26.710568541237482!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xa9481cced1fc584f!2sAayush%20Holidays!5e0!3m2!1sen!2sin!4v1602661982592!5m2!1sen!2sin" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include '_footer.php'; ?>
<script>
$(document).ready(function(){
	$("#contactus").on('submit',(function(e){
    e.preventDefault();
    var url="_check_contact";
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