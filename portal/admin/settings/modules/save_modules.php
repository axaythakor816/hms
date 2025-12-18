<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('modules', 'can_add')) {
    showalert("error", "Access Denine");
    exit;
}

require_role([1]);

$_POST = filteration($_POST);

$rules = [
    'module_name' => 'required|max:20'
];

$errors = validate($_POST, $rules);

if(!empty($errors)) {
    json_response("error", "", "", $errors);
}

if(!verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid CSRF Token", "", "");
}

$module = strtolower($_POST['module_name']);

$dup = checkDuplicateFields("modules", ["module_name" => $module]);

if($dup['status'] === "duplicate") {
    json_response("error", "", "", $dup['errors']);
}

$query = "INSERT INTO modules (module_name) VALUES (?)";
$types = "s";
$values = [$module];

$result = insert($query, $values, $types);

$result['message'] = ($result['status'] === "success") 
    ? "Module Created Successfully." 
    : $result['message'];

json_response($result['status'], $result['message'], "", "");
?>