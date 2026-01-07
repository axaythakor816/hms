<?php

require_once '../../../../core/init.php';

require_login();

if(!has_permission('manage users', 'can_add')) {
	json_response("error", "Access Denied");
	exit;
}

require_role([1, 6]);

$_POST = filteration($_POST);

if(!verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid CSRF Token", "", "");
}

$action = $_POST['action'] ?? '';

if($action == 'send_otp') {

    $rules = [
        "email" => "required|email"
    ];

    $errors = validate($_POST, $rules);

    if(!empty($errors)) {
        json_response("error", "", "", $errors);
    }
    $sendemail = strtolower($_POST['email']);

    $id = $_POST['user_id'] ?? "";
    
    if(!empty($id)) {
        $dup = checkDuplicateFields("users", ["email" => $sendemail], ["user_id" => $id]);
    }else{
        $dup = checkDuplicateFields("users", ["email" => $sendemail]);
    }

    if($dup['status'] === "duplicate") {
        json_response("error", "", "", $dup['errors']);
    }

    $otp = rand(100000, 999999);
    $expiry = date('Y-m-d H:i:s', strtotime('+5 minutes'));
    // $expiry = date('Y-m-d H:i:s', strtotime('+10 seconds'));

    $_SESSION['email_otp'] = $otp;
    $_SESSION['email_opt_expiry'] = $expiry;
    $_SESSION['email_verified'] = $sendemail;

    $htmlBody = "
        <p>Dear User,</p>
        <p>You are attempting to verify your email for your account on <strong>HMS System</strong>.</p>
        <p>Your One-Time Password (OTP) is:</p>
        <h2 style='color: #1a73e8;'>$otp</h2>
        <p>This OTP is valid for the next 5 minutes. Please do not share it with anyone.</p>
        <hr>
        <p style='font-size: 12px; color: #888;'>If you did not request this verification, please ignore this email or contact our support team.</p>
        <p style='font-size: 12px; color: #888;'>© 2025 HMS System. All rights reserved.</p>
        ";

    $plainBody = "Dear User,

        You are attempting to verify your email for your account on HMS System.

        Your One-Time Password (OTP) is: $otp

        This OTP is valid for the next 5 minutes. Please do not share it with anyone.

        If you did not request this verification, please ignore this email or contact our support team.

        © 2025 HMS System. All rights reserved.";

    $mail = new PHPMailer\PHPMailer\PHPMailer();

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'axaythakarda816@gmail.com';       
        $mail->Password = 'erhx sedf ghrm uekf'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('axaythakarda816@gmail.com', 'HMS Support');
        $mail->addAddress($sendemail);

        $mail->isHTML(true);
        $mail->Subject = 'Email Verification OTP';
        $mail->Body = $htmlBody;
        $mail->AltBody = $plainBody;

        $mail->send();
    } catch (Exception $e) {
    json_response("error", "Unable to send OTP email. Please try again later.");
    }

    json_response("success", "OTP has been sent to your email. Please check your inbox.");
}

if($action == "verify_otp") {
    $rules = [
        "otp" => "required|digits:6"
    ];

    $errors = validate($_POST, $rules);

    if(!empty($errors)) {
        json_response("error", "", "", $errors);
    }

    $userOtp = $_POST['otp'];
    
    if(!isset($_SESSION['email_otp']) || !isset($_SESSION['email_opt_expiry'])) {
        json_response("error", "No OTP found. Please request a new OTP.");
    }

    $sessionOtp = $_SESSION['email_otp'];
    $expiry = new DateTime($_SESSION['email_opt_expiry']);
    $now = new DateTime();

    if($now > $expiry) {
        unset($_SESSION['email_otp']);
        unset($_SESSION['email_opt_expiry']);
        json_response("error", "The OTP has expired.");
    }

    if($userOtp != $sessionOtp) {
        json_response("error", "Invalid OTP. Please try again.");
    }

    unset($_SESSION['email_otp']);
    unset($_SESSION['email_opt_expiry']);
    $veryfiedemail = $_SESSION['email_verified'];
    json_response("success", "Email verification successfully.", $veryfiedemail);

}
?>