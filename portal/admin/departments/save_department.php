<?php
require_once '../../../core/init.php';

require_login();

if(!has_permission('departments', 'can_add')) {
    json_response("error", "Access Denine");
}

$rules = [
    'department_name' => 'required|max:30',
    'department_description' => 'required|max:100',
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

// $query = "INSERT INTO departments (department_name, department_description) VALUES (?, ?)";
// $types = "ss";
// $values = [$department_name, $department_description];

// $result = insert($query, $values, $types);

json_response("success", "save", "", "");

// $result['message'] = ($result['status'] === "success") 
//     ? "Department Created Successfully." 
//     : $result['message'];

json_response($result['status'], $result['message'], "", "");
?>