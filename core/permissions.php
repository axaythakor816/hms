<?php

require_once __DIR__ . '/config.php';

function has_permission($module, $action = 'can_view') {
    global $conn;

    if (!isset($_SESSION['role_id'])) {
        return false;
    }

    $role = $_SESSION['role_id'];

    $sql = "SELECT $action FROM role_permissions WHERE role_id = ? AND module = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "is", $role, $module);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $permission);
    $result = mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return ($result && $permission == 1);
}
?>
