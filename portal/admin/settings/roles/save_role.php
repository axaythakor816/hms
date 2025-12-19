<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('roles', 'can_add')) {
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

$role = $_POST['role_name'];

$dup = checkDuplicateFields("roles", ["role_name" => $role], '', "OR");

if($dup['status'] === "duplicate") {
    json_response("error", "", "", $dup['errors']);
}

$query = "INSERT INTO roles (role_name) VALUES (?)";
$types = "s";
$values = [$role];

$result = insert($query, $values, $types);

$result['message'] = ($result['status'] === "success") 
    ? "Role Created Successfully." 
    : $result['message'];

json_response($result['status'], $result['message'], "", "");
?>