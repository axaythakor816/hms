<?php
require_once '../../../core/init.php';
require_login();	

if(!has_permission('departments', 'can_add')) {
	showalert("error", "Access Denine");
	exit;
}

?>

<div class="modal fade" id="addDepatmentModal" tabindex="-1" aria-labelledby="addDepartmentLabel" aria-hidden="true">
	<div class="modal-dialog modal-md"> <!-- modal-xl for large form -->
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addDepartmentLabel">Add New Department</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>					
			</div>

			<div class="modal-body">
				<form id="adddepartment_form" action="#" method="POST">
					<!-- <div class="row"> -->
						<input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

						<div class="col-12">
							<div class="form-heading">
								<h4>Add Department</h4>
							</div>
						</div>
						<div class="col-12 col-md-12 col-xl-12">  
							<div class="input-block local-forms">
								<label >Department Name <span class="login-danger">*</span></label>
								<input name="department_name" id="department_name" class="form-control" type="text" >
								<span class="error" id="department_name_error"></span>
							</div>
						</div>
						<div class="col-12 col-md-12 col-xl-12">  
							<div class="input-block local-forms">
								<label >Department Description <span class="login-danger">*</span></label>
								<input name="department_description" id="department_description" class="form-control" type="text" >
								<span class="error" id="department_description_error"></span>
							</div>
						</div>
						
						<div class="col-12">
							<div class="doctor-submit text-end">
								<button type="button" class="btn btn-secondary me-2 cancel-form" data-bs-dismiss="modal">Cancel</button>
								<button name="save_department" type="submit" class="btn btn-primary submit-form me-2">Create Department</button>
							</div>
						</div>
					<!-- </div> -->
				</form>
			</div>
		</div>
	</div>
</div>

