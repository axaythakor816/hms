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
								<li class="breadcrumb-item"><a href="schedule.php">Doctor Shedule </a></li>
								<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
								<li class="breadcrumb-item active">Add Schedule</li>
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
												<h4>Add Schedule</h4>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">  
											<div class="input-block local-forms">
												<label >Doctor Name <span class="login-danger">*</span></label>
												<input name="sname" class="form-control" type="text" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Department  <span class="login-danger">*</span></label>
												<select name="sdepart" class="form-control select">
                                                <option value="">Select Department </option>
											<option value="Orthopedist">Orthopedist</option>
											<option value="skin Specialist">skin Specialist</option>
											<option value="Psychology">Psychology</option>
											<option value="Neurologist">Neurologist</option>
											<option value="Dentist">Dentist</option>
											<option value="Cardiologist">Cardiologist</option>
											<option value="Gynecologist">Gynecologist</option>
											<option value="Neurologist">Neurologist</option>
												 
												  </select>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-4">
											<div class="input-block local-forms">
												<label >Available Days  <span class="login-danger">*</span></label>
												<input name="sdays" class="form-control" type="text"   >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-4">
											<div class="input-block local-forms">
												<label>From <span class="login-danger">*</span></label>
												<div class="time-icon">
													<input name="sfrom" type="text" class="form-control" id="datetimepicker3">
												</div>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-4">
											<div class="input-block local-forms">
												<label>To <span class="login-danger">*</span></label>
												<div class="time-icon">
													<input name="sto" type="text" class="form-control" id="datetimepicker4">
												</div>
											</div>
										</div>
										
										<div class="col-12">
											<div class="doctor-submit text-end">
												<button name="submit" type="submit" class="btn btn-primary submit-form me-2">Create Schedule</button>
												
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