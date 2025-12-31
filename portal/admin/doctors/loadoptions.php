<?php
require_once '../../../core/init.php';

require_login();
if(!has_permission("doctors", "can_add")) {
    json_response("error", "Access Denied You Are Not Authorize Persion");	
	exit;
}
if(!verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid CSRF Token", "", "");
}
$sql = "SELECT department_id, department_name FROM departments";
$values = [];
$datatypes = "";
$columnname = ['column_id' => 'department_id', 'column_name' => 'department_name'];

$result = checkselectdata(select($sql, $values, $datatypes), $columnname);

json_response($result['status'], $result['message'], $result['data']);


?>