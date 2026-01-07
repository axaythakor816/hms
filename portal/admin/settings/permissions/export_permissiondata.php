<?php

require_once '../../../../core/init.php';

require_login();

if(!has_permission('permissions', 'can_view')) {
    json_response("error", "Access Denied");
    exit;
}

require_role([1, 6]);

if(!verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid CSRF Token");
    exit;
}

$page       = filterInput($_POST['page'], 'int');
$perPage    = filterInput($_POST['perPage'], 'int');
$search     = filterInput($_POST['search'], 'string');
$sortColumn = filterInput($_POST['sortColumn'], 'string');
$sortOrder  = filterInput($_POST['sortOrder'], 'string');
$type       = filterInput($_POST['type'], 'string');

$page    = $page ?: 1;
$perPage = ($perPage >= 1 && $perPage <= 100) ? $perPage : 10;
$offset  = ($page - 1) * $perPage;

$selectfield   = ['rp.permission_id'];
$allowedCols   = ['permission_id'];
$searchablecol = [];
if(has_sub_permission('permissions', 'role_id', 'can_view')) {
    $selectfield[]   = 'r.role_name';
    $allowedCols[]   = 'role_id';
}
if(has_sub_permission('permissions', 'module_id', 'can_view')) {
    $selectfield[]   = 'm.module_name';
    $allowedCols[]   = 'module_id';
}
if(has_sub_permission('permissions', 'can_view', 'can_view')) {
    $selectfield[]   = 'rp.can_view';
    $allowedCols[]   = 'can_view';
    $searchablecol[] = 'rp.can_view';
}
if(has_sub_permission('permissions', 'can_add', 'can_view')) {
    $selectfield[]   = 'rp.can_add';
    $allowedCols[]   = 'can_add';
    $searchablecol[] = 'rp.can_add';
}
if(has_sub_permission('permissions', 'can_edit', 'can_view')) {
    $selectfield[]   = 'rp.can_edit';
    $allowedCols[]   = 'can_edit';
    $searchablecol[] = 'rp.can_edit';
}
if(has_sub_permission('permissions', 'can_delete', 'can_view')) {
    $selectfield[]   = 'rp.can_delete';
    $allowedCols[]   = 'can_delete';
    $searchablecol[] = 'rp.can_delete';
}
if(has_sub_permission('permissions', 'created_at', 'can_view')) {
    $selectfield[]   = 'rp.created_at';
    $allowedCols[]   = 'created_at';
    $searchablecol[] = 'rp.created_at';
}
if(has_sub_permission('permissions', 'updated_at', 'can_view')) {
    $selectfield[]   = 'rp.updated_at';
    $allowedCols[]   = 'updated_at';
    $searchablecol[] = 'rp.updated_at';
}

if(!in_array($sortColumn, $allowedCols)) {
    $sortColumn = 'permission_id';
}
$sortOrder = ($sortOrder === 'DESC') ? 'DESC' : 'ASC';

$sql = "SELECT " . implode(", ", $selectfield) . ", r.role_name, m.module_name 
        FROM role_permissions rp 
        LEFT JOIN roles r ON rp.role_id = r.id 
        LEFT JOIN modules m ON rp.module_id = m.module_id 
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
$total = $totalResult['rows'];

if($total === 0) {
    json_response("error", "No Data Available For This Filter.");
}

$sql .= " ORDER BY $sortColumn $sortOrder LIMIT ?, ?";
$values = $whereValues;
$values[] = $offset;
$values[] = $perPage;
$datatypes = $searchType . "ii";

$result = select($sql, $values, $datatypes);
if($result['status'] == 'error') {
    json_response("error", "Query failed: " . $result['error']);
}

foreach($result['data'] as &$row) {
    $row['can_view']   = isset($row['can_view']) ? getYesNoLabel($row['can_view']) : '';
    $row['can_add']    = isset($row['can_add']) ? getYesNoLabel($row['can_add']) : '';
    $row['can_edit']   = isset($row['can_edit']) ? getYesNoLabel($row['can_edit']) : '';
    $row['can_delete'] = isset($row['can_delete']) ? getYesNoLabel($row['can_delete']) : '';
    if(isset($row['created_at'])) $row['created_at'] = format_datetime($row['created_at']);
    if(isset($row['updated_at'])) $row['updated_at'] = format_datetime($row['updated_at']);
    if(isset($row['role_name'])) $row['role_name'] = ucwords(strtolower($row['role_name']));
    if(isset($row['module_name'])) $row['module_name'] = ucwords(strtolower($row['module_name']));
}

if(!empty($type)) {
    switch(strtolower($type)) {
        case 'csv':
            exportCSV($result['data'], "Permissions.csv");
            break;
        case 'txt':
            exportTXT($result['data'], "Permissions.txt");
            break;
        case 'pdf':
            exportPDF($result['data'], "Permissions.pdf");
            break;
        case 'xlsx':
            exportXLSX($result['data'], "Permissions.xlsx");
            break;
        default:
            json_response("error","Invalid export type! Use csv, txt, pdf, or xlsx.");
    }
    exit;
}

?>
