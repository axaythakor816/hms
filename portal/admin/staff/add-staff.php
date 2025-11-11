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
								<li class="breadcrumb-item"><a href="staff-list.php">Staffs </a></li>
								<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
								<li class="breadcrumb-item active">Add Staffs</li>
							</ul>
						</div>
					</div>
				</div>

				<!-- /Page Header -->
				<div class="row">
					<div class="col-sm-12">
					
						<div class="card">
							<div class="card-body">
                                    <form action="#" method="POSt">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-heading">
                                                    <h4>Staffs Details</h4>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-xl-4">  
                                                <div class="input-block local-forms">
                                                    <label >First Name <span class="login-danger">*</span></label>
                                                    <input name="fname" class="form-control" type="text"  >
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-xl-4">
                                                <div class="input-block local-forms">
                                                    <label >Last Name <span class="login-danger">*</span></label>
                                                    <input name="lname" class="form-control" type="text"  >
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 col-md-6 col-xl-6">
                                                <div class="input-block local-forms">
                                                    <label >Mobile <span class="login-danger">*</span></label>
                                                    <input name="number" class="form-control" type="text"  >
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-xl-6">
                                                <div class="input-block local-forms">
                                                    <label >Email <span class="login-danger">*</span></label>
                                                    <input name="email" class="form-control" type="email"  >
                                                </div>
                                            </div>
                                            
                                        
                                            <div class="col-12 col-md-6 col-xl-6">
                                                <div class="input-block local-forms cal-icon">
                                                    <label >Date Of Birth  <span class="login-danger">*</span></label>
                                                    <input name="dob" class="form-control datetimepicker" type="text"   >
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-xl-6">
                                                <div class="input-block select-gender">
                                                    <label class="gen-label">Gender<span class="login-danger">*</span></label>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input value="male" type="radio" name="gender" class="form-check-input">Male
                                                        </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input value="male" type="radio" name="gender" class="form-check-input">Female
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-xl-4">
                                                <div class="input-block local-forms">
                                                    <label >Education <span class="login-danger">*</span></label>
                                                    <input name="edu" class="form-control" type="text"  >
                                                </div>
                                            </div>
                                            
                                            

                                            <div class="col-12 col-md-6 col-xl-4">
                                                <div class="input-block local-forms">
                                                    <label >Job Role <span class="login-danger">*</span></label>
                                                    <select name="job" class="form-control select">
                                                        <option>Select Job Role</option>
                                                        <option>Nurse</option>
                                                        <option>Accountent</option>
                                                        <option>cleaner</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12">
                                                <div class="input-block local-forms">
                                                    <label>Address  <span class="login-danger">*</span></label>
                                                    <textarea name="address" class="form-control" rows="3" cols="30"></textarea>
                                                </div>
                                            </div>
                                            
                                            <div class="col-12">
                                                <div class="doctor-submit text-end">
                                                    <button name="submit" type="submit" class="btn btn-primary submit-form me-2">Submit</button>
                                                
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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