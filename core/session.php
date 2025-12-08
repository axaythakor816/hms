<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Session timeout (optional)
$timeout = 30 * 60; // 30 minutes


if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeout)) {
    session_unset();
    session_destroy();
    echo "<script>localStorage.removeItem('currentPage');</script>";

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