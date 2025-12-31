<?php

require_once '../../../core/init.php';

require_login();
if(!has_permission("doctors", "can_add")) {
    json_response("error", "Access Denied You Are Not Authorize Persion");	
	exit;
}

if(isset($_POST['action']) && $_POST['action'] == "count") {
    $desc = $_POST['bio'];
    $count = strlen($desc);
    json_response("success", "", $count, "");
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
    "password" => "required|password_strong|min:6|max:20",
    "confirm_password" => "required|match:password|min:6|max:20",
    "status" => "required",
    "doctor_status" => "required",
    "is_consultation_online" => "required|numeric",
    "two_fa_enabled" => "required|numeric",
    "profile_image" => "required|file:type:jpg,jpeg,png|max_size:20KB"
];

$errors = validate($_POST, $rules);

if(!empty($errors)) {
    json_response("error", "", "", $errors);
}
if(!verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid CSRF Token", "", "");
}
$_POST = filteration($_POST);

$first_name = strtolower($_POST['first_name']);
$middle_name = strtolower($_POST['middele_name']);
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
$password = $_POST['password'];
$status = $_POST['status'];
$doctor_status = $_POST['doctor_status'];
$is_consultation_online = $_POST['is_consultation_online'];
$two_fa_enabled = $_POST['two_fa_enabled'];

$dup = checkDuplicateFields("users", ["email" => $email, "phone" => $phone]);

if($dup['status'] === "duplicate") {
    json_response("error", "", "", $dup['errors']);
}

$profile_image = uploadfile("profile_image", "uploads/profile_images/", "", null, "", ['jpg', 'jpeg', 'png']);

if (empty($profile_image)) {
    json_response("error", "Image Uploading Error");
}


?>