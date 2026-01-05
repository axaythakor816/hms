<?php
require_once '../../../../core/init.php';

require_login();
if(!has_permission("fields", "can_add")) {
    json_response("error", "Access Denied");
}

require_role([1]);
$rules = [
    "module_id" => "required",
    "field_name" => "required|min:2|max:30"
];

$errors = validate($_POST, $rules);

if(!empty($errors)) {
    json_response("error", "", "", $errors);
}
$_POST = filteration($_POST);

if(!isset($_POST['csrf_token']) || !verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid CSRF Token");
}

$module_id = $_POST['module_id'];
$field_name = $_POST['field_name'];

$dup = checkDuplicateFields("fields", ["module_id" => $module_id, "field_name" => $field_name], null, "AND");

if($dup['status'] == "duplicate") {
    json_response("error", "", "", $dup['errors']);
}

$sql = "INSERT INTO fields (module_id, field_name) VALUES (?, ?)";
$values = [$module_id, $field_name];
$datatypes = "is";

$result = insert($sql, $values, $datatypes);

$result['message'] = ($result['status'] == "success") ? "Field Created Successfully" : $result['message'];

json_response($result['status'], $result['message']);

?>