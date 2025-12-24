<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('manage users', 'can_add')) {
	json_response("error", "Access Denine");
	exit;
}

require_role([1]);

$_POST = filteration($_POST);

$rules = [
    'first_name' => 'required|name|max:10',
    'last_name' => 'required|name|max:10',
    'email' => 'required|email',
    'phone' => 'required|mobile',
    'password' => 'required|password_strong',
    'confirm_password' => 'required|match:password',
    'role_id' => 'required',
    'gender' => 'required',
    'dob' => 'required|date',
    'status' => 'required',

];

$errors = validate($_POST, $rules);

if(!empty($errors)) {
    json_response("error", "", "", $errors);
}

if(!verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid CSRF Token", "", "");
}

$first_name = strtolower($_POST['first_name']);
$last_name = strtolower($_POST['last_name']);
$email = strtolower($_POST['email']);
$phone = $_POST['phone'];
$password = $_POST['password'];
$role_id = $_POST['role_id'];
$gender = $_POST['gender'];
$dob = $_POST['dob'];
$status = $_POST['status'];
$password = password_hash($password, PASSWORD_DEFAULT);
$verified_email = strtolower($_POST['email_verified']);

$dup = checkDuplicateFields("users", ["email" => $email, "phone" => $phone]);

if($dup['status'] === "duplicate") {
    json_response("error", "", "", $dup['errors']);
}

if(empty($verified_email) || $verified_email != $email || $_SESSION['email_verified'] != $email) {
    json_response("error", "", "unveryfied", ["email" => "Please verify your email."]);
}

$query = "INSERT INTO users (first_name, last_name, email, phone, password, role_id, gender, dob, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$types = "sssisisss";
$values = [$first_name, $last_name, $email, $phone, $password, $role_id, $gender, $dob, $status];

$result = insert($query, $values, $types);

if($result['status'] == "success") {
    unset($_SESSION['email_verified']);
}

$result['message'] = ($result['status'] === "success") 
    ? "User Created Successfully." 
    : $result['message'];

json_response($result['status'], $result['message'], "", "");
?>