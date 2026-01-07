<?php

require_once '../../../../core/init.php';

require_login();

if(!has_permission('sub permissions', 'can_view')) {
    json_response("error", "Access Denied");
    exit;
}

require_role([1]);

if(!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response("error", "Invalid CSRF Token");
    exit;
}

$page = filterInput($_POST['page'] ?? 1, "int");
$perPage = filterInput($_POST['perPage'] ?? 10, "int");
$search = filterInput($_POST['search'] ?? '', "string");
$sortColumn = filterInput($_POST['sortColumn'] ?? 'sub_permission_id', "string");
$sortOrder = filterInput($_POST['sortOrder'] ?? 'ASC', "string");
$type = filterInput($_POST['type'] ?? '', "string");

$page = $page ?: 1;
$perPage = ($perPage >= 1 && $perPage <= 100) ? $perPage : 10;
$offset = ($page - 1) * $perPage;

$selectfield = ['fp.sub_permission_id'];
$allowedCols = ['sub_permission_id'];
$searchablecol = [];

if(has_sub_permission('sub permissions', 'role_id', 'can_view')) {
    $selectfield[] = 'r.role_name';
    $allowedCols[] = 'role_name';
    $searchablecol[] = 'r.role_name';
}
if(has_sub_permission('sub permissions', 'module_id', 'can_view')) {
    $selectfield[] = 'm.module_name';
    $allowedCols[] = 'module_name';
    $searchablecol[] = 'm.module_name';
}
if(has_sub_permission('sub permissions', 'field_name', 'can_view')) {
    $selectfield[] = 'f.field_name';
    $allowedCols[] = 'field_name';
    $searchablecol[] = 'f.field_name';
}
if(has_sub_permission('sub permissions', 'can_view', 'can_view')) {
    $selectfield[] = 'fp.can_view';
    $allowedCols[] = 'can_view';
    $searchablecol[] = 'fp.can_view';
}
if(has_sub_permission('sub permissions', 'can_add', 'can_view')) {
    $selectfield[] = 'fp.can_add';
    $allowedCols[] = 'can_add';
    $searchablecol[] = 'fp.can_add';
}
if(has_sub_permission('sub permissions', 'can_edit', 'can_view')) {
    $selectfield[] = 'fp.can_edit';
    $allowedCols[] = 'can_edit';
    $searchablecol[] = 'fp.can_edit';
}
if(has_sub_permission('sub permissions', 'can_delete', 'can_view')) {
    $selectfield[] = 'fp.can_delete';
    $allowedCols[] = 'can_delete';
    $searchablecol[] = 'fp.can_delete';
}
if(has_sub_permission('sub permissions', 'created_at', 'can_view')) {
    $selectfield[] = 'fp.created_at';
    $allowedCols[] = 'created_at';
    $searchablecol[] = 'fp.created_at';
}
if(has_sub_permission('sub permissions', 'updated_at', 'can_view')) {
    $selectfield[] = 'fp.updated_at';
    $allowedCols[] = 'updated_at';
    $searchablecol[] = 'fp.updated_at';
}

if(!in_array($sortColumn, $allowedCols)) {
    $sortColumn = 'sub_permission_id';
}
$sortOrder = ($sortOrder === 'DESC') ? 'DESC' : 'ASC';

$sql = "SELECT " . implode(", ", $selectfield) . ", r.role_name, m.module_name, f.field_name 
        FROM field_permissions fp 
        LEFT JOIN roles r ON fp.role_id = r.id 
        LEFT JOIN fields f ON fp.field_id = f.field_id 
        LEFT JOIN modules m ON f.module_id = m.module_id 
        WHERE 1";

$whereValues = [];
$searchType = '';

if(!empty($search) && !empty($searchablecol)) {
    $orParts = [];
    foreach($searchablecol as $col) {
        $orParts[] = "$col LIKE ?";
        $whereValues[] = "%$search%";
        $searchType .= "s";
    }
    $sql .= " AND (" . implode(" OR ", $orParts) . ")";
}

$totalResult = select($sql, $whereValues, $searchType);
$total = $totalResult['rows'] ?? 0;
if($total === 0) {
    json_response("error", "No Data Available For This Filter.");
}

$sql .= " ORDER BY $sortColumn $sortOrder LIMIT ?, ?";
$values = array_merge($whereValues, [$offset, $perPage]);
$datatypes = $searchType . "ii";

$result = select($sql, $values, $datatypes);
if($result['status'] === 'error') {
    json_response("error", "Query failed: " . $result['error']);
}

foreach($result['data'] as &$row) {
    $row['role_name']   = isset($row['role_name']) ? ucwords(strtolower($row['role_name'])) : '';
    $row['module_name'] = isset($row['module_name']) ? ucwords(strtolower($row['module_name'])) : '';
    $row['field_name']  = isset($row['field_name']) ? ucwords(strtolower($row['field_name'])) : '';
    $row['can_view'] = isset($row['can_view']) ? getYesNoLabel($row['can_view']) : '';
    $row['can_add'] = isset($row['can_add']) ? getYesNoLabel($row['can_add']) : '';
    $row['can_edit'] = isset($row['can_edit']) ? getYesNoLabel($row['can_edit']) : '';
    $row['can_delete'] = isset($row['can_delete']) ? getYesNoLabel($row['can_delete']) : '';
    if(isset($row['created_at'])) $row['created_at'] = format_datetime($row['created_at']);
    if(isset($row['updated_at'])) $row['updated_at'] = format_datetime($row['updated_at']);
}

if(!empty($type)) {
    switch(strtolower($type)) {
        case 'csv':
            exportCSV($result['data'], "SubPermissions.csv");
            break;
        case 'txt':
            exportTXT($result['data'], "SubPermissions.txt");
            break;
        case 'pdf':
            exportPDF($result['data'], "SubPermissions.pdf");
            break;
        case 'xlsx':
            exportXLSX($result['data'], "SubPermissions.xlsx");
            break;
        default:
            json_response("error", "Invalid export type! Use csv, txt, pdf, or xlsx.");
    }
    exit;
}

?>
