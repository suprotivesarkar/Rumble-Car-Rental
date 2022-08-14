<?php 
require_once("_top.php");
?> 
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="keywords" content="#">
	<meta name="description" content="#">
	<title>Rumble - Car Rental Booking HTML Template | Homepage</title>
	<?php include '_header.php'; ?>
</head>

<body>
<?php include '_menu.php'; ?>

	<div class="slider p-relative">

	<div class="banner-tabs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="tabs">
						<div class="tab-content">
							<div class="tab-pane active" id="cars">
								<div class="tab-inner">
									<h3 class="text-custom-white"><center>Book Now</center></h3>
								 <form id="outstationform">
									    <div class="row">
												<div class="form-group col-md-6">
													<label class="fs-14 text-custom-white fw-600">Pick Up</label>
													<input type="text" required="" name="formid" id="formid" class="form-control form-control-custom" placeholder="city, distirct or specific airpot">
													<input type="hidden" id="fid" name="fid">
												</div>
												
												<div class="form-group col-md-6">
													<label class="fs-14 text-custom-white fw-600">Drop Off</label>
													<input type="text" required="" name="toid" id="toid" class="form-control form-control-custom" placeholder="city, distirct or specific airpot">
													<input type="hidden" id="eid" name="eid">
												</div>
												
												<div class="group-form col-md-6">
													<label class="fs-14 text-custom-white fw-600">Date</label>
													<input type="text" name="date" required="" id="date" class="form-control form-control-custom datepickr" placeholder="mm/dd/yy" readonly>
                                <span class="input-group-append"> <i class="far fa-calendar"></i> </span>
												</div>
												
												<div class="form-group col-md-6">
													<label class="fs-14 text-custom-white fw-600">Total No. of Members</label>
													<input type="number" min="1" class="form-control form-control-custom" id="people" name="people" placeholder="Total Number of Member" required="">
												</div>
												<div class="form-group col-md-6">
													<label class="fs-14 text-custom-white fw-600">Name</label>
													<input type="text"  class="form-control form-control-custom" id="pname" name="pname" placeholder="Enter Your Name" required="">
												</div>	
												<div class="form-group col-md-6">
													<label class="fs-14 text-custom-white fw-600">Phone No.</label>
													<input type="text"  class="form-control form-control-custom" id="pnumber" name="pnumber" placeholder="Enter Your Phone No." required="">
												</div>	
											 <div class="col-12"> <input type="submit" class="btn-first btn-submit btn-block " name="Book Now"></div>
										<div class="outmsg col-12"></div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
		<div class="main-banner arrow-layout-1 ">
			<div class="slide-item">
				<img src="assets/images/car-1.jpg" class="image-fit" alt="Slider">
				<div class="transform-center">
					<div class="container">
						<div class="row">
							<div class="col-lg-7">
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="slide-item">
				<img src="assets/images/footer.jpg" class="image-fit" alt="Slider">
				<div class="transform-center">
					<div class="container">
						<div class="row">
							<div class="col-lg-7">
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="slide-item">
				<img src="assets/images/footer1.jpg" class="image-fit" alt="Slider">
				<div class="transform-center">
					<div class="container">
						<div class="row">
							<div class="col-lg-7">
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<section class="section-padding about-us">
		<div class="container">
			<div class="row">
				<div class="col-xl-7 col-lg-6 pl-2 pr-2 align-self-center text-left">
					<div class="about-left-side mb-md-80">
						<div class="section-header style-left">
							<div class="section-heading">
								<h3>Welcome To <span class="text-custom-blue">Rumble</span></h3>
								<div class="section-description">
									
								</div>
							</div>
						</div>
						<p class="pt-2">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text.</p>
						<p class="pt-2">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text.</p>
						<p class="pt-2">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text. Lorem Ipsum has been the industry's standard dummy text. Lorem Ipsum is simply dummy.</p> <a href="cab" class="btn-first btn-submit">Reserve Now</a>
					</div>
				</div>
				<div class="col-xl-5 col-lg-6">
					<div class="about-right-side full-height">
						<div class="about-img full-height">
							<img src="assets/images/aboutus1.png" class="img-fluid image-fit" alt="img">
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="section-padding our-work-sec bg-light-white">
		<div class="container">
			<div class="section-header text-center">
				<div class="section-heading">
					<h3 class="text-custom-black">Our <span class="text-custom-blue">Cars</span></h3>
					<div class="section-description">
						<p class="text-light-dark">Get lowest Cabs fares in siliguri from us for cabs & taxi service</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="row">
						<div class="col-sm-6">
							<div class="work-sec animate-img">
								<a href="#">
									<img src="assets/images/hatchback.jpg" class="image-fit" alt="img">
									<div class="text-wrapper">
										<h4 class="text-custom-white no-margin fw-600">Hatchback</h4>
										<p class="text-custom-white no-margin">SUMO/ BOLERO/ MAXX</p>
									</div>
								</a>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="work-sec animate-img">
								<a href="#">
									<img src="assets/images/sedan.jpg" class="image-fit" alt="img">
									<div class="text-wrapper">
										<h4 class="text-custom-white no-margin fw-600">Sedan</h4>
										<p class="text-custom-white no-margin">WAGNOR/ INDICA/ ALTO</p>
									</div>
								</a>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="work-sec animate-img">
								<a href="#">
									<img src="assets/images/standard.jpg" class="image-fit" alt="img">
									<div class="text-wrapper">
										<h4 class="text-custom-white no-margin fw-600">Standard</h4>
										<p class="text-custom-white no-margin">SWIFT/ DEZIRE/ INDIGO
                      
                    </p>
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="work-sec animate-img first-box">
						<a href="#">
							<img src="assets/images/luxury.jpg" class="image-fit" alt="img">
							<div class="text-wrapper">
								<h4 class="text-custom-white no-margin fw-600">Luxury</h4>
								<p class="text-custom-white no-margin">INNOVA/ XYLO</p>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="section-padding gallery">
		<div class="container sticky-relative">
			<div class="section-header text-center">
				<div class="section-heading">
					<h3 class="text-custom-black">Our <span class="text-custom-blue">Siteseeings</span></h3>
					<div class="section-description">
						<p class="text-light-dark">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text.</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="tabs filter-gallery tabpan sticky">
						<ul class="custom-flex nav nav-tabs mb-xl-40 ">
							<li class="nav-item"> <a class="nav-link active" href="#" data-filter="*">Show All</a>
							</li>
							<li class="nav-item"> <a class="nav-link" href="#" data-filter=".tab-gallery">Darjeeling</a>
							</li>
							<li class="nav-item"> <a class="nav-link" href="#" data-filter=".tab-gallery-1">Sikkim</a>
							</li>
							<li class="nav-item"> <a class="nav-link" href="#" data-filter=".tab-gallery-2">Doors</a>
							</li>
							<li class="nav-item"> <a class="nav-link" href="#" data-filter=".car-gallery">Kalimpong</a>
							</li>
						</ul>
					</div>
					<div class="row gallery-grid galpan">
						<div class="col-lg-4 col-md-6 filter-box tab-gallery">
							<div class="gallery-item mb-xl-30">
								<a href="assets/images/gallery/tigerhills.jpg" class="popup">
									<img src="assets/images/gallery/tigerhills.jpg" class="image-fit" alt="img">
								</a>
							</div>
						</div>
						<div class="col-lg-4 col-md-6 filter-box tab-gallery-1">
							<div class="gallery-item mb-xl-30">
								<a href="assets/images/gallery/gantok.jpg" class="popup">
									<img src="assets/images/gallery/gantok.jpg" class="image-fit" alt="img">
								</a>
							</div>
						</div>
						<div class="col-lg-4 col-md-6 filter-box tab-gallery-2">
							<div class="gallery-item mb-xl-30">
								<a href="assets/images/gallery/gorumara.jpg" class="popup">
									<img src="assets/images/gallery/gorumara.jpg" class="image-fit" alt="img">
								</a>
							</div>
						</div>
						<div class="col-lg-4 col-md-6 filter-box car-gallery">
							<div class="gallery-item mb-xl-30">
								<a href="assets/images/gallery/kalimpong.jpg" class="popup">
									<img src="assets/images/gallery/kalimpong.jpg" class="image-fit" alt="img">
								</a>
							</div>
						</div>
						<div class="col-lg-4 col-md-6 filter-box tab-gallery">
							<div class="gallery-item mb-xl-30">
								<a href="assets/images/gallery/sandakpu.jpg" class="popup">
									<img src="assets/images/gallery/sandakpu.jpg" class="image-fit" alt="img">
								</a>
							</div>
						</div>
						<div class="col-lg-4 col-md-6 filter-box tab-gallery-1">
							<div class="gallery-item mb-xl-30">
								<a href="assets/images/gallery/nathulapas.jpg" class="popup">
									<img src="assets/images/gallery/nathulapas.jpg" class="image-fit" alt="img">
								</a>
							</div>
						</div>
						<div class="col-lg-4 col-md-6 filter-box tab-gallery-2">
							<div class="gallery-item mb-xl-30">
								<a href="assets/images/gallery/samsing.jpg" class="popup">
									<img src="assets/images/gallery/samsing.jpg" class="image-fit" alt="img">
								</a>
							</div>
						</div>
						<div class="col-lg-4 col-md-6 filter-box car-gallery">
							<div class="gallery-item mb-xl-30">
								<a href="assets/images/gallery/kalimpong1.jpg" class="popup">
									<img src="assets/images/gallery/kalimpong1.jpg" class="image-fit" alt="img">
								</a>
							</div>
						</div>
						<div class="col-lg-4 col-md-6 filter-box tab-gallery">
							<div class="gallery-item mb-xl-30">
								<a href="assets/images/gallery/kanchanjunga.jpg" class="popup">
									<img src="assets/images/gallery/kanchanjunga.jpg" class="image-fit" alt="img">
								</a>
							</div>
						</div>
						<div class="col-lg-4 col-md-6 filter-box tab-gallery-1">
							<div class="gallery-item mb-xl-30">
								<a href="assets/images/gallery/tsomgolake.jpg" class="popup">
									<img src="assets/images/gallery/tsomgolake.jpg" class="image-fit" alt="img">
								</a>
							</div>
						</div>
						<div class="col-lg-4 col-md-6 filter-box tab-gallery-2">
							<div class="gallery-item mb-xl-30">
								<a href="assets/images/gallery/murti.jpg" class="popup">
									<img src="assets/images/gallery/murti.jpg" class="image-fit" alt="img">
								</a>
							</div>
						</div>
						<div class="col-lg-4 col-md-6 filter-box car-gallery">
							<div class="gallery-item mb-xl-30">
								<a href="assets/images/gallery/kalimpong2.jpg" class="popup">
									<img src="assets/images/gallery/kalimpong2.jpg" class="image-fit" alt="img">
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="section-padding parallax our-team ">
<div class="overlay overlay-bg-black"></div>
<div class="container">
<div class="section-header text-center">
<div class="section-heading">
<h3 class="text-custom-white">Our <span class="text-custom-blue">Testimonial</span></h3>
<div class="section-description">
<p class="text-custom-white">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text.</p>
</div>
</div>
</div>

<div class="row">
<div class="col-md-8 offset-md-2 tesslider arrow-layout-2 ">
    <?php 
$stmt ="SELECT *
            FROM testimonials
            WHERE testi_status=1 ORDER BY RAND() LIMIT 6 ";
$res = $PDO->prepare($stmt);
$res->execute();    
$teslist = $res->fetchAll();
foreach ($teslist  as $pkges){extract($pkges); 
if(!empty($testi_img) AND file_exists('assets/images/testimonials/'.$testi_img)){
  $img =  $testi_img;       
}else{
  $img = "user.png";
}
?>
<div class="eachtestimonial text-center">
<img src="assets/images/testimonials/<?php echo $img; ?>" class="img-circle testiimage"/>
<div class="content-pan">
<img src="assets/images/blog/left-quote.png" class="img-quote"/>
<p class="ttext"><?php echo $testi_text; ?>
</p>
<p class="tname"><?php echo $testi_name; ?></p>
</div>
</div>
<?php } ?>
</div>
</div>
</div>
</section>

	<section class="section-padding car-booking">
		<div class="container">
			<div class="section-header text-center">
				<div class="section-heading">
					<h3 class="text-custom-black">Recommended <span class="text-custom-blue">Cars</span></h3>
					<div class="section-description">
						<p class="text-light-dark">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text.</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="car-slider arrow-layout-2 row">
						<div class="slide-item col-12">
							<div class="car-grid">
								<div class="car-grid-wrapper car-grid bx-wrapper">
									<div class="image-sec animate-img">
										<a href="cab#hatchback">
											<img src="assets/images/cars/1.png" class="full-width" alt="img">
										</a>
									</div>
									<div class="car-grid-caption padding-20 bg-custom-white p-relative">
										<h4 class="title fs-16"><a href="cab#hatchback" class="text-custom-black">HATCHBACK</a></h4>  
										<p>Grate explorer of tha truth tha master-bulder of human happines.</p>
										<div class="action"> <a class="btn-second btn-small" href="cab#hatchback">Book Now</a>  
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="slide-item col-12">
							<div class="car-grid">
								<div class="car-grid-wrapper car-grid bx-wrapper">
									<div class="image-sec animate-img">
										<a href="cab#sedan">
											<img src="assets/images/cars/2.png" class="full-width" alt="img">
										</a>
									</div>
									<div class="car-grid-caption padding-20 bg-custom-white p-relative">
										<h4 class="title fs-16"><a href="cab#sedan" class="text-custom-black">SEDAN</a></h4>  
										<p>Grate explorer of tha truth tha master-bulder of human happines.</p>
										<div class="action"> <a class="btn-second btn-small" href="cab#sedan">Book Now</a>  
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="slide-item col-12">
							<div class="car-grid">
								<div class="car-grid-wrapper car-grid bx-wrapper">
									<div class="image-sec animate-img">
										<a href="cab#luxury">
											<img src="assets/images/cars/3.png" class="full-width" alt="img">
										</a>
									</div>
									<div class="car-grid-caption padding-20 bg-custom-white p-relative">
										<h4 class="title fs-16"><a href="cab#luxury" class="text-custom-black">LUXURY</a></h4>  
										<p>Grate explorer of tha truth tha master-bulder of human happines.</p>
										<div class="action"> <a class="btn-second btn-small" href="cab#luxury">Book Now</a>  
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="slide-item col-12">
							<div class="car-grid">
								<div class="car-grid-wrapper car-grid bx-wrapper">
									<div class="image-sec animate-img">
										<a href="cab#sedan">
											<img src="assets/images/cars/4.png" class="full-width" alt="img">
										</a>
									</div>
									<div class="car-grid-caption padding-20 bg-custom-white p-relative">
										<h4 class="title fs-16"><a href="cab#sedan" class="text-custom-black">SEDAN</a></h4>  
										<p>Grate explorer of tha truth tha master-bulder of human happines.</p>
										<div class="action"> <a class="btn-second btn-small" href="cab#sedan">Book Now</a>  
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="slide-item col-12">
							<div class="car-grid">
								<div class="car-grid-wrapper car-grid bx-wrapper">
									<div class="image-sec animate-img">
										<a href="cab#standard">
											<img src="assets/images/cars/5.png" class="full-width" alt="img">
										</a>
									</div>
									<div class="car-grid-caption padding-20 bg-custom-white p-relative">
										<h4 class="title fs-16"><a href="cab#standard" class="text-custom-black">STANDARD</a></h4>  
										<p>Grate explorer of tha truth tha master-bulder of human happines.</p>
										<div class="action"> <a class="btn-second btn-small" href="cab#standard">Book Now</a>  
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php include '_footer.php'; ?>
	<script>
$(document).ready(function(){
  $("#outstationform").on('submit',(function(e){
    e.preventDefault();
    var url="_form_check";
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
    });
  }));
  $('#formid').on('input',function(){if(!$('#formid').val()){$('#fid').val('');}});
  $('#toid').on('input',function(){if(!$('#toid').val()){$('#eid').val('');}});
  $('#formid').typeahead({
      ajax:{
          url:'_mastersearch',
          method:'get',
          triggerLength:0,
          displayField:'nm',
          valueField:'id',
          loadingClass:"loading",
          preDispatch:function(query){
              return {
                  query:query,
                  type:"start",
                  lid:$("#eid").val()
              }
          }
      },
      onSelect: function(item){
        $("#fid").val(item.value);
    } 
    });
    $('#toid').typeahead({
      ajax:{
          url:'_mastersearch',
          method:'get',
          triggerLength:1,
          displayField:'nm',
          valueField:'id',
          loadingClass:"loading",
          preDispatch:function(query){
              return {
                  query:query,
                  type:"end",
                  lid:$("#fid").val()
              }
          }
      },
      onSelect: function(item){
        $("#eid").val(item.value);
    } 
    });
});
</script>	
</body>
</html>