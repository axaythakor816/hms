<?php
require_once('includes/auth_check.php');
require_once('includes/header.php');
require_once('includes/sidebar.php');
?>
        <div class="page-wrapper">
            <div class="content">
			
				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col-sm-12">
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="appointments.php">Appointment </a></li>
								<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
								<li class="breadcrumb-item active">Book Appointment</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				<div class="row">
					<div class="col-sm-12">
					
						<div class="card">
							<div class="card-body">
								<form action="#" method="POST">
									<div class="row">
										<div class="col-12">
											<div class="form-heading">
												<h4>Patient Details</h4>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-4">  
											<div class="input-block local-forms">
												<label >Full Name <span class="login-danger">*</span></label>
												<input class="form-control" name="name" type="text" >
											</div>
										</div>
										
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Select Gender <span class="login-danger">*</span></label>
												<select class="form-control select" name="gender">
                                                <option value="">Select Gender </option>
											    <option value="male">Male</option>
				                                <option value="female">Female</option>
				                                <option value="other">Other</option>
												  </select>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Mobile <span class="login-danger">*</span></label>
												<input class="form-control" type="text" name="number" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Email <span class="login-danger">*</span></label>
												<input class="form-control" type="email" name="email" >
											</div>
										</div>
										<div class="col-12 col-sm-12">
											<div class="input-block local-forms">
												<label>Address  <span class="login-danger">*</span></label>
												<textarea class="form-control" rows="3" cols="30" name="address"></textarea>
											</div>
										</div>
										<div class="col-12">
											<div class="form-heading">
												<h4>Appointment Details</h4>
											</div>
										</div>

                                        <div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >select Doctor <span class="login-danger">*</span></label>
												<select class="form-control select" name="doctor">
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
											</div>
										</div>

										<div class="col-12 col-md-6 col-xl-4">
											<div class="input-block local-forms cal-icon">
												<label >Date of Appointment <span class="login-danger">*</span></label>
												<input class="form-control datetimepicker" type="text" name="date"  >
											</div>
										</div>
										
										<div class="col-12 col-sm-12">
											<div class="input-block local-forms">
												<label>Notes  <span class="login-danger">*</span></label>
												<textarea class="form-control" rows="3" cols="30" name="note"></textarea>
											</div>
										</div>
										
										<div class="col-12">
											<div class="doctor-submit text-end">
												<button type="submit" name="send" class="btn btn-primary submit-form me-2">Submit</button>
												
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>							
					</div>					
				</div>
            </div>
        </div>
		<div id="delete_patient" class="modal fade delete-modal" role="dialog">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-body text-center">
						<img src="assets/img/sent.png" alt="" width="50" height="46">
						<h3>Are you sure want to delete this ?</h3>
						<div class="m-t-20"> <a href="#" class="btn btn-white" data-bs-dismiss="modal">Close</a>
							<button type="submit" class="btn btn-danger">Delete</button>
						</div>
					</div>
				</div>
			</div>
			
		</div>
<?php 
require_once('includes/footer.php');
?>