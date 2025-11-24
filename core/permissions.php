<?php

require_once __DIR__ . '/../config/database.php';

function has_permission($module, $action = 'can_view')
{
    global $conn;

    if (!isset($_SESSION['role_id'])) {
        return false;
    }

    $role = $_SESSION['role_id'];

    $sql = "SELECT $action FROM role_permissions 
            WHERE role_id = ? AND module = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $role, $module);
    $stmt->execute();

    $res = $stmt->get_result()->fetch_assoc();
    return ($res && $res[$action] == 1);
}
?>