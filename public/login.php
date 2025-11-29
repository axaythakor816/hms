<?php
require_once '../core/helpers.php';
require_once '../core/auth.php';

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

$role = $_SESSION['role_id'];

$data = check_role($role);

json_response("success", "Login Successfull", $data, "");

?>