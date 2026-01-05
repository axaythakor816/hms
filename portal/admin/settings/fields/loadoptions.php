<?php

require_once '../../../../core/init.php';
require_login();

if(!has_permission('fields', 'can_view')) {
	json_response("error", "Access Denied");
	exit;
}

require_role([1]);

if(!isset($_POST['csrf_token']) || !verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid CSRF Token");
}

$get_options = "SELECT module_id, module_name FROM modules";
$values = [];
$datatypes = "";
$columnname = ['column_id' => 'module_id', 'column_name' => 'module_name'];

$res = checkselectdata(select($get_options, $values, $datatypes), $columnname);

json_response($res['status'], $res['message'], $res['data']);
?>