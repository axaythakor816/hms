<?php
require_once '../core/helpers.php';
require_once '../core/auth.php';
require_once '../core/permissions.php';
require_once '../core/db.php';

$rules = [
    'username' => 'required|username',
    'password' => 'required|min:6',
];

$errors = validate($_POST, $rules);

if(!empty($errors)) {
    json_response("error", "", "" , $errors);
}

$username = $_POST['username'];
$password = $_POST['password'];

if(!login($username, $password)) {
    json_response("error", "Invalid UserName Password", "", "");    
}

$status = is_active();

if (!$status['active']) {
    session_unset();
    session_destroy();
    json_response("error", "User " . ucfirst($status['status']), "", "");
    exit;
}

// json_response("success", "Login Successfull", $data, "");
json_response("success", "Login Successfull", "http://localhost/hms/portal/admin/dashboard.php", "");


?>