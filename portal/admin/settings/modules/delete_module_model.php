<?php
require_once '../../../../core/init.php';

require_login();

if (!has_permission('modules', 'can_delete')) {
    showalert("error", "Access Denied");
    exit;
}

require_role([1]);
?>

<div id="deleteModuleModal" class="modal fade delete-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body text-center">

                <img src="../assets/img/sent.png" alt="" width="50" height="46">

                <h3 class="mt-3">Are you sure you want to delete this module?</h3>

                <p class="text-muted" id="delete_module_name_text">
                    <!-- Module name dynamically inserted -->
                </p>

                <form id="delete_module_form" method="POST">

                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="module_id" id="delete_module_id">

                    <div class="m-t-20">
                        <a href="#" class="btn btn-white" data-bs-dismiss="modal">
                            Close
                        </a>

                        <button name="delete_module" type="submit" class="btn btn-danger">
                            Delete
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
