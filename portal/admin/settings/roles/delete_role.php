<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('roles', 'can_delete')) {
	showalert("error", "Access Denine");
	exit;
}

require_role([1]);

$_POST = filteration($_POST);

if(!verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid CSRF Token", "", "");
}

$ids = explode(',', $_POST['role_id']);  

$ids = array_filter($ids);

if(empty($ids)) {
    json_response("error", "Invalid request!");
}

$placeholders = implode(',', array_fill(0, count($ids), '?'));
$type = str_repeat('i', count($ids));

$sql = "DELETE FROM roles WHERE id IN ($placeholders)";
$result = delete($sql, $ids, $type);

$result['message'] = ($result['status'] == "success") ? 
    "Role Deleted Successfully."
    : $result['message'];

json_response($result['status'], $result['message'], "", "");

?>
