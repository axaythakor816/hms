<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('permissions', 'can_edit')) {
    json_response("error", "Access Denied");
    exit;
}

require_role([1, 6]);

$_POST = filteration($_POST);

$permission_id = $_POST['permission_id'] ?? "";
$role_id       = $_POST['role_id'] ?? "";
$module_id     = $_POST['module_id'] ?? "";
$can_view      = isset($_POST['can_view']) ? 1 : 0;
$can_add       = isset($_POST['can_add']) ? 1 : 0;
$can_edit      = isset($_POST['can_edit']) ? 1 : 0;
$can_delete    = isset($_POST['can_delete']) ? 1 : 0;

$fields_to_update = [];
$values = [];
$types  = '';
$rules  = [];

if(!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response("error", "Invalid CSRF Token", "", "");
}

$has_role_permission   = has_sub_permission("permissions", "role_id", "can_edit");
$has_module_permission = has_sub_permission("permissions", "module_id", "can_edit");

if($has_role_permission && $has_module_permission) {
    $fields_to_update[] = "role_id";
    $types             .= "i";
    $values[]           = $role_id;
    $rules['role_id']   = 'required';

    $fields_to_update[] = "module_id";
    $types             .= "i";
    $values[]           = $module_id;
    $rules['module_id'] = 'required';

    if(has_sub_permission("permissions", "can_view", "can_edit")) {
        $fields_to_update[] = "can_view";
        $types             .= "i";
        $values[]           = $can_view;
    }

    if(has_sub_permission("permissions", "can_add", "can_edit")) {
        $fields_to_update[] = "can_add";
        $types             .= "i";
        $values[]           = $can_add;
    }

    if(has_sub_permission("permissions", "can_edit", "can_edit")) {
        $fields_to_update[] = "can_edit";
        $types             .= "i";
        $values[]           = $can_edit;
    }

    if(has_sub_permission("permissions", "can_delete", "can_edit")) {
        $fields_to_update[] = "can_delete";
        $types             .= "i";
        $values[]           = $can_delete;
    }
}

$errors = validate($_POST, $rules);
if(!empty($errors)) {
    json_response("error", "", "", $errors);
}

if(in_array("role_id", $fields_to_update) && in_array("module_id", $fields_to_update)) {
    $dup = checkDuplicateFields(
        "role_permissions",
        ["role_id" => $role_id, "module_id" => $module_id],
        ["permission_id" => $permission_id],
        "AND"
    );

    if($dup['status'] === "duplicate") {
        json_response("error", "", "", $dup['errors']);
    }
}

if(!empty($fields_to_update)) {
    $set_clause = implode(" = ?, ", $fields_to_update) . " = ?";
    $values[]   = $permission_id;
    $types     .= "i";

    $sql = "UPDATE role_permissions SET $set_clause WHERE permission_id = ?";
    $result = update($sql, $values, $types);

    $result['message'] = ($result['status'] === "success") 
        ? "Permission Updated Successfully." 
        : $result['message'];

    json_response($result['status'], $result['message'], "", "");
} else {
    json_response("error", "No fields available to update. Permission denied for all fields.");
}
?>
