<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "config.php";    // $conn procedural MySQLi connection
require_once "security.php";
require_once "session.php";
require_once "helpers.php";

// --------------------
// LOGIN FUNCTION
// --------------------
function login($email, $password)
{
    global $conn;

    // Prepare SQL
    $sql = "SELECT * FROM users WHERE email = ? OR phone = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ss", $email, $email);

    // Execute statement
    mysqli_stmt_execute($stmt);

    // Get result
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    // Close statement
    mysqli_stmt_close($stmt);

    // Check if user exists
    if (!$user) {
        return false;
    }

    // Verify password
    if (!password_verify($password, $user['password'])) {
        return false;
    }
    
    $_SESSION['APP_START'] = true;  // session variable


    // Store login session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role_id'] = $user['role_id'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['first_name'] = $user['first_name'];
    $_SESSION['last_name'] = $user['last_name'];
    
    return true;
}

// --------------------
// ROLE REDIRECT FUNCTION
// --------------------
function check_role($roleid)
{
    if ($roleid == '1') {
        return "http://localhost/hms/portal/admin/dashboard.php";
    } elseif ($roleid == '2') {
        return "http://localhost/hms/portal/doctor/dashboard.php";
    } elseif ($roleid == '3') {
        return "";
    } elseif ($roleid == '4') {
        return "";
    } elseif ($roleid == '5') {
        return "http://localhost/hms/portal/doctor/dashboard.php";
    }
}

// --------------------
// LOGOUT FUNCTION
// --------------------
function logout()
{
    session_unset();
    session_destroy();
    echo "<script>localStorage.removeItem('currentPage');</script>";

    js_redirect("../../public/page-login.php");
    exit;
}

// --------------------
// CHECK IF USER LOGGED IN
// --------------------
function is_logged_in()
{
    return isset($_SESSION['user_id']);
}
?>
