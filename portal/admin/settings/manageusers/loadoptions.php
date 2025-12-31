<?php
require_once '../../../../core/init.php';

require_login();
if(!verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid CSRF Token", "", "");
}
$sql = "SELECT id, role_name FROM roles";
$value = [];
$type = "";
$columnname = ["column_id" => "id", "column_name" => "role_name"];

$result = checkselectdata(select($sql, $value, $value), $columnname);

json_response($result['status'], $result['message'], $result['data'], "");

?>