<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('permissions', 'can_delete')) {
	json_response("error", "Access Denied");
	exit;
}

require_role([1]);

$_POST = filteration($_POST);

if(!verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid CSRF Token", "", "");
}

$ids = explode(',', $_POST['permission_id']);  
$ids = array_filter($ids);

if(empty($ids)) {
    json_response("error", "Invalid request!");
}

$superAdmins = [];
$idsToDelete = [];

foreach ($ids as $id) {
    if (is_superadmin('role_id', 'role_permissions', 'permission_id', $id)) {
        $superAdmins[] = $id;
    } else {
        $idsToDelete[] = $id;
    }
}

$result = [];
if (!empty($idsToDelete)) {
    $placeholders = implode(',', array_fill(0, count($idsToDelete), '?'));
    $type = str_repeat('i', count($idsToDelete));

    $sql = "DELETE FROM role_permissions WHERE permission_id IN ($placeholders)";
    $result = delete($sql, $idsToDelete, $type);
}

if (!empty($superAdmins)) {
    $superMsg = "Super Admin permissions are protected and cannot be deleted.";
    if (!empty($idsToDelete) && $result['status'] == "success") {
        $result['status'] = "success";
        $result['message'] = "permissions deleted successfully. ";
    } else {
        $result['status'] = "error";
        $result['message'] = $superMsg;
    }
} else {
    if (empty($result)) {
        $result['status'] = "error";
        $result['message'] = "No records deleted.";
    } else {
        $result['message'] = ($result['status'] == "success") ? 
            "Permission deleted successfully." 
            : $result['message'];
    }
}

json_response($result['status'], $result['message'], "", "");
?>
