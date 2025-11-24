<?php

require_once __DIR__ . "/../config/database.php";
require_once "session.php";
require_once "helpers.php";
require_once "security.php";


// LOGIN FUNCTION
function login($email, $password)
{
    global $conn;

    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
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