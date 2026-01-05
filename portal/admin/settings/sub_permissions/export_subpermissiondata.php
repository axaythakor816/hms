<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('permissions', 'can_view')) {
    json_response("error", "Access Denied");
}
require_role([1]);

if(!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response("error", "Invalid CSRF Token");
}

$page       = filterInput($_POST['page'] ?? 1, "int");
$perPage    = filterInput($_POST['perPage'] ?? 10, "int");
$search     = filterInput($_POST['search'] ?? '', "string");
$sortColumn = filterInput($_POST['sortColumn'] ?? 'permission_id ', "string");
$sortOrder  = filterInput($_POST['sortOrder'] ?? 'ASC', "string");
$type       = filterInput($_POST['type'] ?? 'pdf', "string");

$page    = $page ?: 1;
$perPage = ($perPage >= 1 && $perPage <= 100) ? $perPage : 10;

$allowedCols = ['permission_id', 'role_id', 'module_id', 'can_view', 'can_add', 'can_edit', 'can_delete', 'created_at', 'updated_at'];
if (!in_array($sortColumn, $allowedCols)) {
    $sortColumn = 'permission_id';
}

$sortOrder = ($sortOrder === "DESC") ? "DESC" : "ASC";

$offset = ($page - 1) * $perPage;

$sql = "SELECT rp.*, r.role_name, m.module_name FROM role_permissions rp LEFT JOIN roles r on rp.role_id = r.id LEFT JOIN modules m on rp.module_id = m.module_id WHERE 1";
$whereValues = [];
$searchType  = "";


if (!empty($search)) {
    $sql .= " AND (r.role_name LIKE ? OR m.module_name LIKE ? OR rp.created_at LIKE ? OR rp.updated_at LIKE ?)";
    $searchParam = "%$search%";
    $whereValues = [$searchParam, $searchParam, $searchParam, $searchParam];
    $searchType  = "ssss";
}

$totalSql = $sql;
$totalResult = select($totalSql, $whereValues, $searchType);

$total = $totalResult['rows'];

$sql .= " ORDER BY $sortColumn $sortOrder LIMIT ?, ?";

$values = $whereValues;
$values[] = $offset;
$values[] = $perPage;

$datatypes = $searchType . "ii";

$result = select($sql, $values, $datatypes);

if ($result['status'] == "error") {
    json_response("error", "Query failed" .$result['error'] , "", "");
}

if(empty($result['data'])) {
    json_response("error", "No Data Available For This Filter.");
}

foreach ($result['data'] as &$row) {

    $row['role_id'] = get_label("role_name", "roles", "id", $row['role_id']);
    $row['module_id'] = get_label("module_name", "modules", "module_id", $row['module_id']);


    $row['can_view']   = getYesNoLabel($row['can_view']);
    $row['can_add']    = getYesNoLabel($row['can_add']);
    $row['can_edit']   = getYesNoLabel($row['can_edit']);
    $row['can_delete'] = getYesNoLabel($row['can_delete']);
}


switch ($type) {
    case 'csv':
        exportCSV($result['data'], "Permission.csv");
        break;
    case 'txt':
        exportTXT($result['data'], "Permission.txt");
        break;
    case 'pdf':
        exportPDF($result['data'], "Permission.pdf");
        break;
    case 'xlsx':
        exportXLSX($result['data'], "Permission.xlsx");
        break;
    default:
        json_response("error","Invalid export type! Use csv, txt, pdf, or xlsx.");
}

?>
