<?php
require_once '../../../core/init.php';
require_login();	

if(!has_permission('departments', 'can_add')) {
	showalert("error", "Access Denine");
	exit;
}

?>

<div class="page-wrapper">
	<div class="content">
	
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col-sm-12">
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="departments/department_list.php" class="nav-link">Department </a></li>
						<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
						<li class="breadcrumb-item active">Add Department</li>
					</ul>
				</div>
			</div>
		</div>
	
		<!-- /Page Header -->
		<div class="row">
			<div class="col-sm-12">
			
				<div class="card">
					<div class="card-body">
						<form id="adddepartment_form" action="#" method="POST">
							<input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

							<div class="row">
								<div class="col-12">
									<div class="form-heading">
										<h4>Add Department</h4>
									</div>
								</div>
								<div class="col-12 col-md-6 col-xl-6">  
									<div class="input-block local-forms">
										<label >Department Name <span class="login-danger">*</span></label>
										<input name="department_name" id="department_name" class="form-control" type="text" placeholder="Enter Department Name">
										<span class="error" id="department_name_error"></span>
									</div>
								</div>
								<div class="col-12 col-md-6 col-xl-6">  
									<div class="input-block local-forms">
										<label >Department Description <span class="login-danger">*</span></label>
										<textarea name="department_description" id="department_description" class="form-control" rows="3" maxlength="300" placeholder="Enter department description (max 300 characters)"></textarea>
										<small class="text-muted">
											<span id="desc_count">0</span>/300 characters used
										</small>

										<span class="error" id="department_description_error"></span>
									</div>
								</div>
								
								<div class="col-12">
									<div class="doctor-submit text-end">
										<button name="save_department" type="submit" class="btn btn-primary submit-form me-2">Create Department</button>
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
		
<script src="../assets/ajax/departments.js"></script>

