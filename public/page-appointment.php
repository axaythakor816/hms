<?php
require_once('includes/header.php');
?>
	<!-- Home Design Inner Pages -->
	<div class="ulockd-inner-home">
		<div class="container text-center">
			<div class="row">
				<div class="inner-conraimer-details">
					<div class="col-md-12">
						<h1 class="text-uppercase">APPOINTMENT</h1>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Home Design Inner Pages -->
	<div class="ulockd-inner-page">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="ulockd-icd-layer">
						<ul class="list-inline ulockd-icd-sub-menu">
							<li><a href="#"> HOME </a></li>
							<li><a href="#"> > </a></li>
							<li> <a href="#"> APPOINTMENT </a> </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Our About -->
	<section class="ulockd-about-one inner">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-md-7">
					<!-- Appointment Form Starts -->
                    <form id="appointment_form" name="appointment_form" class="appointment_form text-center" action="#" method="POST" novalidate="novalidate">
                        <div class="messages"></div>
                        <div class="row">
                            <div class="col-md-12">
					        	<h2>Appointment with Expert</h2>
					        	<p>Let's Appointment With our Exparts Who Try to Solved Your Problem.</p>
                                <div class="form-group text-left">
                                    <label for="form_name"><i class="fa fa-user-o"></i> Name <small>*</small></label>
                                    <input id="form_name" name="name" class="form-control" placeholder="enter a name" required="required" data-error="Name is required." type="text">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
							<div class="col-md-12 text-left">
								
									
										<label for="form_job"><i class="fa fa-user-md" aria-hidden="true"></i> Select Gender <small>*</small></label>
										<select id="" class="form-control form_control required" name="gender" required="required" data-error="Option is required.">
											<option value="">Select Gender </option>
											<option value="male">Male</option>
				                                <option value="female">Female</option>
				                                <option value="other">Other</option>
											
										</select>
							</div>
							<div class="col-md-12">
                                <div class="form-group text-left">
                                    <label for="form_phone"><i class="fa fa-phone"></i> Phone <small>*</small></label>
                                    <input id="form_phone" name="number" class="form-control required" placeholder="enter a phone" required="required" data-error="Phone Number is required." type="text">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>  
							
                            <div class="col-md-12">
                                <div class="form-group text-left">
                                    <label for="form_email"><i class="fa fa-envelope-open-o"></i> Email <small>*</small></label>
                                    <input id="form_email" name="email" class="form-control required email" placeholder="enter an email" required="required" data-error="Email is required." type="email">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

							<div class="col-md-12">
											<div class="form-group text-left">
												<label>Address  <span class="login-danger">*</span></label>
												<textarea class="form-control" rows="3" name="address" cols="30"></textarea>
											</div>
										</div>
							<div class="col-md-12 text-left">
								
									
										<label for="form_job"><i class="fa fa-user-md" aria-hidden="true"></i> Select Doctor <small>*</small></label>
										<select id="doctor" class="form-control form_control required" name="doctor" required="required" data-error="Option is required.">
											<option value="">Select Doctor </option>
											<option value="Orthopedist - Henry Jones">Orthopedist - Henry Jones</option>
											<option value="skin Specialist - Madeleine - Smith">skin Specialist - Madeleine - Smith</option>
											<option value="Psychology - Savannah Smith">Psychology - Savannah Smith</option>
											<option value="Neurologist - smith Johnsonh">Neurologist - smith Johnsonh</option>
											<option value="Dentist - Bella Smith">Dentist - Bella Smith</option>
											<option value="Cardiologist - John Smith">Cardiologist - John Smith</option>
											<option value="Gynecologist - Ana Smith">Gynecologist - Ana Smith</option>
											<option value="Neurologist - James Williams">Neurologist - James Williams</option>
										</select>
									
									<div class="help-block with-errors"></div>
							</div>
                            <div class="col-md-12">
                                <div class="form-group text-left">
                                    <label for="form_date"><i class="fa fa-calendar-check-o"></i> Date <small>*</small></label>
                                    <input id="form_date" name="date" class="form-control required datepicker" placeholder="enter a date" required="required" data-error="Subject is required." type="text">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div> 
                            
                        </div>
                        <div class="form-group text-left">
                            <label for="form_name"><i class="fa fa-file-text-o"></i> notes</label>
                            <textarea id="form_message" name="note" class="form-control required" rows="5" placeholder="type in a message" required="required" data-error="Message is required."></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group text-center">
                            <input id="form_botcheck" name="form_botcheck" class="form-control" value="" type="hidden">
                            <button type="submit" name="send" class="btn btn-lg ulockd-btn-thm2" data-loading-text="Getting Few Sec...">Send</button>
                        </div>
                    </form>
				</div>
				<div class="col-sm-12 col-md-4">
					<div class="ulockd-about-thumb">
						<img class="img-responsive img-whp" src="assets/images/about/1.png" alt="1.png">
						<h2 class="ulockd-about-thumb-ttl">Vice Precident <span class="text-thm">Karn  </span></h2>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Our About Page faq Section -->



	<!-- Our Team -->
	<section class="ulockd-team">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 text-center">
					<div class="ulockd-main-title">
						<h2 class="text-uppercase">OUR <span class="text-thm">Team</span></h2>
							</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
					<div class="ulockd-team-member">
						<div class="team-thumb">
							<img class="img-responsive img-whp" src="assets/images/team/1.jpg" alt="team1.jpg">
							<div class="team-overlay">
								<ul class="list-inline team-icon style2">
		  							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
		  							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
		  							<li><a href="#"><i class="fa fa-pinterest"></i></a></li>
		  							<li><a href="#"><i class="fa fa-instagram"></i></a></li>
		  							<li><a href="mailto:name@email.com"><i class="fa fa-envelope"></i> Email</a></li>
		  						</ul>
							</div>
						</div>
						<div class="team-details text-left">
							<h3 class="member-name">James Williams</h3>
							<h5 class="member-post">- Neurologist</h5>
								</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
					<div class="ulockd-team-member">
						<div class="team-thumb">
							<img class="img-responsive img-whp" src="assets/images/team/2.jpg" alt="team2.jpg">
							<div class="team-overlay">
								<ul class="list-inline team-icon style2">
		  							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
		  							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
		  							<li><a href="#"><i class="fa fa-pinterest"></i></a></li>
		  							<li><a href="#"><i class="fa fa-instagram"></i></a></li>
		  							<li><a href="mailto:name@email.com"><i class="fa fa-envelope"></i> Email</a></li>
		  						</ul>
							</div>
						</div>
						<div class="team-details text-left">
							<h3 class="member-name">Ana Smith</h3>
							<h5 class="member-post">- Dentist</h5>
							</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
					<div class="ulockd-team-member">
						<div class="team-thumb">
							<img class="img-responsive img-whp" src="assets/images/team/4.jpg" alt="4.jpg">
							<div class="team-overlay">
								<ul class="list-inline team-icon style2">
		  							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
		  							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
		  							<li><a href="#"><i class="fa fa-pinterest"></i></a></li>
		  							<li><a href="#"><i class="fa fa-instagram"></i></a></li>
		  							<li><a href="mailto:name@email.com"><i class="fa fa-envelope"></i> Email</a></li>
		  						</ul>
							</div>
						</div>
						<div class="team-details text-left">
							<h3 class="member-name">Jhon Smith</h3>
							<h5 class="member-post">- Cardiologist</h5>
							</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	
<?php 
require_once('includes/footer.php')
?>