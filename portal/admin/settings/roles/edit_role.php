<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('roles', 'can_edit')) {
    json_response("error", "Access Denied");
}

require_role([1]);

$_POST = filteration($_POST);

$fields = [];
$types  = '';
$values = [];

if(has_sub_permission("roles", "role_name", "can_edit") && isset($_POST['role_name'])) {
    $fields[]  = "role_name";
    $types    .= "s";
    $values[]  = $_POST['role_name'];
}

if(!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response("error", "Invalid CSRF Token", "", "");
}

$rules = [];
if(in_array("role_name", $fields)) {
    $rules['role_name'] = 'required';
}
$errors = validate($_POST, $rules);
if(!empty($errors)) {
    json_response("error", "", "", $errors);
}

if(in_array("role_name", $fields)) {
    $dup = checkDuplicateFields("roles", ["role_name" => $_POST['role_name']], ["id" => $_POST['role_id']], "AND");
    if($dup['status'] === "duplicate") {
        json_response("error", "", "", $dup['errors']);
    }
}

if(!empty($fields)) {
    $setparts = [];
    foreach($fields as $field) {
        $setparts[] = "$field = ?";
    }

    $values[] = $_POST['role_id']; 
    $types   .= "i";

    $sql = "UPDATE roles SET " . implode(", ", $setparts) . " WHERE id = ?";

    $result = update($sql, $values, $types);

    $result['message'] = ($result['status'] === "success") 
        ? "Role Updated Successfully." 
        : $result['message'];

    json_response($result['status'], $result['message'], "", "");
} else {
    json_response("error", "No fields available to update. Permission denied for all fields.");
}
?>
