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

$field_id = $_POST['field_id'];
$module = $_POST['module_id'];
$field = $_POST['field_name'];

$dup = checkDuplicateFields("fields", ["module_id" => $module, "field_name" => $field], [$field_id], "AND");

if($dup['status'] == "duplicate") {
    json_response("error", "", "", $dup['errors']);
}

$sql = "UPDATE fields SET module_id = ?, field_name = ? WHERE field_id = ?";
$values = [$module, $field, $field_id];
$datatypes = "isi";

$result = select($sql, $values, $datatypes);

$result['message'] = ($result['status'] == "success") ? "Field Updated Successfully" : $result['message'];

json_response($result['status'], $result['message']);
?>