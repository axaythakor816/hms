<?php
require_once '../../../../core/init.php';

require_login();

if (!has_permission('roles', 'can_edit')) {
    showalert("error", "Access Denied");
    exit;
}

require_role([1]);
?>

<div class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <form id="editrole_form">

                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="role_id" id="edit_role_id"> <!-- Existing role ID -->

                    <div class="row">

                        <!-- Role Name -->
                        <?php if(has_sub_permission("roles", "role_name", "can_edit")): ?>
                            <div class="col-md-12">
                            <div class="input-block local-forms">
                                <label>Role Name <span class="login-danger">*</span></label>
                                <input type="text" name="role_name" id="edit_role_name"
                                       class="form-control" placeholder="e.g. Admin, Doctor">
                                <span class="error" id="edit_role_name_error"></span>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Optional: Description -->
                        <!-- <div class="col-md-12 mt-3">
                            <div class="input-block local-forms">
                                <label>Description</label>
                                <textarea name="description" id="edit_description"
                                          class="form-control" rows="3" placeholder="Role description"></textarea>
                            </div>
                        </div> -->

                    </div>

                    <!-- Buttons -->
                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" name="update_role" class="btn btn-primary">
                            Update Role
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
