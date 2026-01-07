<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('roles', 'can_add')) {
    json_response("error", "Access Denied");
}

require_role([1]);

$_POST = filteration($_POST);

$fields = [];
$types  = '';
$values = [];

if(has_sub_permission("roles", "role_name", "can_add") && isset($_POST['role_name'])) {
    $fields[] = "role_name";
    $types   .= "s";
    $values[] = $_POST['role_name'];
}

if(!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response("error", "Invalid CSRF Token", "", "");
}

$rules = [];
if(in_array("role_name", $fields)) $rules['role_name'] = 'required';
$errors = validate($_POST, $rules);

if(!empty($errors)) {
    json_response("error", "", "", $errors);
}

if(in_array("role_name", $fields)) {
    $dup = checkDuplicateFields("roles", ["role_name" => $_POST['role_name']], '', "OR");
    if($dup['status'] === "duplicate") {
        json_response("error", "", "", $dup['errors']);
    }
}

if(!empty($fields)) {
    $query = "INSERT INTO roles (" . implode(", ", $fields) . ") VALUES (" . implode(", ", array_fill(0, count($fields), "?")) . ")";
    
    $result = insert($query, $values, $types);

    $result['message'] = ($result['status'] === "success") 
        ? "Role Created Successfully." 
        : $result['message'];

    json_response($result['status'], $result['message'], "", "");
} else {
    json_response("error", "No fields available to insert. Permission denied for all fields.");
}
?>
