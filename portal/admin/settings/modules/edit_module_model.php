<?php
require_once '../../../../core/init.php';

require_login();

if (!has_permission('modules', 'can_edit')) {
    showalert("error", "Access Denied");
    exit;
}

require_role([1]);
?>

<div class="modal fade" id="editModuleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit Module</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <form id="editmodule_form">

                    <!-- CSRF -->
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

                    <!-- Module ID (Important for Edit) -->
                    <input type="hidden" name="module_id" id="edit_module_id">

                    <div class="row">

                        <!-- Module Name -->
                        <?php if(has_sub_permission("modules", "module_name", "can_edit")): ?>
                        <div class="col-md-12">
                            <div class="input-block local-forms">
                                <label>Module Name <span class="login-danger">*</span></label>
                                <input type="text"
                                       name="module_name"
                                       id="edit_module_name"
                                       class="form-control"
                                       placeholder="e.g. Patients, Appointments">
                                <span class="error" id="edit_module_name_error"></span>
                            </div>
                        </div>
                        <?php endif; ?>

                    </div>

                    <!-- Buttons -->
                    <div class="text-end mt-4">
                        <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit"
                                name="update_module"
                                class="btn btn-primary">
                            Update Module
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
