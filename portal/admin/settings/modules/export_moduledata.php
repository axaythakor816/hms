<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('modules', 'can_view')) {
    json_response("error", "Access Denied");
}

if(!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response("error", "Invalid CSRF Token");
}

$page       = filterInput($_POST['page'] ?? 1, "int");
$perPage    = filterInput($_POST['perPage'] ?? 10, "int");
$search     = filterInput($_POST['search'] ?? '', "string");
$sortColumn = filterInput($_POST['sortColumn'] ?? 'id', "string");
$sortOrder  = filterInput($_POST['sortOrder'] ?? 'ASC', "string");
$type       = filterInput($_POST['type'] ?? 'pdf', "string");

$page    = $page ?: 1;
$perPage = ($perPage >= 1 && $perPage <= 100) ? $perPage : 10;

$allowedCols = ['module_id', 'module_name', 'created_at', 'updated_at'];
if (!in_array($sortColumn, $allowedCols)) {
    $sortColumn = 'module_id';
}

$sortOrder = ($sortOrder === "DESC") ? "DESC" : "ASC";

$offset = ($page - 1) * $perPage;

$sql = "SELECT * FROM modules WHERE 1";
$whereValues = [];
$searchType  = "";


if (!empty($search)) {
    $sql .= " AND (module_name LIKE ? OR created_at LIKE ? OR updated_at LIKE ?)";
    $searchParam = "%$search%";
    $whereValues = [$searchParam, $searchParam, $searchParam];
    $searchType  = "sss";
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

    $row['module_name'] = ucfirst(strtolower($row['module_name']));

}


switch ($type) {
    case 'csv':
        exportCSV($result['data'], "Module.csv");
        break;
    case 'txt':
        exportTXT($result['data'], "Module.txt");
        break;
    case 'pdf':
        exportPDF($result['data'], "Module.pdf");
        break;
    case 'xlsx':
        exportXLSX($result['data'], "Module.xlsx");
        break;
    default:
        json_response("error","Invalid export type! Use csv, txt, pdf, or xlsx.");
}

?>
