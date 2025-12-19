<?php
require_once '../../../../core/init.php';

require_login();

// if(!has_permission('passwords', 'can_edit')) {
// 	showalert("error", "Access Denine");
// 	exit;
// }

?>        
<div class="page-wrapper">
		<!-- Page Content -->
		<div class="content container-fluid">

			<!-- Page Header -->
			<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Dashboard </a></li>
							<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
							<li class="breadcrumb-item active">Settings</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- /Page Header -->
			
			<div class="row">
				<div class="col-lg-8">
					<div class="card">
						<div class="card-body">
							<form id="change_password_form">
			                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
								<div class="row">
									<h4 class="page-title">Change Password</h4>
									<div class="col-12 col-md-6 col-xl-12">  
										<div class="input-block local-forms">
											<label>Old password <span class="login-danger">*</span></label>
											<input class="form-control" type="password" name="old_password" placeholder="Enter Old Password">
											<div class="row">
												<span class="error col-6" id="old_password_error"></span>
												<div class="mt-2 text-end col-6">
													<a href="settings/passwords/forgot_password_page.php" class="text-primary nav-link" style="font-size: 14px;">Forgot Password?</a>
												</div>

											</div>
											
										</div>
									</div>
									
									<div class="col-12 col-md-6 col-xl-6">  
										<div class="input-block local-forms">
											<label>New password <span class="login-danger">*</span></label>
											<input class="form-control" type="password" name="new_password" placeholder="Enter New Password">
											<span class="error col-6" id="new_password_error"></span>
										</div>
									</div>
									<div class="col-12 col-md-6 col-xl-6">  
										<div class="input-block local-forms">
											<label>Confirm password <span class="login-danger">*</span></label>
											<input class="form-control" name="confirm_password" type="password" placeholder="Enter Confirm Password">
											<span class="error col-6" id="confirm_password_error"></span>

										</div>
									</div>
									<div class="col-12">
										<div class="doctor-submit text-end">
											<button type="reset" 
												class="btn btn-secondary me-2"
												onclick="return confirm('Are you sure you want to clear the form?')">
												Cancel
											</button>
											<button type="submit" 
											name="change_password"
													class="btn btn-primary submit-form">
												Change Password
											</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			
		</div>
		<!-- /Page Content -->
</div>
<script src="../assets/ajax/passwords.js"></script>

