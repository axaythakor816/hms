<?php
require_once '../../../../core/init.php';

require_login();
$action = $_POST['action'];

if($action == 'roles') {
    
    $sql = "SELECT id, role_name FROM roles";
    $value = [];
    $type = "";
    $columnname = ["column_id" => "id", "column_name" => "role_name"];

    $result = checkselectdata(select($sql, $value, $value), $columnname);

    json_response($result['status'], $result['message'], $result['data'], "");
}

if($action == 'modules') {

    $sql = "SELECT module_id, module_name FROM modules";
    $value = [];
    $type = "";
    $columnname = ["column_id" => "module_id", "column_name" => "module_name"];

    $result = checkselectdata(select($sql, $value, $value), $columnname);

    json_response($result['status'], $result['message'], $result['data'], "");
}

?>