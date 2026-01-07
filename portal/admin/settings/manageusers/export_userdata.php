<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('manage users', 'can_view')) {
    json_response("error", "Access Denied");
}
require_role([1,6]);

if(!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response("error", "Invalid CSRF Token");
}

$page       = filterInput($_POST['page'] ?? 1, "int");
$perPage    = filterInput($_POST['perPage'] ?? 10, "int");
$search     = filterInput($_POST['search'] ?? '', "string");
$sortColumn = filterInput($_POST['sortColumn'] ?? 'user_id ', "string");
$sortOrder  = filterInput($_POST['sortOrder'] ?? 'ASC', "string");
$type       = filterInput($_POST['type'] ?? 'pdf', "string");

$page    = $page ?: 1;
$perPage = ($perPage >= 1 && $perPage <= 100) ? $perPage : 10;

$allowedCols = ["user_id", "uuid", "first_name", "last_name", "email", "phone", "role_id", "gender", "dob", "status", "created_at", "updated_at"];
if (!in_array($sortColumn, $allowedCols)) {
    $sortColumn = 'user_id';
}

$sortOrder = ($sortOrder === "DESC") ? "DESC" : "ASC";

$offset = ($page - 1) * $perPage;

$sql = "SELECT u.*, r.role_name FROM users u LEFT JOIN roles r on u.role_id = r.id WHERE 1";
$whereValues = [];
$searchType  = "";


if (!empty($search)) {
    $sql .= " AND (r.role_name LIKE ? OR u.first_name LIKE ? OR u.last_name LIKE ? OR u.email LIKE ? OR u.phone LIKE ? OR u.gender LIKE ? OR u.dob LIKE ? OR u.created_at LIKE ? OR u.updated_at like ?) ";
    $searchParam = "%$search%";
    $whereValues = [$searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam];
    $searchType = "sssssssss";
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
}


switch ($type) {
    case 'csv':
        exportCSV($result['data'], "User.csv");
        break;
    case 'txt':
        exportTXT($result['data'], "User.txt");
        break;
    case 'pdf':
        exportPDF($result['data'], "User.pdf");
        break;
    case 'xlsx':
        exportXLSX($result['data'], "User.xlsx");
        break;
    default:
        json_response("error","Invalid export type! Use csv, txt, pdf, or xlsx.");
}

?>
