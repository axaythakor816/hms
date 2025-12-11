<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Session timeout (optional)
$timeout = 30 * 60; // 30 minutes

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeout)) {
    echo "<script>localStorage.removeItem('currentPage');</script>";
    session_unset();
    session_destroy();
    js_redirect("http://localhost/hms/public/page-login.php");
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