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
    "profile_image" => "required|file:type:jpg,jpeg,png|max_size:2MB"
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
$password = $_POST['password'];
$password = password_hash($password, PASSWORD_DEFAULT);

if(!empty($duplicate_id)) {
    $dup = checkDuplicateFields("users", ["phone" => $phone], ["user_id" => $duplicate_id]);
}else{
     $dup = checkDuplicateFields("users", ["phone" => $phone]);   
}

if($dup['status'] === "duplicate") {
    json_response("error", "", "", $dup['errors']);
}

if(!empty($duplicate_id)) {
    $license_dup = checkDuplicateFields("doctors", ["medical_license_no" => $medical_license_no], ["user_id" => $duplicate_id]);
}else{
    $license_dup = checkDuplicateFields("doctors", ["medical_license_no" => $medical_license_no]);   
}

if($license_dup['status'] === "duplicate") {
    json_response("error", "", "", $license_dup['errors']);
}

if(empty($verified_email) || $verified_email != $email || $_SESSION['email_verified'] != $email) {
    json_response("error", "", "unveryfied", ["email" => "Please verify your email."]);
}
$role_id = 2;
if(!empty($duplicate_id)) {
    if (is_superadmin('role_id','users', 'user_id', $duplicate_id)) {
        json_response("error", "This is a Super Admin. You cannot change this role.");
    }

    $doctor_check = select("SELECT * FROM doctors WHERE user_id = ?", [$duplicate_id], "i");
    $staff_check = select("SELECT * FROM staff WHERE user_id = ?", [$duplicate_id], "i");
    $patient_check = select("SELECT * FROM patients WHERE user_id = ?", [$duplicate_id], "i");

    $role_id = (int) $role_id; 

    if ($doctor_check['rows'] > 0 ) {
        json_response("error", "Doctor Already Exist");
    }

    if (in_array($role_id, [2, 5]) && $staff_check['rows'] > 0) {
        $image = select("SELECT profile_image FROM users WHERE user_id = ?",[$duplicate_id],"i");

        if ($image['rows'] > 0 && !empty($image['data'][0]['profile_image'])) {
            $oldImage = $image['data'][0]['profile_image'];

            $deleteimage = deletefile("../../assets/uploads/staff/profile_image/" . $oldImage);
            if(!$deleteimage) {
                json_response("error", "image delete problem");
            }
        }

        update("UPDATE staff SET staff_status = ? WHERE user_id = ?", ['suspended', $duplicate_id], "si");

    }

    $profile_image = uploadfile("profile_image", "../../assets/uploads/doctor/profile_image/", "users", $duplicate_id, "user_id", ['jpg', 'jpeg', 'png']);

    if (empty($profile_image)) {
        json_response("error", "Image Uploading Error");
    }
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
    $values = [ $profile_image, $first_name, $middle_name, $last_name, $email, $phone, $password,$role_id, $gender, $dob, $status, $duplicate_id ];
    $datatypes = "sssssssisssi";
    $result = update($sql, $values, $datatypes);
    $final_id = $duplicate_id;

}else{
    $profile_image = uploadfile("profile_image", "../../assets/uploads/doctor/profile_image/", "", null, "", ['jpg', 'jpeg', 'png']);

    if (empty($profile_image)) {
        json_response("error", "Image Uploading Error");
    }
    $sql = "INSERT INTO users (profile_image, first_name, middle_name, last_name, email, phone, password, role_id, gender, dob, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $values = [ $profile_image, $first_name,$middle_name, $last_name, $email, $phone, $password, $role_id, $gender, $dob, $status ];
    $datatypes = "sssssssisss";
    $result = insert($sql, $values, $datatypes);
    $final_id = $result['insert_id'];
}

if($result['status'] == "error") {
    json_response($result['status'], $result['message']);
}

$doctorsql = "INSERT INTO doctors (user_id, specialty, sub_specialty, qualification, years_experience, department_id, medical_license_no, license_issue_date, license_expiry_date, consultation_fee, available_days, available_time_from, available_time_to, languages_spoken, bio, street, city, state, pincode, doctor_status, is_consultation_online, two_fa_enabled) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$doctorvalues = [ $final_id, $specialty, $sub_specialty, $qualification, $years_experience, $department_id, $medical_license_no, $license_issue_date, $license_expiry_date, $consultation_fee, $available_days, $available_time_from, $available_time_to, $languages_spoken, $bio, $street, $city, $state, $pincode, $doctor_status, $is_consultation_online, $two_fa_enabled ];
$doctordatatypes = "isssiisssdssssssssssii";

$doctorresult = insert($doctorsql, $doctorvalues, $doctordatatypes);


$doctorresult['message'] = ($doctorresult['status'] === "success") 
    ? "User Created Successfully." 
    : $doctorresult['message'];

json_response($doctorresult['status'], $doctorresult['message'], "", "");


?>