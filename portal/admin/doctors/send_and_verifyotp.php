<?php

require_once '../../../../core/init.php';

require_login();

if(!has_permission('manage users', 'can_add')) {
	json_response("error", "Access Denine");
	exit;
}

$_POST = filteration($_POST);

if(!verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid CSRF Token", "", "");
}

$action = $_POST['action'] ?? '';
if($action == 'check_user') {

    $rules = [
        "email" => "required|email",
        "phone" => "required|mobile"
    ];

    $errors = validate($_POST, $rules);

    if(!empty($errors)) {
        json_response("error", "", "", $errors);
    }
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $id = $_POST['user_id'] ?? "";
    
    if(!empty($id)) {
        $dup = checkDuplicateFields("users", ["email" => $email, "phone" => $phone], ["user_id" => $id]);
    }else{
        $dup = checkDuplicateFields("users", ["email" => $email, "phone" => $phone]);
    }

    if($dup['status'] === "duplicate") {
        json_response("success", "", "duplicate", $dup['errors']);
    }
    json_response("success","");
}elseif($action == 'send_otp') {

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

करना कैसे implement कर सकते हो।

1️⃣ Existing Logic Summary

आपका current code:

पहले users table में user create करता है।

उसके बाद role_id के हिसाब से related table में entry डालता है:

role_id = 2 → doctors

role_id = 3 → patients

role_id = 4 → staff

अगर role_id = 5 है तो कोई extra table नहीं बनता।

email duplicate check, validation और CSRF verify भी हो रहा है।

Doctor/Patient/Staff table में सिर्फ user_id और status डाल रहा है।

Limitations / Observations:

आप हमेशा पहले users table में create कर रहे हैं, फिर role-specific table में।

इसका मतलब अगर कोई direct doctor create करना चाहे तो पहले users entry compulsory है।

Doctor specific info जैसे specialty, years_experience, profile_image आदि अभी add नहीं हो रहे।

2️⃣ Requirement: Direct Doctor Creation

अब requirement ये है:

Scenario A: User पहले users table में already है → उसे doctor बनाना।

Scenario B: User table में नहीं है → Directly doctor create करना (user create + doctor table insert दोनों एक ही process में)।

3️⃣ Recommended Logic for Direct Doctor Creation
Step 1: Check if user exists
$user = getUserByEmail($email); // function to fetch user by email

if($user) {
    $user_id = $user['id'];
} else {
    // Create user
    $query = "INSERT INTO users (first_name, last_name, email, phone, password, role_id, gender, dob, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $types = "sssisisss";
    $values = [$first_name, $last_name, $email, $phone, $password, 2, $gender, $dob, 'active']; // role_id=2 for doctor
    $result = insert($query, $values, $types);

    if($result['status'] !== 'success') {
        json_response('error', 'User creation failed', '', '');
    }

    $user_id = $result['insert_id'];
}


ध्यान: अगर email already exist करता है तो duplicate error handle करना होगा।

Step 2: Insert Doctor Table
// Prepare doctor-specific data
$doctor_status = 'active'; 
$specialty = $_POST['specialty'];
$years_experience = $_POST['years_experience'];
$profile_image = uploadfile("profile_image", "uploads/profile_images/", "", null, "", ['jpg','jpeg','png']);

// Insert doctor info
$query = "INSERT INTO doctors (user_id, doctor_status, specialty, years_experience, profile_image) VALUES (?, ?, ?, ?, ?)";
$types = "isiss";
$values = [$user_id, $doctor_status, $specialty, $years_experience, $profile_image];

$insert_result = insert($query, $values, $types);

if($insert_result['status'] === 'success') {
    json_response('success', 'Doctor created successfully', $user_id, '');
} else {
    json_response('error', 'Doctor creation failed', '', '');
}

4️⃣ Key Points in Logic

user already exists → सिर्फ doctor table में insert करो।

user doesn't exist → पहले users table insert → फिर doctor table insert।

Doctor-specific fields (specialty, years_experience, profile_image, etc.) doctor table में ही store करो।

Email/phone duplicate check हमेशा पहले करें।

Role_id for doctor in users table should ideally be 2 (or whatever your convention is).

✅ Advantages

Flexible: existing user ko doctor bana sakte ho।

Direct creation: new user ko doctor bana sakte ho without multiple manual steps.

Doctor-specific info separate table mein safe store hota hai.

Agar आप चाहो तो मैं आपके existing save user code ko refactor karke direct doctor create functionality ke saath complete code ready बना दूँ, ताकि dono scenario ek hi function me handle ho jaye।

क्या मैं वो कर दूँ?

user already exists → सिर्फ doctor table में insert करो। agar user already exists hai or dusre roll ke table me exist hai to us table me se to status ko to susped karna padega na

बिलकुल, यही सही approach है। 😎

अगर कोई user already exists है और वो different role/table में है, तो logic कुछ ऐसा होना चाहिए:

1️⃣ Steps:

Check if user exists in users table by email/phone.

Check if user is already in doctor table:

अगर नहीं → insert doctor table entry।

Check if user is in another role table (patients, staff, etc.):

अगर हाँ → उस table में status change करें।

उदाहरण: staff_status = 'suspended', patient_status = 'inactive' आदि।

Update users.role_id to doctor (optional, depends on your logic).

2️⃣ Example Logic in PHP
$user = getUserByEmail($email);
if(!$user) {
    // Create new user
    $user_id = createUser($data); // function to insert in users table
} else {
    $user_id = $user['id'];

    // Check other role tables
    $otherRoles = [
        'patients' => 'patient_status',
        'staff' => 'staff_status'
    ];

    foreach($otherRoles as $table => $statusColumn) {
        $sql = "SELECT * FROM $table WHERE user_id = ?";
        $existing = fetchRow($sql, [$user_id]); // fetchRow = your helper function
        if($existing) {
            // Suspend old role
            $updateSql = "UPDATE $table SET $statusColumn = 'suspended' WHERE user_id = ?";
            executeQuery($updateSql, [$user_id]);
        }
    }
}

// Insert into doctor table if not exists
$doctorExists = fetchRow("SELECT * FROM doctors WHERE user_id = ?", [$user_id]);
if(!$doctorExists) {
    $query = "INSERT INTO doctors (user_id, doctor_status, specialty, years_experience, profile_image) VALUES (?, ?, ?, ?, ?)";
    $values = [$user_id, 'active', $specialty, $years_experience, $profile_image];
    insert($query, $values, "isiss");
}

3️⃣ Key Points:

Existing user → सिर्फ doctor table insert करना।

Other role table exist → उस table की status suspend/inactive करना।

Doctor table already exist → insert skip करो।

Optional: users.role_id update कर सकते हो अगर main role tracking चाहिए।

अगर चाहो तो मैं तुम्हारे existing save user code को modify करके यह complete doctor creation + role suspension logic ready बना दूँ।

क्या मैं ऐसा कर दूँ?

pa