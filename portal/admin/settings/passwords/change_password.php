<?php
require_once '../../../../core/init.php';

require_login();

// if(!has_permission('passwords', 'can_edit')) {
// 	showalert("error", "Access Denied");
// 	exit;
// }

$_POST = filteration($_POST);

$rules = [
    'old_password' => 'required',
    'new_password' => 'required|password_strong',
    'confirm_password' => 'required|match:new_password'
];

$errors = validate($_POST, $rules);

if(!empty($errors)) {
    json_response("error", "", "", $errors);
}

if(!verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid Csrf Token");
}

$old_password = $_POST['old_password'];
$new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

$checksql = "SELECT password FROM users WHERE user_id = ?";
$checkvalue = [$_SESSION['user_id']];
$checktype = "i";

$checkresult = select($checksql, $checkvalue, $checktype);

if($checkresult['status'] == "error") {
    json_response($result['status'], "Query failed" . $checkresult['error'], "", "");
}

if(!password_verify($old_password, $checkresult['data'][0]['password'])) {
    json_response("error", "", "", ['old_password' => 'Incorrect Old Password']);
}

$sql = "UPDATE users SET password = ? WHERE user_id =?";
$value = [$new_password, $_SESSION['user_id']];
$type = "si";

$result = update($sql, $value, $type);

$result['message'] = ($result['status'] == "success") ? "Password Update Successfully." : $result['message'];

json_response($result['status'], $result['message']);

?>    