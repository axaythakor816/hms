<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('manage users', 'can_edit')) {
	json_response("error", "Access Denied");
	exit;
}

require_role([1]);
$_POST = filteration($_POST);

$rules = [
    'first_name' => 'required|name|max:10',
    'last_name' => 'required|name|max:10',
    'email' => 'required|email',
    'phone' => 'required|mobile',
    // 'password' => 'required|password_strong',
    // 'confirm_password' => 'required|match:password',
    'role_id' => 'required',
    'gender' => 'required',
    'dob' => 'required|date',
    'status' => 'required',
];
$password   = trim($_POST['password'] ?? '');
$confirm_password = trim($_POST['confirm_password'] ?? '');

if($password !== "" || $confirm_password !== "") {
    $rules['password'] = 'required|password_strong';
    $rules['confirm_password'] = 'required|match:password';
}

$errors = validate($_POST, $rules);
if(!empty($errors)) {
    json_response("error", "", "", $errors);
}

if(!verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid CSRF Token", "", "");
}

$user_id = $_POST['user_id'];
$first_name = strtolower($_POST['first_name']);
$last_name = strtolower($_POST['last_name']);
$email = strtolower($_POST['email']);
$phone = $_POST['phone'];
if(!empty($password)) {
    $password = password_hash($password, PASSWORD_DEFAULT);
}
$role_id = $_POST['role_id'];
$gender = $_POST['gender'];
$dob = $_POST['dob'];
$status = $_POST['status'];
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

$sql_get_old_image = select("SELECT profile_image FROM users WHERE user_id = ?", [$user_id], "i");
if ($sql_get_old_image['status'] === 'success' && $sql_get_old_image['rows'] > 0) {
    $get_old_image = $sql_get_old_image['data'][0]['profile_image'];
}

if(!empty($password)) {
    $sql = "UPDATE users SET 
        first_name = ?,
        last_name = ?,
        email = ?,
        phone = ?,
        password = ?,
        role_id = ?,
        gender = ?,
        dob = ?,
        status = ?
        WHERE user_id = ?";

    $values = [$first_name, $last_name, $email, $phone, $password, $role_id, $gender, $dob, $status, $user_id];
    $type = "sssisisssi";
}else{
    $sql = "UPDATE users SET 
        first_name = ?,
        last_name = ?,
        email = ?,
        phone = ?,
        role_id = ?,
        gender = ?,
        dob = ?,
        status = ?
        WHERE user_id = ?";

    $values = [$first_name, $last_name, $email, $phone, $role_id, $gender, $dob, $status, $user_id];
    $type = "sssiisssi";
}

$result = update($sql, $values, $type);
if($result['status'] !== "success") {
    json_response($result['status'], $result['message']);
}

$doctor_check = select("SELECT * FROM doctors WHERE user_id = ?", [$user_id], "i");
$staff_check = select("SELECT * FROM staff WHERE user_id = ?", [$user_id], "i");
$patient_check = select("SELECT * FROM patients WHERE user_id = ?", [$user_id], "i");

$role_id = (int) $role_id; 

if ($doctor_check['rows'] > 0 && !in_array($role_id, [2, 3])) {
    deletefile(realpath('../../../assets/uploads/doctor/profile_image/') . '/' . $get_old_image);
    update("UPDATE doctors SET doctor_status = ? WHERE user_id = ?", ['suspended', $user_id], "si");
}

if (in_array($role_id, [2, 5]) && $staff_check['rows'] > 0) {
    deletefile(realpath('../../../assets/uploads/staff/profile_image/') . '/' . $get_old_image);
    update("UPDATE staff SET staff_status = ? WHERE user_id = ?", ['suspended', $user_id], "si");
}

switch($role_id) {
    case 2: 
        if($doctor_check['rows']>0){
            update("UPDATE doctors SET doctor_status=? WHERE user_id=?", ['active', $user_id], "si");
        } else {
            insert("INSERT INTO doctors (user_id, doctor_status) VALUES (?, ?)", [$user_id,'active'], "is");
        }
        break;

    case 3:
        if($patient_check['rows']>0){
            update("UPDATE patients SET patient_status=? WHERE user_id=?", ['admit', $user_id], "si");
        } else {
            insert("INSERT INTO patients (user_id, patient_status) VALUES (?, ?)", [$user_id,'admit'], "is");
        }
        break;

    case 4: 
        if($staff_check['rows']>0){
            update("UPDATE staff SET staff_status=? WHERE user_id=?", ['active', $user_id], "si");
        } else {
            insert("INSERT INTO staff (user_id, staff_status) VALUES (?, ?)", [$user_id,'active'], "is");
        }
        break;

    default: 
        if($staff_check['rows']>0){
            update("UPDATE staff SET staff_status=? WHERE user_id=?", ['active', $user_id], "si");
        } else {
            insert("INSERT INTO staff (user_id, staff_status) VALUES (?, ?)", [$user_id,'active'], "is");
        }
        break;
}

$result['message'] = ($result['status'] === "success") 
    ? "User Updated Successfully." 
    : $result['message'];

json_response($result['status'], $result['message'], "", "");
?>

<!-- no image insert -->
