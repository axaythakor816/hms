<?php
require_once '../../../../core/init.php';

require_login();

if (!has_permission('modules', 'can_add')) {
    showalert("error", "Access Denied");
    exit;
}

require_role([1]);
?>

<div class="modal fade" id="addModuleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Add Module</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <form id="addmodule_form">

                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

                    <div class="row">

                        <!-- Module Name -->
                        <?php if(has_sub_permission("modules", "module_name", "can_add")): ?>
                        <div class="col-md-12">
                            <div class="input-block local-forms">
                                <label>Module Name <span class="login-danger">*</span></label>
                                <input type="text"
                                       name="module_name"
                                       id="module_name"
                                       class="form-control"
                                       placeholder="e.g. Patients, Appointments">
                                <span class="error" id="module_name_error"></span>
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
                                name="save_module"
                                class="btn btn-primary">
                            Save Module
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
