<?php

require_once '../../../../core/init.php';

require_login();

if(!has_permission('fields', 'can_view')) {
    json_response("error", "Access Denied");
    exit;
}

require_role([1]);

if(!verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid CSRF Token");
    exit;
}

$page = filterInput($_POST['page'], 'int');
$perPage = filterInput($_POST['perPage'], 'int');
$search = filterInput($_POST['search'], 'string');
$sortColumn = filterInput($_POST['sortColumn'], 'string');
$sortOrder = filterInput($_POST['sortOrder'], 'string');
$type = filterInput($_POST['type'], 'string');

$page = $page ?: 1;
$perPage = ($perPage >= 1 && $perPage <= 100) ? $perPage : 10;
$offset = ($page - 1) * $perPage;

$selectfield = ['f.field_id'];
$allowedCols = ['field_id'];
$searchablecol = [];

if(has_sub_permission('fields', 'module_name', 'can_view')) {
    $selectfield[] = 'm.module_name';
    $allowedCols[] = 'module_name';
    $searchablecol[] = 'm.module_name';
}

if(has_sub_permission('fields', 'field_name', 'can_view')) {
    $selectfield[] = 'f.field_name';
    $allowedCols[] = 'field_name';
    $searchablecol[] = 'f.field_name';
}

if(has_sub_permission('fields', 'created_at', 'can_view')) {
    $selectfield[] = 'f.created_at';
    $allowedCols[] = 'created_at';
    $searchablecol[] = 'f.created_at';
}

if(has_sub_permission('fields', 'updated_at', 'can_view')) {
    $selectfield[] = 'f.updated_at';
    $allowedCols[] = 'updated_at';
    $searchablecol[] = 'f.updated_at';
}

if(!in_array($sortColumn, $allowedCols)) {
    $sortColumn = 'field_id';
}
$sortOrder = ($sortOrder === 'DESC') ? 'DESC' : 'ASC';

$sql = "SELECT " . implode(", ", $selectfield) . ", f.module_id FROM fields f LEFT JOIN modules m ON f.module_id = m.module_id WHERE 1";

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
if($result['status'] == "error") {
    json_response("error", "Query failed: " . $result['error']);
}

foreach($result['data'] as &$row) {
    if(isset($row['module_name'])) $row['module_name'] = ucwords(strtolower($row['module_name']));
    if(isset($row['field_name'])) $row['field_name'] = ucwords(strtolower($row['field_name']));
    if(isset($row['created_at'])) $row['created_at'] = format_datetime($row['created_at']);
    if(isset($row['updated_at'])) $row['updated_at'] = format_datetime($row['updated_at']);
}

if(!empty($type)) {
    switch(strtolower($type)) {
        case 'csv':
            exportCSV($result['data'], "Fields.csv");
            break;
        case 'txt':
            exportTXT($result['data'], "Fields.txt");
            break;
        case 'pdf':
            exportPDF($result['data'], "Fields.pdf");
            break;
        case 'xlsx':
            exportXLSX($result['data'], "Fields.xlsx");
            break;
        default:
            json_response("error", "Invalid export type! Use csv, txt, pdf, or xlsx.");
    }
    exit;
}


?>
