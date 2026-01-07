<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('modules', 'can_edit')) {
    json_response("error", "Access Denied");
    exit;
}

require_role([1]);

$_POST = filteration($_POST);

$fields = [];
$types  = '';
$values = [];

if(has_sub_permission("modules", "module_name", "can_edit") && isset($_POST['module_name'])) {
    $fields[]  = "module_name";
    $types    .= "s";
    $values[]  = $_POST['module_name'];
}

if(!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response("error", "Invalid CSRF Token", "", "");
}

$rules = [];
if(in_array("module_name", $fields)) {
    $rules['module_name'] = 'required|max:20';
}

$errors = validate($_POST, $rules);
if(!empty($errors)) {
    json_response("error", "", "", $errors);
}

if(in_array("module_name", $fields)) {
    $dup = checkDuplicateFields("modules",["module_name" => $_POST['module_name']], ["module_id" => $_POST['module_id']], "AND");
    if($dup['status'] === "duplicate") {
        json_response("error", "", "", $dup['errors']);
    }
}

if(!empty($fields)) {
    $setparts = [];
    foreach($fields as $field) {
        $setparts[] = "$field = ?";
    }

    $values[] = $_POST['module_id'];
    $types   .= "i";

    $sql = "UPDATE modules SET " . implode(", ", $setparts) . " WHERE module_id = ?";

    $result = update($sql, $values, $types);

    $result['message'] = ($result['status'] === "success") ? "Module Updated Successfully." : $result['message'];

    json_response($result['status'], $result['message'], "", "");
} else {
    json_response("error", "No fields available to update. Permission denied for all fields.");
}
?>
