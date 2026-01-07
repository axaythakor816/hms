<?php
require_once '../../../../core/init.php';

require_login();
if(!has_permission("sub permissions", "can_add")) {
    json_response("error", "Access Denied");
}
$action = $_POST['action'];

require_role([1]);

if(!isset($_POST['csrf_token']) || !verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid CSRF Token");
}

if($action == 'get_roles') {
    
    $sql = "SELECT id, role_name FROM roles";
    $value = [];
    $type = "";
    $columnname = ["column_id" => "id", "column_name" => "role_name"];

    $result = checkselectdata(select($sql, $value, $type), $columnname);

    json_response($result['status'], $result['message'], $result['data'], "");
}

if($action == 'get_modules') {

    $sql = "SELECT module_id, module_name FROM modules";
    $value = [];
    $type = "";
    $columnname = ["column_id" => "module_id", "column_name" => "module_name"];

    $result = checkselectdata(select($sql, $value, $type), $columnname);

    json_response($result['status'], $result['message'], $result['data'], "");
}

if($action == 'get_fields') {

    $module_id = $_POST['module_id'] ?? '';

    $sql = "SELECT field_id, field_name FROM fields WHERE module_id = ?";
    $value = [$module_id];
    $type = "i";
    $columnname = ["column_id" => "field_id", "column_name" => "field_name"];

    $result = checkselectdata(select($sql, $value, $type), $columnname);

    json_response($result['status'], $result['message'], $result['data'], "");
}

?>