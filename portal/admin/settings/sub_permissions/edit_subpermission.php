<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('sub permissions', 'can_edit')) {
    json_response("error", "Access Denied");
    exit;
}

require_role([1]);

$_POST = filteration($_POST);

$sub_permission_id = $_POST['sub_permission_id'] ?? "";
$role_id = $_POST['role_id'] ?? "";
$field_id = $_POST['field_id'] ?? "";
$can_view = isset($_POST['can_view']) ? 1 : 0;
$can_add = isset($_POST['can_add']) ? 1 : 0;
$can_edit = isset($_POST['can_edit']) ? 1 : 0;
$can_delete = isset($_POST['can_delete']) ? 1 : 0;

$fields_to_update = [];
$values = [];
$types = '';
$rules = [];

if(!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response("error", "Invalid CSRF Token", "", "");
}

$has_role_permission = has_sub_permission("sub permissions", "role_id", "can_edit");
$has_field_permission = has_sub_permission("sub permissions", "field_id", "can_edit");

if($has_role_permission && $has_field_permission) {
    $fields_to_update[] = "role_id";
    $types .= "i";
    $values[] = $role_id;
    $rules['role_id'] = 'required';

    $fields_to_update[] = "field_id";
    $types .= "i";
    $values[] = $field_id;
    $rules['field_id'] = 'required';

    if(has_sub_permission("sub permissions", "can_view", "can_edit")) {
        $fields_to_update[] = "can_view";
        $types .= "i";
        $values[] = $can_view;
    }

    if(has_sub_permission("sub permissions", "can_add", "can_edit")) {
        $fields_to_update[] = "can_add";
        $types .= "i";
        $values[] = $can_add;
    }

    if(has_sub_permission("sub permissions", "can_edit", "can_edit")) {
        $fields_to_update[] = "can_edit";
        $types .= "i";
        $values[] = $can_edit;
    }

    if(has_sub_permission("sub permissions", "can_delete", "can_edit")) {
        $fields_to_update[] = "can_delete";
        $types .= "i";
        $values[] = $can_delete;
    }
}

$errors = validate($_POST, $rules);
if(!empty($errors)) {
    json_response("error", "", "", $errors);
}

if(in_array("role_id", $fields_to_update) && in_array("field_id", $fields_to_update)) {
    $dup = checkDuplicateFields(
        "field_permissions",
        ["role_id" => $role_id, "field_id" => $field_id],
        ["sub_permission_id" => $sub_permission_id],
        "AND"
    );

    if($dup['status'] === "duplicate") {
        json_response("error", "", "", $dup['errors']);
    }
}

if(!empty($fields_to_update)) {
    $set_clause = implode(" = ?, ", $fields_to_update) . " = ?";
    $values[] = $sub_permission_id;
    $types .= "i";

    $sql = "UPDATE field_permissions SET $set_clause WHERE sub_permission_id = ?";
    $result = update($sql, $values, $types);

    $result['message'] = ($result['status'] === "success") 
        ? "Sub Permission Updated Successfully." 
        : $result['message'];

    json_response($result['status'], $result['message'], "", "");
} else {
    json_response("error", "No fields available to update. Permission denied for all fields.");
}
?>
