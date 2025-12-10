<?php
require_once '../../../core/init.php';
require_login();	

if(!has_permission('departments', 'can_edit')) {
	showalert("error", "Access Denied");
	exit;
}
?>

<div class="modal fade" id="editDepartmentModal" tabindex="-1" aria-labelledby="editDepartmentLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editDepartmentLabel">Edit Department</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>					
			</div>

			<div class="modal-body">
				<form id="editdepartment_form" action="#" method="POST">

					<input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
					<input type="hidden" name="department_id" id="edit_department_id">

					<div class="col-12">
						<div class="form-heading">
							<h4>Edit Department</h4>
						</div>
					</div>

					<div class="col-12">  
						<div class="input-block local-forms">
							<label>Department Name <span class="login-danger">*</span></label>
							<input name="department_name" id="edit_department_name" class="form-control" type="text" placeholder="Enter Department Name">
							<span class="error" id="edit_department_name_error"></span>
						</div>
					</div>

					<div class="col-12">  
						<div class="input-block local-forms">
							<label>Department Head <span class="login-danger">*</span></label>

							<select name="department_head_id" id="edit_department_head_id" class="form-select">
								<option value="">Select Department Head</option>
								<option value="1">Dr. A. Patil</option>
								<option value="2">Dr. R. Sharma</option>
								<option value="3">Dr. Neha Vyas</option>
								<option value="4">Dr. Kiran Patel</option>
							</select>

							<span class="error" id="edit_department_head_id_error"></span>
						</div>
					</div>


					<div class="col-12">  
						<div class="input-block local-forms">
							<label>Department Description <span class="login-danger">*</span></label>

							<textarea name="department_description" id="edit_department_description" class="form-control" rows="3" maxlength="300" placeholder="Enter department description (max 300 characters)"></textarea>
							
							<small class="text-muted">
								<span id="edit_desc_count">0</span>/300 characters used
							</small>

							<span class="error" id="edit_department_description_error"></span>
						</div>
					</div>
					
					<div class="col-12">
						<div class="doctor-submit text-end">
							<button type="button" class="btn btn-secondary cancel-form me-2" data-bs-dismiss="modal">Cancel</button>
							<button name="update_department" type="submit" class="btn btn-primary">Update Department</button>
						</div>
					</div>

				</form>
			</div>

		</div>
	</div>
</div>
