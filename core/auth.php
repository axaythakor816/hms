<?php
require_once "config.php";
require_once "security.php";
require_once "session.php";
require_once "helpers.php";

// LOGIN FUNCTION
function login($email, $password)
{
    global $conn;

    $sql = "SELECT * FROM users WHERE email = ? OR phone = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if (!$user) {
        return false;
    }

    if (!password_verify($password, $user['password'])) {
        return false;
    }

    // store login session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role_id'] = $user['role_id'];
    $_SESSION['user_email'] = $user['email'];

    return true;
}

function check_role($roleid) {
    if($roleid == '1') {
        return "http://localhost/hms/portal/admin/dashboard.php";
    }elseif($roleid == '2') {
        return "http://localhost/hms/portal/doctor/dashboard.php";
    }elseif($roleid == '3') {
        return "";
    }elseif($roleid == '4') {
        return "";
    }elseif($roleid == '5') {
        return "http://localhost/hms/portal/doctor/dashboard.php";
    }
}

// LOGOUT
function logout()
{
    session_start();
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

// CHECK IF USER LOGGED IN
function is_logged_in()
{
    return isset($_SESSION['user_id']);
}
?>