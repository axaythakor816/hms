<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('modules', 'can_add')) {
    json_response("error", "Access Denied");
    exit;
}

require_role([1]);

$_POST = filteration($_POST);

$fields = [];
$types  = '';
$values = [];

if(has_sub_permission("modules", "module_name", "can_add") && isset($_POST['module_name'])) {
    $fields[] = "module_name";
    $types   .= "s";
    $values[] = strtolower($_POST['module_name']); 
}

if(!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response("error", "Invalid CSRF Token", "", "");
}

$rules = [];
if(in_array("module_name", $fields)) $rules['module_name'] = 'required|max:20';

$errors = validate($_POST, $rules);

if(!empty($errors)) {
    json_response("error", "", "", $errors);
}

if(in_array("module_name", $fields)) {
    $dup = checkDuplicateFields("modules", ["module_name" => strtolower($_POST['module_name'])], '', 'OR');
    if($dup['status'] === "duplicate") {
        json_response("error", "", "", $dup['errors']);
    }
}

if(!empty($fields)) {
    $query = "INSERT INTO modules (" . implode(", ", $fields) . ") VALUES (" . implode(", ", array_fill(0, count($fields), "?")) . ")";
    
    $result = insert($query, $values, $types);

    $result['message'] = ($result['status'] === "success") 
        ? "Module Created Successfully." 
        : $result['message'];

    json_response($result['status'], $result['message'], "", "");
} else {
    json_response("error", "No fields available to insert. Permission denied for all fields.");
}
?>
