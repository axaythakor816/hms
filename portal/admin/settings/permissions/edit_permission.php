<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('permissions', 'can_edit')) {
	showalert("error", "Access Denine");
	exit;
}

require_role([1]);
$_POST = filteration($_POST);

$rules = [
    'role_id' => 'required',
    'module_id' => 'required',
];

$errors = validate($_POST, $rules);

if(!empty($errors)) {
    json_response("error", "", "", $errors);
}

if(!verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid CSRF Token", "", "");
}

$permision_id = $_POST['permission_id'];
$role_id = $_POST['role_id'];
$module = $_POST['module_id'];
$can_view = isset($_POST['can_view']) ? 1 : 0;
$can_add = isset($_POST['can_add']) ? 1 : 0;
$can_edit = isset($_POST['can_edit']) ? 1 : 0;
$can_delete = isset($_POST['can_delete']) ? 1 : 0;

$dup = checkDuplicateFields("role_permissions", ["role_id" => $role_id, "module_id" => $module], ["permission_id" => $permision_id], "AND");

if($dup['status'] === "duplicate") {
    json_response("error", "", "", $dup['errors']);
}

$sql = "UPDATE role_permissions SET 
    role_id  = ?,
    module_id = ?,
    can_view = ?,
    can_add = ?,
    can_edit = ?,
    can_delete = ?
    WHERE permission_id  = ?";

$values = [$role_id, $module, $can_view, $can_add, $can_edit, $can_delete, $permision_id];
$type = "iiiiiii";

$result = update($sql, $values, $type);

$result['message'] = ($result['status'] === "success") 
    ? "Permission Updated Successfully." 
    : $result['message'];

json_response($result['status'], $result['message'], "", "");

?>