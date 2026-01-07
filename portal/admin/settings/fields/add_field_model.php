<?php
require_once '../../../../core/init.php';

require_login();

if (!has_permission('modules', 'can_add')) {
    showalert("error", "Access Denied");
    exit;
}

require_role([1]);

?>

<div class="modal fade" id="addFieldModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Add Field</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <form id="addfield_form">

                    <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo csrf_token(); ?>">

                    <div class="row">
                        <!-- Module Select -->
                        <?php if(has_sub_permission("fields", "module_id", "can_add") && has_sub_permission("fields", "field_name", "can_add")): ?>
                        <div class="col-md-12">
                            <div class="input-block local-forms">
                                <label>Module <span class="login-danger">*</span></label>
                                <select name="module_id" id="module_id" class="form-control">
                                    <!-- option inserted dynamically -->
                                </select>
                                <span class="error" id="module_id_error"></span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <!-- Field Name -->
                        <?php if(has_sub_permission("fields", "module_id", "can_add") && has_sub_permission("fields", "field_name", "can_add")): ?>
                        <div class="col-md-12">
                            <div class="input-block local-forms">
                                <label>Field Name <span class="login-danger">*</span></label>
                                <input type="text" name="field_name" id="field_name" class="form-control" placeholder="e.g. first_name, age">
                                <span class="error" id="field_name_error"></span>
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
                                name="save_field"
                                class="btn btn-primary">
                            Save Field
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
