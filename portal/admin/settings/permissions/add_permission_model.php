<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('permissions', 'can_add')) {
	showalert("error", "Access Denine");
	exit;
}

require_role([1]);

?>
<div class="modal fade" id="addpermissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add / Edit Permission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <form id="addpermission_form">

					<input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

                    <div class="row">

                        <!-- Role -->
                        <div class="col-md-6">
                            <div class="input-block local-forms">
                                <label>Role <span class="login-danger">*</span></label>
                                <select class="form-select form-control" name="role_id" id="role_id">
                                    <!-- options insert dynamically -->
                                </select>
                                <span class="error" id="role_id_error"></span>
                            </div>
                        </div>

                        <!-- Module -->
                        <div class="col-md-6">
                            <div class="input-block local-forms">
                                <label>Module <span class="login-danger">*</span></label>
                                <select name="module_id" id="module_id" class="form-select form-control">
                                    <!-- options insert dynamically -->
                                </select>
                                <span class="error" id="module_id_error"></span>
                            </div>
                        </div>

                        <!-- Permissions -->
                        <div class="col-md-12 mt-3">
                            <label>Permissions</label>
                            <div class="d-flex gap-4 mt-1">

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="can_view" id="can_view" value="1" checked>
                                    <label class="form-check-label">Can View</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="can_add" id="can_add" value="1">
                                    <label class="form-check-label">Can Add</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="can_edit" id="can_edit" value="1">
                                    <label class="form-check-label">Can Edit</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="can_delete" id="can_delete" value="1">
                                    <label class="form-check-label">Can Delete</label>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="save_permission" class="btn btn-primary">Create Permission</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
