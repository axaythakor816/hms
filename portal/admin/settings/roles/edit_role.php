<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('roles', 'can_edit')) {
	json_response("error", "Access Denine");
	exit;
}

require_role([1]);
$_POST = filteration($_POST);

$rules = [
    'role_name' => 'required',
];

$errors = validate($_POST, $rules);

if(!empty($errors)) {
    json_response("error", "", "", $errors);
}

if(!verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid CSRF Token", "", "");
}

$role_id = $_POST['role_id'];
$role_name = $_POST['role_name'];


$dup = checkDuplicateFields("roles", ["role_name" => $role_name], ["id" => $role_id], "AND");

if($dup['status'] === "duplicate") {
    json_response("error", "", "", $dup['errors']);
}

$sql = "UPDATE roles SET 
    role_name  = ?
    WHERE id  = ?";

$values = [$role_name, $role_id];
$type = "si";

$result = update($sql, $values, $type);

$result['message'] = ($result['status'] === "success") 
    ? "Role Updated Successfully." 
    : $result['message'];

json_response($result['status'], $result['message'], "", "");


?>