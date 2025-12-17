<?php
function is_active() {
    if (!isset($_SESSION['user_id'])) {
        return [
            "active" => false,
            "status" => "no_user"
        ];
    }

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT status FROM users WHERE user_id = ? LIMIT 1";
    $result = select($sql, [$user_id], "i");

    if ($result['status'] === 'success' && $result['rows'] > 0) {
        $status = $result['data'][0]['status'];
        return [
            "active" => $status === 'active',
            "status" => $status
        ];
    }

    return [
        "active" => false,
        "status" => "not_found"
    ];
}
function has_permission($module_name, $action = 'can_view') {

    if (!isset($_SESSION['role_id'])) {
        return false;
    }

    $user = is_active();
    if (!$user['active']) {
        return false;
    }

    $role_id = $_SESSION['role_id'];

    $moduleSql = "SELECT module_id FROM modules WHERE module_name = ? LIMIT 1";
    $moduleRes = select($moduleSql, [$module_name], "s");

    if ($moduleRes['status'] !== 'success' || $moduleRes['rows'] == 0) {
        return false;
    }

    $module_id = $moduleRes['data'][0]['module_id'];

    $sql = "SELECT $action 
            FROM role_permissions 
            WHERE role_id = ? AND module_id = ? 
            LIMIT 1";

    $result = select($sql, [$role_id, $module_id], "ii");

    if ($result['status'] === 'success' && $result['rows'] > 0) {
        return ($result['data'][0][$action] == 1);
    }

    return false;
}


?>
