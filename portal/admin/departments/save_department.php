<?php
require_once '../../../core/init.php';

require_login();

if(!has_permission('departments', 'can_add')) {
    json_response("error", "Access Denine");
}

if(isset($_POST['action']) && $_POST['action'] == "count") {
    $desc = $_POST['department_description'];
    $count = strlen($desc);
    json_response("success", "", $count, "");
}

$_POST = filteration($_POST);

$rules = [
    'department_name' => 'required|max:30',
    'department_description' => 'required|max:300',
];

$errors = validate($_POST, $rules);

if(!empty($errors)) {
    json_response("error", "", "", $errors);
}

if(!verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid CSRF Token", "", "");
}

$department_name = $_POST['department_name'];
$department_description = $_POST['department_description'];

$dup = checkDuplicateFields("departments", ["department_name" => $department_name, "department_description" => $department_description], null, "AND");

if($dup['status'] === "duplicate") {
    json_response("error", "", "", $dup['errors']);
}

$query = "INSERT INTO departments (department_name, department_description) VALUES (?, ?)";
$types = "ss";
$values = [$department_name, $department_description];

$result = insert($query, $values, $types);

// json_response("success", "savsdhsgbc brc kbusyfvsdfctfbuf d cktc rtfg e", "", ""); //testing

$result['message'] = ($result['status'] === "success") 
    ? "Department Created Successfully." 
    : $result['message'];

json_response($result['status'], $result['message'], "", "");
?>