<?php 
require_once('includes/header.php')
?>
	<!-- Home Design Inner Pages -->
	<div class="ulockd-inner-home">
		<div class="container text-center">
			<div class="row">
				<div class="inner-conraimer-details">
					<div class="col-md-12">
						<h1 class="text-uppercase">JOB APPLY FORM</h1>
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
							<li> <a href="#"> JOB APPLY FORM </a> </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Our About -->
	<section class="ulockd-about">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-6 col-md-offset-3">
					<div class="booking_form_style1 text-center">
		                <!-- Booking Form Sart-->
			            <form id="jobapply_form" class="booking_form_area"  method="POST" action="#" enctype="multipart/form-data" novalidate="novalidate">
			                <div class="messages"></div>
							<div class="row">
				                <div class="col-sm-12">
				                	<h3>Job Apply Form</h3>
				                </div>
				                <div class="col-sm-12">
				                    <div class="form-group text-left">
										<label for="form_name"><i class="fa fa-user-o"></i> FULL Name <small>*</small></label>
										<input id="form_name" name="name" class="form-control" placeholder="FULL Name" required="required" data-error="Name is required." type="text">
										<div class="help-block with-errors"></div>
									</div>
				                </div>
				                <div class="col-sm-12">
									<div class="form-group text-left">
										<label for="form_email"><i class="fa fa-envelope-open-o"></i> Enter Your Email <small>*</small></label>
										<input id="form_email" name="email" class="form-control required email" placeholder="Enter Your Email" required="required" data-error="Email is required." type="email">
										<div class="help-block with-errors"></div>
									</div>
				                </div>
								<div class="col-sm-12">
				                    <div class="form-group text-left">
										<label for="form_phone"><i class="fa fa-phone"></i> Enter Your Phone Number <small>*</small></label>
										<input id="form_phone" name="number" class="form-control required" placeholder="Enter Your Phone Number" required="required" data-error="Phone Number is required." type="text">
										<div class="help-block with-errors"></div>
									</div>
				                </div>
				                <div class="col-sm-6">
				                    <div class="form-group text-left">
					                    <div class="ulockd-select-style">
											<label for="form_gender"><i class="fa fa-user-o"></i> Select Your Gender <small>*</small></label>
					                        <select id="form_option" class="form-control form_control required" name="gender" required="required" data-error="Gender is required.">
				                                <option value="">Select A Gender</option>
				                                <option value="male">Male</option>
				                                <option value="female">Female</option>
				                                <option value="other">Other</option>
					                        </select>
					                    </div>
										<div class="help-block with-errors"></div>
				                    </div>
				                </div>
				                <div class="col-sm-6">
				                    <div class="form-group text-left">
					                    <div class="ulockd-select-style">
											<label for="form_job"><i class="fa fa-info"></i> Select job Role <small>*</small></label>
					                        <select id="form_option2" class="form-control form_control required" name="jobrole" required="required" data-error="Option is required.">
				                                <option value="">Select A Job Role </option>
				                                <option value="Account Executive">Account Executive</option>
				                                <option value="Doctor">Doctor</option>
				                                <option value="Nurse">Nurse</option>
					                        </select>
					                    </div>
										<div class="help-block with-errors"></div>
				                    </div>
				                </div>
			        			<div class="col-md-12">
		                            <div class="form-group">
		                                <textarea id="form_message" name="note" class="form-control ulockd-form-tb required" rows="5" placeholder="Additional Note" required="required" data-error="Message is required."></textarea>
		                                <div class="help-block with-errors"></div>
		                            </div>
									
				                    <div class="form-group text-left">
				                    	<label for="form_attachment"><i class="fa fa-file-text-o"></i> Upload Resume</label>
					                    <input type="file" id="form_attachment" name="uimage" class="form-control" required="Resume is Required">
				                    </div>
				                    <div class="form-group text-center">
					                    <input name="form_botcheck" class="form-control" type="hidden" value="">
					                    <button type="submit" name="apply" class="btn btn-lg btn-block ulockd-btn-thm2 ">Apply Now</button>
				                    </div>
			        			</div>
			                </div>
			            </form>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Our Footer -->
<?php 
require_once('includes/footer.php')
?>