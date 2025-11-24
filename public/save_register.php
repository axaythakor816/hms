<?php
require_once '../core/config.php';
require_once '../core/helpers.php';
require_once '../core/db.php';


$rules = [
    'name' => 'required|name|min:3|max:20',
    'email' => 'required|email',
    'phone' => 'required|mobile',
    'password' => 'required|min:6|password_strong',
    'confirm_password' => 'required|match:password',
];

$errors = validate($_POST, $rules);

if(!empty($errors)) {
    json_response("error", "", "", $errors);
}


$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

$fields = [
    'email' => $email,
    'phone' => $phone, 
];

$dup = checkDuplicateFields("users", $fields);
if ($dup['status'] === "duplicate") {
    json_response("error", "", "", $dup['errors']);
}

$password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (first_name, email, phone, password) VALUES (?,?,?,?)";
$values = [$name, $email, $phone, $password];
$types = "ssss";
$result = insert($sql, $values, $types);

json_response(
    $result['status'],
    $result['message'],
    [],
    isset($result['error']) ? ["db_error" => $result['error']] : []

);





?>