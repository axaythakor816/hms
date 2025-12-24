<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('manage users', 'can_edit')) {
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

$user_id = $_POST['user_id'];
$first_name = strtolower($_POST['first_name']);
$last_name  = strtolower($_POST['last_name']);
$email      = strtolower($_POST['email']);
$phone      = $_POST['phone'];
$password   = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role_id    = $_POST['role_id'];
$gender     = $_POST['gender'];
$dob        = $_POST['dob'];
$status     = $_POST['status'];
$verified_email = strtolower($_POST['email_verified'] ?? '');

$dup = checkDuplicateFields("users", ["email" => $email, "phone" => $phone], ["user_id" => $user_id]);
if($dup['status'] === "duplicate") {
    json_response("error", "", "", $dup['errors']);
}

$checksql = "SELECT email FROM users WHERE user_id = ?";
$checkvalue = [$user_id];
$checktype = "i";

$checkresult = select($checksql, $checkvalue, $checktype);

$original_email_from_db = $checkresult['data'][0]['email'];

if ($email !== $original_email_from_db) {
    if (empty($verified_email) || !isset($_SESSION['email_verified']) || $_SESSION['email_verified'] != $email) {
        json_response("error", "", "unverified", ["email" => "Please verify your email."]);
    }
}

if (is_superadmin('role_id','users', 'user_id', $user_id)) {
    $result = select("SELECT role_id, status FROM users WHERE user_id = ?", [$user_id], "i");
    if($result['status'] === "success" && $result['rows'] > 0) {
        $role_id = $result['data'][0]['role_id'];
        $status  = $result['data'][0]['status'];
    }
}

$sql = "UPDATE users SET 
    first_name = ?,
    last_name  = ?,
    email      = ?,
    phone      = ?,
    password   = ?,
    role_id    = ?,
    gender     = ?,
    dob        = ?,
    status     = ?
    WHERE user_id = ?";

$values = [$first_name, $last_name, $email, $phone, $password, $role_id, $gender, $dob, $status, $user_id];
$type = "sssisisssi";

$result = update($sql, $values, $type);

$result['message'] = ($result['status'] === "success") 
    ? "User Updated Successfully." 
    : $result['message'];

json_response($result['status'], $result['message'], "", "");
?>
