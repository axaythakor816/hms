<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('permissions', 'can_delete')) {
	showalert("error", "Access Denied");
	exit;
}

require_role([1, 6]);

?>
<div id="deletePermissionModal" class="modal fade delete-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body text-center">

                <img src="../assets/img/sent.png" alt="" width="50" height="46">

                <h3 class="mt-3">Are you sure you want to delete this permission?</h3>

                <p class="text-muted" id="delete_permission_name_text">
                    <!-- permission name dynamically inserted -->
                </p>

                <form id="delete_permission_form" method="POST">

                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="permission_id" id="delete_permission_id">

                    <div class="m-t-20">
                        <a href="#" class="btn btn-white" data-bs-dismiss="modal">Close</a>

                        <button name="delete_permission" type="submit" class="btn btn-danger">
                            Delete
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>