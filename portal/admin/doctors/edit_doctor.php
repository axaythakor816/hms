<?php
require_once '../../../core/init.php';


require_login();

if(!has_permission('doctors', 'can_edit')) {
	json_response("error", "Access Denied");
	exit;
}

$rules = [
    "first_name" => "required|name|min:2|max:10",
    "middle_name" => "required|name|min:1|max:10",
    "last_name" => "required|name|min:2|max:10",
    "email" => "required|email|max:30",
    "phone" => "required|mobile",
    "specialty" => "required|min:2|max:20",
    "sub_specialty" => "required|min:2|max:20",
    "qualification" => "required|min:2|max:20",
    "department_id" => "required",
    "years_experience" => "required|numeric|min_value:0|max_value:99",
    "medical_license_no" => "required|min:5|max:20|regex:/^[A-Za-z0-9\/\-]+$/",
    "license_issue_date" => "required|date",
    "license_expiry_date" => "required|date",
    "consultation_fee" => "required|numeric|min_value:0",
    "available_days" => "required|min:3|max:50",
    "available_time_from" => "required",
    "available_time_to" => "required",
    "gender" => "required",
    "dob" => "required|date",
    "languages_spoken" => "required|min:2|max:25",
    "bio" => "required|min:10|max:300",
    "street" => "required|min:5|max:50",
    "city" => "required|name|min:2|max:20",
    "state" => "required|name|min:2|max:20",
    "pincode" => "required|regex:/^[0-9]{5,6}$/",
    // "password" => "required|password_strong|min:6|max:20",
    // "confirm_password" => "required|match:password|min:6|max:20",
    "status" => "required",
    "doctor_status" => "required",
    "is_consultation_online" => "required|numeric",
    "two_fa_enabled" => "required|numeric",
    // "profile_image" => "required|file:type:jpg,jpeg,png|max_size:2MB"
];
$password   = trim($_POST['password'] ?? '');
$confirm_password = trim($_POST['confirm_password'] ?? '');

if(!empty($password) || !empty($confirm_password)) {
    $rules['password'] = 'required|password_strong';
    $rules['confirm_password'] = 'required|match:password';
}
if(!empty($_FILES['profile_image']['name'])) {
    $rules['profile_image'] = 'required|file:type:jpg,jpeg,png|max_size:2MB';
}
$errors = validate($_POST, $rules);
if(!empty($errors)) {
    json_response("error", "", "", $errors);
}

if(!verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid CSRF Token", "", "");
}

$_POST = filteration($_POST);

$doctor_id = $_POST['doctor_id'];
$first_name = strtolower($_POST['first_name']);
$middle_name = strtolower($_POST['middle_name']);
$last_name = strtolower($_POST['last_name']);
$qualification = strtolower($_POST['qualification']);
$specialty = strtolower($_POST['specialty']);
$sub_specialty = strtolower($_POST['sub_specialty']);
$department_id = $_POST['department_id'];
$years_experience = $_POST['years_experience'];
$medical_license_no = $_POST['medical_license_no'];
$license_issue_date = $_POST['license_issue_date'];
$license_expiry_date = $_POST['license_expiry_date'];
$consultation_fee = $_POST['consultation_fee'];
$available_days = $_POST['available_days'];
$available_time_from = $_POST['available_time_from'];
$available_time_to = $_POST['available_time_to'];
$dob = $_POST['dob'];
$languages_spoken = strtolower($_POST['languages_spoken']);
$gender = strtolower($_POST['gender']);
$bio = strtolower($_POST['bio']);
$street = strtolower($_POST['street']);
$city = strtolower($_POST['city']);
$state = strtolower($_POST['state']);
$pincode = $_POST['pincode'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$status = $_POST['status'];
$doctor_status = $_POST['doctor_status'];
$is_consultation_online = $_POST['is_consultation_online'];
$two_fa_enabled = $_POST['two_fa_enabled'];
$duplicate_id = $_POST['duplicate_id'] ?? "";
$verified_email = strtolower($_POST['email_verified']);
if(!empty($password)) {
    $password = password_hash($password, PASSWORD_DEFAULT);
}

$duplicate_errors = [];

$user = select("SELECT user_id FROM doctors WHERE doctor_id = ?", [$doctor_id], "i");
if($user['status'] == "error") {
    json_response("error", $user['message']);
}elseif($user['rows'] == 0) {
    json_response("error", "User id Not Found");
}
$user_id = $user['data'][0]['user_id'];

$dup = checkDuplicateFields("users", ["email" => $email, "phone" => $phone], ["user_id" => $user_id]);
if($dup['status'] === "duplicate") {
    $duplicate_errors = array_merge($duplicate_errors, $dup['errors']);
}

$license_dup = checkDuplicateFields("doctors", ["medical_license_no" => $medical_license_no], ["doctor_id" => $doctor_id]);
if($license_dup['status'] === "duplicate") {
    $duplicate_errors = array_merge($duplicate_errors, $license_dup['errors']);
}

if(!empty($duplicate_errors)) {
    json_response("error", "","",$duplicate_errors);
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

if($doctor_status == "active") {
    $role_id = 2;
    $staff_check = select("SELECT * FROM staff WHERE user_id = ? ", [$user_id], "i");

    if ($staff_check['rows'] > 0) {
        $sql_get_old_image = select("SELECT profile_image FROM users WHERE user_id = ?", [$user_id], "i");
        $get_old_image = $sql_get_old_image['data'][0]['profile_image'];
        deletefile(realpath('../../assets/uploads/staff/profile_image/') . '/' . $get_old_image);
        update("UPDATE staff SET staff_status = ? WHERE user_id = ?", ['suspended', $user_id], "si");
    }

}else{
    $get_role_id = select("SELECT role_id FROM users WHERE user_id = ?", [$user_id], "i");
    $role_id = $get_role_id['data'][0]['role_id']; 
}

$profile_image = uploadfile("profile_image", "../../assets/uploads/doctor/profile_image/", "users", $user_id, "user_id", ['jpg', 'jpeg', 'png']);

if(!empty($password)) {
    $sql = "UPDATE users SET 
        profile_image = ?,
        first_name = ?,
        middle_name = ?,
        last_name = ?,
        email = ?,
        phone = ?,
        password = ?,
        role_id = ?,
        gender = ?,
        dob = ?,
        status = ?
        WHERE user_id = ?";

    $values = [$profile_image, $first_name, $middle_name, $last_name, $email, $phone, $password, $role_id, $gender, $dob, $status, $user_id];
    $type = "sssssssisssi";
}else{
    $sql = "UPDATE users SET 
        profile_image = ?,
        first_name = ?,
        middle_name = ?,
        last_name = ?,
        email = ?,
        phone = ?,
        role_id = ?,
        gender = ?,
        dob = ?,
        status = ?
        WHERE user_id = ?";

    $values = [$profile_image, $first_name, $middle_name, $last_name, $email, $phone, $role_id, $gender, $dob, $status, $user_id];
    $type = "ssssssisssi";
}

$result = update($sql, $values, $type);
if($result['status'] !== "success") {
    json_response($result['status'], $result['message']);
}

$doctorsql = "UPDATE doctors SET 
    specialty = ?, 
    sub_specialty = ?, 
    qualification = ?, 
    years_experience = ?, 
    department_id = ?, 
    medical_license_no = ?, 
    license_issue_date = ?, 
    license_expiry_date = ?, 
    consultation_fee = ?, 
    available_days = ?, 
    available_time_from = ?, 
    available_time_to = ?, 
    languages_spoken = ?, 
    bio = ?, 
    street = ?, 
    city = ?, 
    state = ?, 
    pincode = ?, 
    doctor_status = ?, 
    is_consultation_online = ?, 
    two_fa_enabled = ?
    WHERE doctor_id = ?"; 

$doctorvalues = [$specialty, $sub_specialty, $qualification, $years_experience, $department_id, $medical_license_no, $license_issue_date, $license_expiry_date, $consultation_fee, $available_days, $available_time_from, $available_time_to, $languages_spoken, $bio, $street, $city, $state, $pincode, $doctor_status, $is_consultation_online, $two_fa_enabled, $doctor_id];
$doctordatatypes = "sssiisssdssssssssssiii";

$doctorresult = update($doctorsql, $doctorvalues, $doctordatatypes);

$doctorresult['message'] = ($doctorresult['status'] === "success") 
    ? "Doctor Updated Successfully." 
    : $doctorresult['message'];

json_response($doctorresult['status'], $doctorresult['message'], "", "");
?>
