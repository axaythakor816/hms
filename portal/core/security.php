<?php

// Prevent direct access
if (!defined('APP_START')) {
    define('APP_START', true);
}

function clean($value)
{
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

function clean_array($arr)
{
    foreach ($arr as $key => $value) {
        $arr[$key] = clean($value);
    }
    return $arr;
}

function csrf_token()
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
?>