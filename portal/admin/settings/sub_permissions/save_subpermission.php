<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('sub permissions', 'can_add')) {
    json_response("error", "Access Denied");
    exit;
}

require_role([1]);

$_POST = filteration($_POST);

$role_id  = $_POST['role_id']  ?? "";
$field_id = $_POST['field_id'] ?? "";
$can_view = isset($_POST['can_view'])   ? 1 : 0;
$can_add = isset($_POST['can_add'])    ? 1 : 0;
$can_edit = isset($_POST['can_edit'])   ? 1 : 0;
$can_delete = isset($_POST['can_delete']) ? 1 : 0;

$fields = [];
$types = '';
$values = [];
$rules = [];

$has_role_permission = has_sub_permission("sub permissions", "role_id", "can_add");
$has_field_permission = has_sub_permission("sub permissions", "field_id", "can_add");

if($has_role_permission && $has_field_permission) {
    $fields[] = "role_id";
    $types .= "i";
    $values[] = $role_id;
    $rules['role_id'] = 'required';
    $rules['module_id'] = 'required';

    $fields[] = "field_id";
    $types .= "i";
    $values[] = $field_id;
    $rules['field_id'] = 'required';

    if(has_sub_permission("sub permissions", "can_view", "can_add")) {
        $fields[] = "can_view";
        $types .= "i";
        $values[] = $can_view;
    }

    if(has_sub_permission("sub permissions", "can_add", "can_add")) {
        $fields[] = "can_add";
        $types .= "i";
        $values[] = $can_add;
    }

    if(has_sub_permission("sub permissions", "can_edit", "can_add")) {
        $fields[] = "can_edit";
        $types .= "i";
        $values[] = $can_edit;
    }

    if(has_sub_permission("sub permissions", "can_delete", "can_add")) {
        $fields[] = "can_delete";
        $types .= "i";
        $values[] = $can_delete;
    }
}

if(!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response("error", "Invalid CSRF Token", "", "");
}

$errors = validate($_POST, $rules);
if(!empty($errors)) {
    json_response("error", "", "", $errors);
}

if(in_array("role_id", $fields) && in_array("field_id", $fields)) {
    $dup = checkDuplicateFields(
        "field_permissions",
        ["role_id" => $role_id, "field_id" => $field_id],
        null,
        "AND"
    );

    if($dup['status'] === "duplicate") {
        json_response("error", "", "", $dup['errors']);
    }
}

if(!empty($fields)) {
    $query = "INSERT INTO field_permissions (" . implode(", ", $fields) . ") VALUES (" . implode(", ", array_fill(0, count($fields), "?")) . ")";
    $result = insert($query, $values, $types);

    $result['message'] = ($result['status'] === "success") 
        ? "Sub Permission Created Successfully." 
        : $result['message'];

    json_response($result['status'], $result['message'], "", "");
} else {
    json_response("error", "No fields available to insert. Permission denied for all fields.");
}
?>
