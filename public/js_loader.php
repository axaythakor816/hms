<?php
// Start session to check login
session_start();

// ---------------------------
// Access control
// ---------------------------
// Ensure user is logged in and is admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    // Not logged in or not admin → deny access
    http_response_code(403);
    exit("Access denied");
}

// ---------------------------
// Path to core/helper.js
// ---------------------------
$coreHelperPath = __DIR__ . '/../core/helper.js';

// Check if file exists
if (!file_exists($coreHelperPath)) {
    http_response_code(500);
    exit("JS file not found");
}

// ---------------------------
// Serve the JS file
// ---------------------------
header("Content-Type: application/javascript");
readfile($coreHelperPath);
exit;
