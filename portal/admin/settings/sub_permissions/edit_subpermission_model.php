<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('sub permissions', 'can_edit')) {
	showalert("error", "Access Denied");
	exit;
}

require_role([1]);
?>
<div class="modal fade" id="editSubPermissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Sub Permission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <form id="editSubPermission_form">

					<input type="hidden" name="csrf_token" id="edit_csrf_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="sub_permission_id" id="edit_sub_permission_id" value="">

                    <div class="row">

                        <!-- Role -->
                        <?php if(has_sub_permission("sub permissions", "role_id", "can_edit") && has_sub_permission("sub permissions", "module_id", "can_edit") && has_sub_permission("sub permissions", "field_id", "can_edit")): ?>
                        <div class="col-md-4">
                            <div class="input-block local-forms">
                                <label>Role <span class="login-danger">*</span></label>
                                <select class="form-select form-control" name="role_id" id="edit_role_id">
                                    <!-- options insert dynamically -->
                                </select>
                                <span class="error" id="edit_role_id_error"></span>
                            </div>
                        </div>

                        <!-- Module -->
                        <div class="col-md-4">
                            <div class="input-block local-forms">
                                <label>Module <span class="login-danger">*</span></label>
                                <select name="module_id" id="edit_module_id" class="form-select form-control">
                                    <!-- options insert dynamically -->
                                </select>
                                <span class="error" id="edit_module_id_error"></span>
                            </div>
                        </div>

                        <!-- Field -->
                        <div class="col-md-4">
                            <div class="input-block local-forms">
                                <label>Field <span class="login-danger">*</span></label>
                                <select name="field_id" id="edit_field_id" class="form-select form-control">
                                    <!-- options insert dynamically based on selected module -->
                                </select>
                                <span class="error" id="edit_field_id_error"></span>
                            </div>
                        </div>

                        <!-- Permissions -->
                        <div class="col-md-12 mt-3">
                            <label>Permissions</label>
                            <div class="d-flex gap-4 mt-1">

                            <?php if(has_sub_permission("sub permissions", "can_view", "can_edit")) : ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="can_view" id="edit_can_view" value="1">
                                    <label class="form-check-label">Can View</label>
                                </div>
                            <?php endif;
                            if(has_sub_permission("sub permissions", "can_add", "can_edit")) : ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="can_add" id="edit_can_add" value="1">
                                    <label class="form-check-label">Can Add</label>
                                </div>
                            <?php endif;
                            if(has_sub_permission("sub permissions", "can_edit", "can_edit")) : ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="can_edit" id="edit_can_edit" value="1">
                                    <label class="form-check-label">Can Edit</label>
                                </div>
                            <?php endif;
                            if(has_sub_permission("sub permissions", "can_delete", "can_edit")) : ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="can_delete" id="edit_can_delete" value="1">
                                    <label class="form-check-label">Can Delete</label>
                                </div>
                            <?php endif; ?>

                            </div>
                        </div>
                        <?php endif; ?>

                    </div>

                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_sub_permission" class="btn btn-primary">Update Sub Permission</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
