<?php
require_once "session.php";
require_once "auth.php";

function require_login()
{
    if (!is_logged_in()) {
        header("Location: login.php");
        exit;
    }
}

function require_role($allowed_roles = [])
{
    if (!is_logged_in()) {
        header("Location: login.php");
        exit;
    }

    $role = $_SESSION['role_id'];

    if (!in_array($role, $allowed_roles)) {
        header("Location: /403.php");
        exit();
    }
}



?>