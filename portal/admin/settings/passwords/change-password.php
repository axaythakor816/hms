<?php
require_once '../../../../core/init.php';

require_login();

// if(!has_permission('permissions', 'can_view')) {
// 	showalert("error", "Access Denine");
// 	exit;
// }

require_role([1]);

?>        
<div class="page-wrapper">
		<!-- Page Content -->
		<div class="content container-fluid">

			<!-- Page Header -->
			<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="index.php">Dashboard </a></li>
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
							<form>
								<div class="row">
									<h4 class="page-title">Change Password</h4>
									<div class="col-12 col-md-6 col-xl-12">  
										<div class="input-block local-forms">
											<label>Old password <span class="login-danger">*</span></label>
											<input class="form-control" type="text" placeholder="Enter Old Password">
											<div class="mt-2 text-end">
												<a href="settings/passwords/forgot_password.php" class="text-primary nav-link" style="font-size: 14px;">Forgot Password?</a>
											</div>
										</div>
									</div>
									
									<div class="col-12 col-md-6 col-xl-6">  
										<div class="input-block local-forms">
											<label>New password <span class="login-danger">*</span></label>
											<input class="form-control" type="text" placeholder="Enter New Password">
										</div>
									</div>
									<div class="col-12 col-md-6 col-xl-6">  
										<div class="input-block local-forms">
											<label>Confirm password <span class="login-danger">*</span></label>
											<input class="form-control" type="text" placeholder="Enter Confirm Password">
										</div>
									</div>
									<div class="col-12">
										<div class="doctor-submit text-end">
											<button type="submit" class="btn btn-primary submit-form me-2">Submit</button>
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
