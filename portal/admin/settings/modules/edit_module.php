<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('modules', 'can_edit')) {
	json_response("error", "Access Denine");
	exit;
}

require_role([1]);
$_POST = filteration($_POST);

$rules = [
    'module_name' => 'required|max:20',
];

$errors = validate($_POST, $rules);

if(!empty($errors)) {
    json_response("error", "", "", $errors);
}

if(!verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid CSRF Token", "", "");
}

$module_id = $_POST['module_id'];
$module_name = $_POST['module_name'];


$dup = checkDuplicateFields("modules", ["module_name" => $module_name], ["module_id" => $module_id], "AND");

if($dup['status'] === "duplicate") {
    json_response("error", "", "", $dup['errors']);
}

$sql = "UPDATE modules SET 
    module_name  = ?
    WHERE module_id  = ?";

$values = [$module_name, $module_id];
$type = "si";

$result = update($sql, $values, $type);

$result['message'] = ($result['status'] === "success") 
    ? "module Updated Successfully." 
    : $result['message'];

json_response($result['status'], $result['message'], "", "");


?>