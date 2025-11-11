<?php

require_once('includes/header.php');
?>
	<!-- Home Design -->
	<div class="ulockd-home-slider">
		<div class="container-fluid">
			<div class="row">
				<div id="sg-carousel" class="carousel slide carousel-fade" data-ride="carousel">
					<ol class="carousel-indicators">
						<li data-target="#carousel" data-slide-to="0" class="active"></li>
						<li data-target="#carousel" data-slide-to="1" class=""></li>
						<li data-target="#carousel" data-slide-to="2" class=""></li>
					</ol>
					<!-- Carousel items -->
					<div class="carousel-inner carousel-zoom">
					   <div class="item"><img class="img-responsive" src="assets/images/home/h6.jpg" alt="h6.jpg">
						    <div class="carousel-caption style2">
								<h1 data-animation="animated zoomInLeft" class="cap-txt">Expert Symptom Checker</h1>
								<p data-animation="animated bounceInDown">Giving The Best Solution</p>
								<!-- <p class="style2" data-animation="animated bounceInUp">The current concern about quality of care in the Bclinico is deeply.</p> -->
								
						    </div>
						</div>
						<div class="item active"><img class="img-responsive" src="assets/images/home/h7.jpg" alt="h7.jpg">
						    <div class="carousel-caption style1">
								<h1 data-animation="animated zoomInLeft" class="cap-txt">Best Symptom Finder</h1>
								<p data-animation="animated bounceInDown">Giving The Best Solution</p>
								<!-- <p class="style2" data-animation="animated bounceInUp">Thousand of people satisfied our medical treatment</p> -->
								<button href="page-appointment.php" data-toggle="" data-animation="animated bounceInUp" class="btn btn-lg ulockd-btn-thm2 hidden-xs ulockd-mr10"><span>Appointment</span></button>
								
						    </div>
						</div>
						<div class="item"><img class="img-responsive" src="assets/images/home/h8.jpg" alt="h8.jpg">
						    <div class="carousel-caption animated slideInLeft style3">
								<h1 data-animation="animated zoomInLeft" class="cap-txt">Try Our Best to Solved</h1>
								<p data-animation="animated bounceInDown">Show Your Problem</p>
								<!-- <p class="style2" data-animation="animated bounceInUp">Thousand of people satisfied our medical treatment</p> -->
								
						    </div>
						</div>
						<!-- Carousel nav -->
						<a class="carousel-control left" href="#sg-carousel" data-slide="prev">‹</a>
						<a class="carousel-control right" href="#sg-carousel" data-slide="next">›</a>
					</div> 
				</div>
			</div>
		</div>
	</div>

	<!-- Our About -->
	<section class="ulockd-about bgc-snowshade2">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3 text-center">
					<div class="ulockd-main-title">
						<h2><span class="text-thm">Ka<span class="color-nightblue">R</span>n</span> Your Medical Assist</h2>
								<div class="mt-separator"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxs-12 col-xs-6 col-sm-6 col-md-3">
					<div class="about-box text-center">
						<div class="ab-icn"><span class="flaticon-sign bgc-thm"></span></div>
						<h3>Since 1970</h3>
						<p></p>
						
					</div>
				</div>
				<div class="col-xxs-12 col-xs-6 col-sm-6 col-md-3">
					<div class="about-box text-center">
						<div class="ab-icn"><span class="flaticon-emergency-ambulance bgc-thm"></span></div>
						<h3>Emergency Calls</h3>
						<p></p>
						<button type="submit" class="btn btn-default ulockd-btn-thm2"> Call Us <i class="fa fa-phone"></i></button>
					</div>
				</div>
				<div class="col-xxs-12 col-xs-6 col-sm-6 col-md-3">
					<div class="about-box text-center">
						<div class="ab-icn"><span class="flaticon-people-8 bgc-thm"></span></div>
						<h3>Apointments</h3>
						<p></p>
						<a href="page-appointment.php" data-toggle="" class="btn btn-default ulockd-btn-thm2"> Make An Apointment <i class="flaticon-people-8"></i></a>
					</div>
				</div>
				<div class="col-xxs-12 col-xs-6 col-sm-6 col-md-3">
					<div class="about-box">
						<div class="ab-icn text-center"><span class="flaticon-clock-2 bgc-thm"></span></div>
						<h3 class="text-center">Opening Hour</h3>
						<ul class="list-group">
							<li class="list-group-item"><strong>Mon - Fri </strong> <span class="badge bgc-thm"> 8:00 - 20:30</span></li>
							<li class="list-group-item"><strong>Saturday </strong> <span class="badge bgc-thm"> 8:30 - 18:00</span></li>
							<li class="list-group-item"><strong>Sunday </strong> <span class="badge bgc-thm"> 9:00 - 20:30</span></li>
						</ul>
					</div>
				</div>
				<!-- Product Popup View Start-->
				<div class="modal fade appointment_view" id="appointment_view">
				    <div class="modal-dialog">
				        <div class="modal-content">
				            <div class="modal-header text-center">
				                <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
				                <h3 class="modal-title">Appointment Form. </h3>
				            </div>
				            <div class="modal-body">
				                <div class="row">
				                    <div class="col-md-10 col-md-offset-1">
										<!-- Appointment Form Starts -->
					                    <form id="appointment_form" name="appointment_form" class="appointment_form text-center" action="https://unlockdesizn.com/html/health-and-beauty/bclinico/includes/appointment.php" method="post" novalidate="novalidate">
					                        <div class="messages"></div>
					                        <div class="row">
					                            <div class="col-md-12">
										        	<h2 class="text-thm">Appointment with Expert</h2>
										        	<p>Let's Appointment With our Exparts Who Try to Solved Your Problem.</p>
					                                <div class="form-group text-left">
					                                    <label for="form_name"><i class="fa fa-user-o"></i> Name <small>*</small></label>
					                                    <input id="form_name" name="form_name" class="form-control" placeholder="enter a name" required="required" data-error="Name is required." type="text">
					                                    <div class="help-block with-errors"></div>
					                                </div>
					                            </div>
					                            <div class="col-md-12">
					                                <div class="form-group text-left">
					                                    <label for="form_email"><i class="fa fa-envelope-open-o"></i> Email <small>*</small></label>
					                                    <input id="form_email" name="form_email" class="form-control required email" placeholder="enter an email" required="required" data-error="Email is required." type="email">
					                                    <div class="help-block with-errors"></div>
					                                </div>
					                            </div>
					                            <div class="col-md-6">
					                                <div class="form-group text-left">
					                                    <label for="form_date"><i class="fa fa-calendar-check-o"></i> Date <small>*</small></label>
					                                    <input id="form_date" name="form_date" class="form-control required datepicker" placeholder="enter a date" required="required" data-error="Subject is required." type="text">
					                                    <div class="help-block with-errors"></div>
					                                </div>
					                            </div> 
					                            <div class="col-md-6">
					                                <div class="form-group text-left">
					                                    <label for="form_phone"><i class="fa fa-phone"></i> Phone <small>*</small></label>
					                                    <input id="form_phone" name="form_phone" class="form-control required" placeholder="enter a phone" required="required" data-error="Phone Number is required." type="text">
					                                    <div class="help-block with-errors"></div>
					                                </div>
					                            </div>  
					                        </div>
					                        <div class="form-group text-left">
					                            <label for="form_name"><i class="fa fa-file-text-o"></i> Message</label>
					                            <textarea id="form_message" name="form_message" class="form-control required" rows="5" placeholder="type in a message" required="required" data-error="Message is required."></textarea>
					                            <div class="help-block with-errors"></div>
					                        </div>
					                        <div class="form-group text-center">
					                            <input id="form_botcheck" name="form_botcheck" class="form-control" value="" type="hidden">
					                            <button type="submit" class="btn btn-lg ulockd-btn-thm2" data-loading-text="Getting Few Sec...">Send</button>
					                        </div>
					                    </form>
				                    </div>
				                </div>
				            </div>
				        </div>
				    </div>
				</div>
				<!-- Product Popup View End-->
			</div>
		</div>
	</section>

	<!-- Our Team -->
	<section class="ulockd-team bgc-icebluelight">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3 text-center">
					<div class="ulockd-main-title">
						<h2 class="text-uppercase">Our <span class="text-thm">Doctor's</span></h2>
							<div class="mt-separator"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs team-tab" role="tablist">
				  		<li role="presentation" class="active"><a href="#team1" aria-controls="team1" role="tab" data-toggle="tab"><img src="assets/images/team/s1.jpg" alt="s1.jpg"></a></li>
				  		<li role="presentation"><a href="#team2" aria-controls="team2" role="tab" data-toggle="tab"><img src="assets/images/team/s2.jpg" alt="s2.jpg"></a></li>
				  		<li role="presentation"><a href="#team3" aria-controls="team3" role="tab" data-toggle="tab"><img src="assets/images/team/s3.jpg" alt="s3.jpg"></a></li>
				  		<li role="presentation"><a href="#team4" aria-controls="team4" role="tab" data-toggle="tab"><img src="assets/images/team/s4.jpg" alt="s4.jpg"></a></li>
				  		<li role="presentation"><a href="#team5" aria-controls="team5" role="tab" data-toggle="tab"><img src="assets/images/team/s5.jpg" alt="s5.jpg"></a></li>
				  		<li role="presentation"><a href="#team6" aria-controls="team6" role="tab" data-toggle="tab"><img src="assets/images/team/s6.jpg" alt="s6.jpg"></a></li>
				  		<li role="presentation"><a href="#team7" aria-controls="team7" role="tab" data-toggle="tab"><img src="assets/images/team/s7.jpg" alt="s7.jpg"></a></li>
				  		<li role="presentation"><a href="#team8" aria-controls="team8" role="tab" data-toggle="tab"><img src="assets/images/team/s8.jpg" alt="s8.jpg"></a></li>
					</ul>
				</div>
			</div>
			<div class="row">
				<!-- Tab panes -->
				<div class="tab-content">
			  		<div role="tabpanel" class="tab-pane active team1" id="team1">
						<div class="col-xxs-12 col-xs-6 col-sm-6 col-md-4">
							<div class="ulockd-team-member">
								<div class="team-thumb">
									<img class="img-responsive img-whp" src="assets/images/team/1.jpg" alt="1.jpg">
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
									<h3>Neurologist <small class="text-thm">- James Williams</small> </h3>
									<a href="page-appointment.php" data-toggle="" class="btn btn-default ulockd-btn-thm2"> Make An Apointment <i class="flaticon-people-8"></i></a>
								</div>
							</div>
						</div>
						<div class="col-xxs-12 col-xs-6 col-sm-6 col-md-4">
							<div class="team-overview">
								<h3 class="tm-ovv-title">Overview for James Williams</h3>
								<strong>Experience:</strong> Specialty in Neurology. <br>
								<strong>Expertise:</strong> Multiple Sclerosis & Neuro-Immunology.<br>
								<strong>Board Certification:</strong> Neurology.<br>
								<strong>Primary Care Physician:</strong> No. <br>
								<strong>Appointment:</strong> Mon - Sat. <br>
								<strong>Schdule:</strong> 8:00 - 19:00. <br>
								<address>
									<strong>Primary Address:</strong><br>
									1355 Market Street, Suite 900<br>
									San Francisco, CA 94103<br>
									<abbr title="Phone">P:</abbr> 343-854-5171
								</address>
								<img src="assets/images/resource/signeture.png" alt="signeture.png">
								<address>
									<strong>James Williams</strong><br>
									<a href="mailto:#">first.last@example.com</a>
								</address>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4">
							<div class="ulockd-testimonials text-center">
								
							</div>
						</div>
			  		</div>

			  		<div role="tabpanel" class="tab-pane team2" id="team2">
						<div class="col-xxs-12 col-xs-6 col-sm-6 col-md-4">
							<div class="ulockd-team-member">
								<div class="team-thumb">
									<img class="img-responsive img-whp" src="assets/images/team/2.jpg" alt="2.jpg">
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
									<h3>Gynecologist <small class="text-thm">- Ana Smith</small> </h3>
									<a href="page-appointment.php" data-toggle="" class="btn btn-default ulockd-btn-thm2"> Make An Apointment <i class="flaticon-people-8"></i></a>
								</div>
							</div>
						</div>
						<div class="col-xxs-12 col-xs-6 col-sm-6 col-md-4">
							<div class="team-overview">
								<h3 class="tm-ovv-title">Overview for Ana Smith</h3>
								<strong>Experience:</strong> Specialty in Gynecologist. <br>
								<strong>Expertise:</strong> Multiple Sclerosis & Neuro-Immunology.<br>
								<strong>Board Certification:</strong> Gynecologist.<br>
								<strong>Primary Care Physician:</strong> No. <br>
								<strong>Appointment:</strong> Mon - Sat. <br>
								<strong>Schdule:</strong> 8:00 - 19:00. <br>
								<address>
									<strong>Primary Address:</strong><br>
									1355 Market Street, Suite 900<br>
									San Francisco, CA 94103<br>
									<abbr title="Phone">P:</abbr> 343-854-5171
								</address>
								<img src="assets/images/resource/signeture.png" alt="signeture.png">
								<address>
									<strong>Ana Smith</strong><br>
									<a href="mailto:#">first.last@example.com</a>
								</address>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4">
							<div class="ulockd-testimonials text-center">
								
							</div>
						</div>
			  		</div>

			  		<div role="tabpanel" class="tab-pane team3" id="team3">
						<div class="col-xxs-12 col-xs-6 col-sm-6 col-md-4">
							<div class="ulockd-team-member">
								<div class="team-thumb">
									<img class="img-responsive img-whp" src="assets/images/team/3.jpg" alt="3.jpg">
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
									<h3>Cardiologist <small class="text-thm">- Jhon Smith</small> </h3>
									<a href="page-appointment.php" data-toggle="" class="btn btn-default ulockd-btn-thm2"> Make An Apointment <i class="flaticon-people-8"></i></a>
								</div>
							</div>
						</div>
						<div class="col-xxs-12 col-xs-6 col-sm-6 col-md-4">
							<div class="team-overview">
								<h3 class="tm-ovv-title">Overview for Jhon Smith</h3>
								<strong>Experience:</strong> Specialty in Cardiologist. <br>
								<strong>Expertise:</strong> paediatric cardiologists & Cardiologist.<br>
								<strong>Board Certification:</strong> Cardiologist.<br>
								<strong>Primary Care Physician:</strong> No. <br>
								<strong>Appointment:</strong> Mon - Sat. <br>
								<strong>Schdule:</strong> 8:00 - 19:00. <br>
								<address>
									<strong>Primary Address:</strong><br>
									1355 Market Street, Suite 900<br>
									San Francisco, CA 94103<br>
									<abbr title="Phone">P:</abbr> 343-854-5171
								</address>
								<img src="assets/images/resource/signeture.png" alt="signeture.png">
								<address>
									<strong>Jhon Smith</strong><br>
									<a href="mailto:#">first.last@example.com</a>
								</address>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4">
							<div class="ulockd-testimonials text-center">
								
							</div>
						</div>
			  		</div>

			  		<div role="tabpanel" class="tab-pane team4" id="team4">
						<div class="col-xxs-12 col-xs-6 col-sm-6 col-md-4">
							<div class="ulockd-team-member">
								<div class="team-thumb">
									<img class="img-responsive img-whp" src="assets/images/team/5.jpg" alt="5.jpg">
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
									<h3>Dentist <small class="text-thm">- Bella Smith</small> </h3>
									<a href="page-appointment.php" data-toggle="" class="btn btn-default ulockd-btn-thm2"> Make An Apointment <i class="flaticon-people-8"></i></a>
								</div>
							</div>
						</div>
						<div class="col-xxs-12 col-xs-6 col-sm-6 col-md-4">
							<div class="team-overview">
								<h3 class="tm-ovv-title">Overview for Bella Smith</h3>
								<strong>Experience:</strong> Specialty in Dentist. <br>
								<strong>Expertise:</strong> Aesthetic dentistry & Preventative dentistry.<br>
								<strong>Board Certification:</strong> Dentist.<br>
								<strong>Primary Care Physician:</strong> No. <br>
								<strong>Appointment:</strong> Mon - Sat. <br>
								<strong>Schdule:</strong> 8:00 - 19:00. <br>
								<address>
									<strong>Primary Address:</strong><br>
									1355 Market Street, Suite 900<br>
									San Francisco, CA 94103<br>
									<abbr title="Phone">P:</abbr> 343-854-5171
								</address>
								<img src="assets/images/resource/signeture.png" alt="signeture.png">
								<address>
									<strong>Bella Smith</strong><br>
									<a href="mailto:#">first.last@example.com</a>
								</address>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4">
							<div class="ulockd-testimonials text-center">
								

							</div>
						</div>
			  		</div>

			  		<div role="tabpanel" class="tab-pane team5" id="team5">
						<div class="col-xxs-12 col-xs-6 col-sm-6 col-md-4">
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
									<h3>Neurologist <small class="text-thm">- Smith Johnson</small> </h3>
									<a href="page-appointment.php" data-toggle="" class="btn btn-default ulockd-btn-thm2"> Make An Apointment <i class="flaticon-people-8"></i></a>
								</div>
							</div>
						</div>
						<div class="col-xxs-12 col-xs-6 col-sm-6 col-md-4">
							<div class="team-overview">
								<h3 class="tm-ovv-title">Overview for Smith Johnson</h3>
								<strong>Experience:</strong> Specialty in Neurology. <br>
								<strong>Expertise:</strong> Multiple Sclerosis & Neuro-Immunology.<br>
								<strong>Board Certification:</strong> Neurology.<br>
								<strong>Primary Care Physician:</strong> No. <br>
								<strong>Appointment:</strong> Mon - Sat. <br>
								<strong>Schdule:</strong> 8:00 - 19:00. <br>
								<address>
									<strong>Primary Address:</strong><br>
									1355 Market Street, Suite 900<br>
									San Francisco, CA 94103<br>
									<abbr title="Phone">P:</abbr> 343-854-5171
								</address>
								<img src="assets/images/resource/signeture.png" alt="signeture.png">
								<address>
									<strong>Smith Johnson</strong><br>
									<a href="mailto:#">first.last@example.com</a>
								</address>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4">
							<div class="ulockd-testimonials text-center">
								
							</div>
						</div>
			  		</div>

			  		<div role="tabpanel" class="tab-pane team6" id="team6">
						<div class="col-xxs-12 col-xs-6 col-sm-6 col-md-4">
							<div class="ulockd-team-member">
								<div class="team-thumb">
									<img class="img-responsive img-whp" src="assets/images/team/6.jpg" alt="6.jpg">
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
									<h3>Psychology <small class="text-thm">- Savannah Smith</small> </h3>
									<a href="page-appointment.php" data-toggle="" class="btn btn-default ulockd-btn-thm2"> Make An Apointment <i class="flaticon-people-8"></i></a>
								</div>
							</div>
						</div>
						<div class="col-xxs-12 col-xs-6 col-sm-6 col-md-4">
							<div class="team-overview">
								<h3 class="tm-ovv-title">Overview for Savannah Smith</h3>
								<strong>Experience:</strong> Specialty in Psychology.<br>
								<strong>Expertise:</strong> Multiple Sclerosis & Neuro-Immunology.<br>
								<strong>Board Certification:</strong> Psychology.<br>
								<strong>Primary Care Physician:</strong> No. <br>
								<strong>Appointment:</strong> Mon - Sat. <br>
								<strong>Schdule:</strong> 8:00 - 19:00. <br>
								<address>
									<strong>Primary Address:</strong><br>
									1355 Market Street, Suite 900<br>
									San Francisco, CA 94103<br>
									<abbr title="Phone">P:</abbr> 343-854-5171
								</address>
								<img src="assets/images/resource/signeture.png" alt="signeture.png">
								<address>
									<strong>Savannah Smith</strong><br>
									<a href="mailto:#">first.last@example.com</a>
								</address>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4">
							<div class="ulockd-testimonials text-center">
								
							</div>
						</div>
			  		</div>

			  		<div role="tabpanel" class="tab-pane team7" id="team7">
						<div class="col-xxs-12 col-xs-6 col-sm-6 col-md-4">
							<div class="ulockd-team-member">
								<div class="team-thumb">
									<img class="img-responsive img-whp" src="assets/images/team/7.jpg" alt="7.jpg">
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
									<h3>Skin Specialist <small class="text-thm">- Madeleine Smith</small> </h3>
									<a href="page-appointment.php" data-toggle="" class="btn btn-default ulockd-btn-thm2"> Make An Apointment <i class="flaticon-people-8"></i></a>
								</div>
							</div>
						</div>
						<div class="col-xxs-12 col-xs-6 col-sm-6 col-md-4">
							<div class="team-overview">
								<h3 class="tm-ovv-title">Overview for Madeleine Smith</h3>
								<strong>Experience:</strong> Specialty in Neurology. <br>
								<strong>Expertise:</strong> Multiple Sclerosis & Neuro-Immunology.<br>
								<strong>Board Certification:</strong> Neurology.<br>
								<strong>Primary Care Physician:</strong> No. <br>
								<strong>Appointment:</strong> Mon - Sat. <br>
								<strong>Schdule:</strong> 8:00 - 19:00. <br>
								<address>
									<strong>Primary Address:</strong><br>
									1355 Market Street, Suite 900<br>
									San Francisco, CA 94103<br>
									<abbr title="Phone">P:</abbr> 343-854-5171
								</address>
								<img src="assets/images/resource/signeture.png" alt="signeture.png">
								<address>
									<strong>Madeleine Smith</strong><br>
									<a href="mailto:#">first.last@example.com</a>
								</address>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4">
							<div class="ulockd-testimonials text-center">
								
							</div>
						</div>
			  		</div>

			  		<div role="tabpanel" class="tab-pane team8" id="team8">
						<div class="col-xxs-12 col-xs-6 col-sm-6 col-md-4">
							<div class="ulockd-team-member">
								<div class="team-thumb">
									<img class="img-responsive img-whp" src="assets/images/team/8.jpg" alt="8.jpg">
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
									<h3>orthopedist <small class="text-thm">- Henry Jones</small> </h3>
									<a href="page-appointment.php" data-toggle="" class="btn btn-default ulockd-btn-thm2"> Make An Apointment <i class="flaticon-people-8"></i></a>
								</div>
							</div>
						</div>
						<div class="col-xxs-12 col-xs-6 col-sm-6 col-md-4">
							<div class="team-overview">
								<h3 class="tm-ovv-title">Overview for Henry Jones</h3>
								<strong>Experience:</strong> Specialty in orthopedist. <br>
								<strong>Expertise:</strong> Multiple Sclerosis & Neuro-Immunology.<br>
								<strong>Board Certification:</strong> orthopedist.<br>
								<strong>Primary Care Physician:</strong> No. <br>
								<strong>Appointment:</strong> Mon - Sat. <br>
								<strong>Schdule:</strong> 8:00 - 19:00. <br>
								<address>
									<strong>Primary Address:</strong><br>
									1355 Market Street, Suite 900<br>
									San Francisco, CA 94103<br>
									<abbr title="Phone">P:</abbr> 343-854-5171
								</address>
								<img src="assets/images/resource/signeture.png" alt="signeture.png">
								<address>
									<strong>Henry Jones</strong><br>
									<a href="mailto:#">first.last@example.com</a>
								</address>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4">
							<div class="ulockd-testimonials text-center">
								
							</div>
						</div>
			  		</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Our First Divider -->
	<section class="ulockd-frst-divider parallax ulockd_bgi3" data-stellar-background-ratio="0.3">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center">
					<h3 class="color-white ulockd-mt0 ulockd-mb40">Karn Proud to Say, After Providing You The Best Medical & Health Care Support.</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 col-xs-6 col-sm-6 col-md-3 text-center">
					<div class="ulockd-ffact-one">
						<span class="flaticon-people-10 text-thm"></span>
                        <p>Total User</p>
                        <div class="timer">55860</div>
					</div>
				</div>
				<div class="col-xs-6 col-xs-6 col-sm-6 col-md-3 text-center">
					<div class="ulockd-ffact-one">
						<span class="flaticon-medal text-thm"></span>
                        <p>Total Award</p>
                        <div class="timer">2052</div>
					</div>
				</div>
				<div class="col-xs-6 col-xs-6 col-sm-6 col-md-3 text-center">
					<div class="ulockd-ffact-one">
						<span class="flaticon-interface text-thm"></span>
                        <p>Successful Projects</p>
                        <div class="timer">22780</div>
					</div>
				</div>
				<div class="col-xs-6 col-xs-6 col-sm-6 col-md-3 text-center">
					<div class="ulockd-ffact-one">
						<span class="flaticon-checked-mark text-thm"></span>
                        <p>Total Supported</p>
                        <div class="timer">707400</div>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php 
require_once('includes/footer.php')
?>