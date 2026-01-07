<?php
require_once '../../../../core/init.php';

require_login();

if (!has_permission('roles', 'can_add')) {
    showalert("error", "Access Denied");
    exit;
}

require_role([1]);
?>

<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Add Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <form id="addrole_form">

                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <!-- <input type="hidden" name="role_id" id="role_id"> -->

                    <div class="row">

                        <!-- Role Name -->
                        <?php if(has_sub_permission("roles", "role_name", "can_add")): ?>
                        <div class="col-md-12">
                            <div class="input-block local-forms">
                                <label>Role Name <span class="login-danger">*</span></label>
                                <input type="text" name="role_name" id="role_name"
                                       class="form-control" placeholder="e.g. Admin, Doctor">
                                <span class="error" id="role_name_error"></span>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Buttons -->
                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" name="save_role" class="btn btn-primary">
                            Save Role
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
