<?php
require_once "session.php";
require_once "auth.php";

function require_login()
{
    if (!is_logged_in()) {
        showalert("error", "Access Denied Please Login First");
        js_redirect('http://localhost/hms/public/page-login.php', 1500);
        exit;
    }
}
    
function require_role($allowed_roles = []) {
   
    require_login();

    $role = $_SESSION['role_id'];

    if (!in_array($role, $allowed_roles)) {
        showalert("error", "Access Denied You Are Not Authorize persion Please ReLogin");
        js_redirect('http://localhost/hms/portal/admin/dashboard.php?action=logout', 1500);
        exit();
    }
}



?>