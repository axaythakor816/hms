<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('modules', 'can_view')) {
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
$sortColumn = filterInput($_POST['sortColumn'] ?? 'module_id', "string");
$sortOrder = filterInput($_POST['sortOrder'] ?? 'ASC', "string");
$type = filterInput($_POST['type'] ?? '', "string"); 

$page = $page ?: 1;
$perPage = ($perPage >= 1 && $perPage <= 100) ? $perPage : 10;
$offset = ($page - 1) * $perPage;

$selectFields = ['module_id'];
$allowedCols = ['module_id'];
$searchableCols = [];

if(has_sub_permission("modules", "module_name", "can_view")) {
    $selectFields[] = 'module_name';
    $allowedCols[] = 'module_name';
    $searchableCols[] = 'module_name';
}

if(has_sub_permission("modules", "created_at", "can_view")) {
    $selectFields[] = 'created_at';
    $allowedCols[] = 'created_at';
    $searchableCols[] = 'created_at';
}

if(has_sub_permission("modules", "updated_at", "can_view")) {
    $selectFields[] = 'updated_at';
    $allowedCols[] = 'updated_at';
    $searchableCols[] = 'updated_at';
}

if(!in_array($sortColumn, $allowedCols)) {
    $sortColumn = 'module_id';
}
$sortOrder = ($sortOrder === "DESC") ? "DESC" : "ASC";

$sql = "SELECT " . implode(", ", $selectFields) . " FROM modules WHERE 1";
$whereValues = [];
$searchType = "";

if(!empty($search) && !empty($searchableCols)) {
    $orParts = [];
    foreach($searchableCols as $col){
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
if ($result['status'] == "error") {
    json_response("error", "Query failed: " . $result['error']);
}

foreach ($result['data'] as &$row) {
    if(isset($row['module_name'])) $row['module_name'] = ucwords(strtolower($row['module_name']));
    if(isset($row['created_at'])) $row['created_at'] = format_datetime($row['created_at']);
    if(isset($row['updated_at'])) $row['updated_at'] = format_datetime($row['updated_at']);
}

if(!empty($type)) {
    switch(strtolower($type)) {
        case 'csv':
            exportCSV($result['data'], "Modules.csv");
            break;
        case 'txt':
            exportTXT($result['data'], "Modules.txt");
            break;
        case 'pdf':
            exportPDF($result['data'], "Modules.pdf");
            break;
        case 'xlsx':
            exportXLSX($result['data'], "Modules.xlsx");
            break;
        default:
            json_response("error","Invalid export type! Use csv, txt, pdf, or xlsx.");
    }
    exit;
}

?>
