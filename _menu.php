<header class="header">
		<div class="topbar bg-theme">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-md-5">
						<div class="leftside">
							<ul class="custom-flex">
								<li> <a href="#" class="text-custom-white"><i class="fab fa-facebook-f"></i></a>
								</li>
								<li> <a href="#" class="text-custom-white"><i class="fab fa-twitter"></i></a>
								</li>
								<li> <a href="#" class="text-custom-white"><i class="fab fa-instagram"></i></a>
								</li>
								<li> <a href="#" class="text-custom-white"><i class="fab fa-linkedin"></i></a>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-lg-6 col-md-7">
						<div class="rightside full-height">
							<ul class="custom-flex full-height">
              <a href="tel:+910123456789"><li class="text-custom-white topphone"> <span class="fa fa-phone topcallicon"></span>&nbsp
              <strong>+91 0123456789 </strong>
                </li></a>&nbsp
								<li class="book-appointment"> <a href="cab"> Booking Now </a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="navigation-wrapper">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<nav>
							<div class="main-navigation">
								<div class="logo">
									<a href="./">
										<img src="assets/images/logo.png" class="img-fluid" alt="logo">
									</a>
								</div>
								<div class="main-menu">
									<ul class="custom-flex">
										<li class="menu-item active"> <a href="./">Home</a>
										</li>
                                        <li class="menu-item "> <a href="cab">Book A Cab</a>
										</li>
										<li class="menu-item "> <a href="about">About Us</a>
										</li>
										<li class="menu-item "> <a href="contact">Contact Us</a>
										</li>
									</ul>
								</div>
								<div class="hamburger-menu">
									<div class="menu-btn"> <span></span>  <span></span>  <span></span>
									</div>
								</div>
							</div>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</header>
	<script>
	const currentLocation = location.href;
	const menuItem = document.querySelectorAll('a');
	const menuLength = menuItem.length 
	for(Let i=0; i<menuLength; i++){
		if(menuItem[i].href === currentLocation)
		{
			menuItem[i].className = "active"
		}
	}
	</script>