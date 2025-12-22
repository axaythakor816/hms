<?php
require_once '../../core/helpers.php';
require_once '../../core/auth.php';
require_once '../../core/permissions.php';
require_once '../../core/db.php';
require_once '../../vendor/autoload.php';

$rules = [
    'user_name' => 'required|user_name'
];

$errors = validate($_POST, $rules);

if(!empty($errors)) {
    json_response("error", "", "", $errors);
}

$_POST = filteration($_POST);
$username = $_POST['user_name'];

$genericMsg = "Password reset link will be sent to your email.";
$genericMsg = ucwords($genericMsg);
$checksql = "SELECT email FROM users WHERE email = ? OR phone = ?";
$checkvalues = [$username, $username];
$checktype = "ss";

$result = select($checksql, $checkvalues, $checktype);

if($result['status'] == 'error') {
    json_response($result['status'], $result['message'] . $result['error']);
}

if(!$result['data'] || $result['rows'] === 0) {
    json_response("error", "User Not Found.");
}

$fetchemail = $result['data'][0]['email'];

$token = bin2hex(random_bytes(32));
$tokenHash = hash('sha256', $token);
$expiry = date('Y-m-d H:i:s', strtotime('+30 minutes'));

$sql = "UPDATE users SET reset_token_hash = ?, reset_token_expiry = ? WHERE email = ?";
$values = [$tokenHash, $expiry, $fetchemail];
$types = "sss";

$updateRes = update($sql, $values, $types);

if($updateRes['status'] == 'error') {
    json_response($updateRes['status'], $updateRes['message'] . $updateRes['error']);
}

$resetLink = "http://localhost/hms/public/forgotpassword/reset_password_page.php?token=" . $token;

$htmlBody = "
    <p>Dear User,</p>
    <p>We received a request to reset your password for your account on <strong>Your Company/Project Name</strong>.</p>
    <p>Please click the link below to reset your password:</p>
    <p><a href='$resetLink' target='_blank' style='color: #1a73e8;'>Reset Your Password</a></p>
    <p>This link is valid for the next 30 minutes and can only be used once.</p>
    <p>If you did not request a password reset, please ignore this email or contact our support team immediately.</p>
    <p>Thank you,<br>Your Company/Project Name Team</p>
    <hr>
    <p style='font-size: 12px; color: #888;'>This is an automated message, please do not reply.</p>
";

$plainBody = "Dear User,

We received a request to reset your password for your account on Your Company/Project Name.

Please open the link below to reset your password:
$resetLink

This link is valid for the next 30 minutes and can only be used once.

If you did not request a password reset, please ignore this email or contact our support team immediately.

Thank you,
Your Company/Project Name Team

---
This is an automated message, please do not reply.";

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
    $mail->addAddress($fetchemail);

    $mail->isHTML(true);
    $mail->Subject = 'Password Reset Request';
    $mail->Body = $htmlBody;
    $mail->AltBody = $plainBody;

    $mail->send();
} catch (Exception $e) {
   json_response("error", "Unable to send email. Please try again later.");
}

json_response("success", $genericMsg);

?>     
