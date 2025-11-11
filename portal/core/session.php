<?php

// Prevent direct access
if (!defined('APP_START')) {
    die("Direct access not allowed");
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Session timeout (optional)
$timeout = 60 * 60; // 1 hour

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeout)) {
    session_unset();
    session_destroy();
}

$_SESSION['LAST_ACTIVITY'] = time();

// Prevent session fixation
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} else if (time() - $_SESSION['CREATED'] > 1800) {
    session_regenerate_id(true);
    $_SESSION['CREATED'] = time();
}
?>