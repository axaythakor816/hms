<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('fields', 'can_edit')) {
    json_response("error", "Access Denied");
}

require_role([1]);

$_POST = filteration($_POST);

$field_id   = $_POST['field_id']   ?? "";
$module_id  = $_POST['module_id']  ?? "";
$field_name = $_POST['field_name'] ?? "";

$rules = [];
$fields_to_update = [];
$values = [];
$types  = '';

if(!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response("error", "Invalid CSRF Token");
}

$has_module_permission = has_sub_permission("fields", "module_id", "can_edit");
$has_field_permission  = has_sub_permission("fields", "field_name", "can_edit");

if($has_module_permission && $has_field_permission) {
    $fields_to_update[] = "module_id";
    $types   .= "i";
    $values[] = $module_id;
    $rules['module_id'] = 'required';
}

if($has_field_permission && $has_field_permission) {
    $fields_to_update[] = "field_name";
    $types   .= "s";
    $values[] = $field_name;
    $rules['field_name'] = 'required|min:2|max:30';
}

$errors = validate($_POST, $rules);
if(!empty($errors)) {
    json_response("error", "", "", $errors);
}

if(in_array("module_id", $fields_to_update) && in_array("field_name", $fields_to_update)) {
    $dup = checkDuplicateFields("fields", ["module_id" => $module_id, "field_name" => $field_name], [$field_id], "AND");
    if($dup['status'] === "duplicate") {
        json_response("error", "", "", $dup['errors']);
    }
}

if(!empty($fields_to_update)) {
    $set_clause = implode(" = ?, ", $fields_to_update) . " = ?";
    $values[] = $field_id; 
    $types   .= "i";

    $query = "UPDATE fields SET $set_clause WHERE field_id = ?";
    $result = update($query, $values, $types);

    $result['message'] = ($result['status'] === "success") 
        ? "Field Updated Successfully." 
        : $result['message'];

    json_response($result['status'], $result['message']);
} else {
    json_response("error", "No fields available to update. Permission denied for all fields.");
}
?>
