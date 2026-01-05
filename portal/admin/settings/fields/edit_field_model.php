<?php
require_once '../../../../core/init.php';

require_login();

if (!has_permission('fields', 'can_edit')) { 
    showalert("error", "Access Denied");
    exit;
}

require_role([1]);
?>

<div class="modal fade" id="editFieldModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit Field</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <form id="editfield_form">

                    <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="field_id" id="field_id" value=""> 
                    
                    <div class="row">
                        <!-- Module Select -->
                        <div class="col-md-12">
                            <div class="input-block local-forms">
                                <label>Module <span class="login-danger">*</span></label>
                                <select name="module_id" id="edit_module_id" class="form-control">
                                    <!-- options will be inserted dynamically via JS -->
                                </select>
                                <span class="error" id="edit_module_id_error"></span>
                            </div>
                        </div>

                        <!-- Field Name -->
                        <div class="col-md-12">
                            <div class="input-block local-forms">
                                <label>Field Name <span class="login-danger">*</span></label>
                                <input type="text" name="field_name" id="edit_field_name" class="form-control" placeholder="e.g. first_name, age">
                                <span class="error" id="edit_field_name_error"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="text-end mt-4">
                        <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit"
                                name="update_field"
                                class="btn btn-primary">
                            Update Field
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
