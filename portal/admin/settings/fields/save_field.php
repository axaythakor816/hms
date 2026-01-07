<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('fields', 'can_add')) {
    json_response("error", "Access Denied");
}

require_role([1]);

$_POST = filteration($_POST);

$module_id  = $_POST['module_id']  ?? "";
$field_name = $_POST['field_name'] ?? "";

$fields = [];
$types  = '';
$values = [];
$rules = [];

$has_module_permission = has_sub_permission("fields", "module_id", "can_add");
$has_field_permission  = has_sub_permission("fields", "field_name", "can_add");

if($has_module_permission && $has_field_permission) {
    $fields[] = "module_id";
    $types   .= "i";
    $values[] = $module_id;
    $rules['module_id'] = 'required';
}

if($has_module_permission && $has_field_permission) {
    $fields[] = "field_name";
    $types   .= "s";
    $values[] = $field_name;
    $rules['field_name'] = 'required|min:2|max:30';
}

if(!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response("error", "Invalid CSRF Token", "", "");
}

$errors = validate($_POST, $rules);
if(!empty($errors)) {
    json_response("error", "", "", $errors);
}

if(in_array("module_id", $fields) && in_array("field_name", $fields)) {
    $dup = checkDuplicateFields("fields", ["module_id"  => $module_id, "field_name" => $field_name], null, "AND");

    if($dup['status'] === "duplicate") {
        json_response("error", "", "", $dup['errors']);
    }
}

if(!empty($fields)) {
    $query = "INSERT INTO fields (" . implode(", ", $fields) . ") VALUES (" . implode(", ", array_fill(0, count($fields), "?")) . ")";
    $result = insert($query, $values, $types);

    $result['message'] = ($result['status'] === "success") 
        ? "Field Created Successfully." 
        : $result['message'];

    json_response($result['status'], $result['message']);
} else {
    json_response("error", "No fields available to insert. Permission denied for all fields.");
}
?>
