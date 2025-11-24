<?php
// ------------------------------------
// INIT FILE – RUNS ON EVERY PAGE
// ------------------------------------

// 1. Start Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Load ENV / Config
require_once __DIR__ . '/env.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/permissions.php';
require_once __DIR__ . '/middleware.php';


// 4. Load All Core Files
require_once __DIR__ . '/helpers.php';

require_once __DIR__ . '/response.php';
require_once __DIR__ . '/crud.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/middleware.php';
require_once __DIR__ . '/permissions.php';

// 5. Timezone
date_default_timezone_set('Asia/Kolkata');

// 6. Error Reporting
if (ENV_MODE === "dev") {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
} else {
    error_reporting(0);
    ini_set("display_errors", 0);
}
?>
