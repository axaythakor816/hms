<?php
require_once '../../../core/init.php';

require_login();

if(!has_permission("departments", "can_edit")) {
    json_response("error", "Access Denied");
}

if(isset($_POST['action']) && $_POST['action'] == "count") {
    $desc = $_POST['department_description'];
    $count = strlen($desc);
    json_response("success", "", $count, "");
}

$_POST = filteration($_POST);

$rules = [
    'department_name' => 'required|max:30',
    'department_head_id' => 'required',
    'department_description' => 'required|max:300',
];

$errors = validate($_POST, $rules);

if(!empty($errors)) {
    json_response("error", "", "", $errors);
}

if(!verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid CSRF Token", "", "");
}

$department_id = $_POST['department_id'];
$department_name = $_POST['department_name'];
$department_head_id = $_POST['department_head_id'];
$department_description = $_POST['department_description'];


$dup = checkDuplicateFields("departments", ["department_name" => $department_name], ['department_id' => $department_id]);

if($dup['status'] === "duplicate") {
    json_response("error", "", "", $dup['errors']);
}

$sql = "UPDATE departments SET 
    department_name = ?,
    department_head_id = ?,
    department_description = ?
    WHERE department_id = ?";

$values = [$department_name, $department_head_id, $department_description, $department_id];
$type = "ssii";

$result = update($sql, $values, $type);

// json_response("success", "savsdhsgbc brc kbusyfvsdfctfbuf d cktc rtfg e", "", ""); //testing

$result['message'] = ($result['status'] === "success") 
    ? "Department Updated Successfully." 
    : $result['message'];

json_response($result['status'], $result['message'], "", "");


?>