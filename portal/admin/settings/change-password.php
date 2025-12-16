<?php
require_once '../../../core/init.php';

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

			<div class="settings-menu-links">
				<ul class="nav nav-tabs menu-tabs">
					<?php if(has_permission('settings', 'can_view')): ?>
					<li class="nav-item active">
						<a class="nav-link" href="settings/settings.php">General Settings</a>
					</li>
					<?php endif;
					if(has_permission('profiles', 'can_view')): ?>
					<li class="nav-item">
						<a class="nav-link" href="settings/profile.php">My Profile</a>
					</li>	
					<?php endif;
					if(has_permission('profiles', 'can_edit')): ?>
					<li class="nav-item">
						<a class="nav-link" href="settings/change-password.php">Change Password</a>
					</li>
					<?php endif; 
					if(has_permission('settings', 'can_view')): ?>
					<li class="nav-item">
						<a class="nav-link" href="settings/permissions/permission_list.php">Permission Settings</a>
					</li>
					<?php endif;
					if(has_permission('roles', 'can_view')): ?>
					<li class="nav-item">
						<a class="nav-link" href="settings/permissions/permission_list.php">Role Settings</a>
					</li>
					<?php endif; ?>
				</ul>
			</div>
			
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
											<input class="form-control" type="text" placeholder="">
										</div>
									</div>
									<div class="col-12 col-md-6 col-xl-6">  
										<div class="input-block local-forms">
											<label>New password <span class="login-danger">*</span></label>
											<input class="form-control" type="text" placeholder="">
										</div>
									</div>
									<div class="col-12 col-md-6 col-xl-6">  
										<div class="input-block local-forms">
											<label>Confirm password <span class="login-danger">*</span></label>
											<input class="form-control" type="text" placeholder="">
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
