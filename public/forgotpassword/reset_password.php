<?php
require_once '../../core/config.php';
require_once '../../core/helpers.php';
require_once '../../vendor/autoload.php';

$action = $_POST['action'];

// Verify token
if($action == "verify_token") {
        
    if (!isset($_POST['token']) || empty($_POST['token'])) {
        json_response("error",'Invalid request');
    }

    $token = $_POST['token'];
    $tokenHash = hash('sha256', $token);

    $stmt = mysqli_prepare(
        $conn,
        "SELECT user_id FROM users 
        WHERE reset_token_hash = ? 
        AND reset_token_expiry > NOW()"
    );

    if (!$stmt) {
        json_response("error", "Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $tokenHash);

    if(!mysqli_stmt_execute($stmt)) {
        json_response("error", "Execute failed: " . mysqli_stmt_error($stmt));
    }

    $result = mysqli_stmt_get_result($stmt);
    if(!$result) {
        json_response("error", "Get result failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) === 0) {
        json_response("error", "Invalid or expired reset link");
    }

    $user = mysqli_fetch_assoc($result);
    $user_id = $user['user_id']; 

    json_response("success", "", $user_id);

}
// new password created
elseif ($action == 'changepassword') {

    $rules = [
        'new_password' => 'required|password_strong',
        'confirm_password' => 'required|match:new_password'
    ];

    $errors = validate($_POST, $rules);

    if(!empty($errors)) {
        json_response("error", "", "", $errors);
    }

    $user_id = $_POST['user_id'];

    if(empty($user_id)) {
        json_response("error", "invalid Request");
    }

    $password = $_POST['new_password'] ?? '';

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare($conn, "UPDATE users SET password = ?, reset_token_hash = NULL, reset_token_expiry = NULL WHERE user_id = ?");

    if (!$stmt) {
        json_response("error","Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "si", $hashedPassword, $user_id);

    if (!mysqli_stmt_execute($stmt)) {
        json_response("error","Execute failed: " . mysqli_stmt_error($stmt));
    } else {
        json_response("success", "Password updated successfully.");
    }

    mysqli_stmt_close($stmt);
    
}else{
    json_response("error", "invalid Request");
}
?>