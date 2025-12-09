<?php
require_once '../../../core/init.php';

require_login();

if(!has_permission('departments', 'can_view')) {
    json_response("error", "Access Denied");
}

if(!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response("error", "Invalid CSRF Token");
}

$page       = filterInput($_POST['page'] ?? 1, "int");
$perPage    = filterInput($_POST['perPage'] ?? 10, "int");
$search     = filterInput($_POST['search'] ?? '', "string");
$sortColumn = filterInput($_POST['sortColumn'] ?? 'department_id', "string");
$sortOrder  = filterInput($_POST['sortOrder'] ?? 'ASC', "string");

$page    = $page ?: 1;
$perPage = ($perPage >= 1 && $perPage <= 100) ? $perPage : 10;

$allowedCols = ['department_id', 'department_name', 'department_head_id', "created_at", "updated_at"];
if (!in_array($sortColumn, $allowedCols)) {
    $sortColumn = 'department_id';
}

$sortOrder = ($sortOrder === "DESC") ? "DESC" : "ASC";

$offset = ($page - 1) * $perPage;

$sql = "SELECT * FROM departments WHERE 1";
$whereValues = [];
$searchType  = "";

if (!empty($search)) {
    $sql .= " AND (department_name LIKE ? OR department_description LIKE ?)";
    $searchParam = "%$search%";
    $whereValues = [$searchParam, $searchParam];
    $searchType  = "ss";
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
    json_response("error", "Query failed", "", $result['error']);
}

$html = "";
$sr_no = $offset + 1;

foreach ($result['data'] as $row) {

    $department_head_name = get_label("display_name", "doctors", "doctor_id", "id");

    $html .= "
        <tr>
            <td>
                <div class='form-check check-tables'>
                    <input class='form-check-input' type='checkbox' value='something'>
                </div>
            </td>
            <td>{$sr_no}</td>
            <td>{$row['department_name']}</td>
            <td>{$department_head_name}</td>
            <td>{$row['department_description']}</td>
            <td>{$row['created_at']}</td>
            <td>{$row['updated_at']}</td>

            <td class='text-end'>
                <a class='dropdown-item edit-btn' href='#'
                data-id='{$row['department_id']}'
                data-name='{$row['department_name']}'
                data-head_id='{$row['department_head_id']}'
                data-desc='{$row['department_description']}' >
                    <i class='fa-solid fa-pen-to-square m-r-5'></i> Edit
                </a>
            </td>

            <td class='text-end'>
                <a class='dropdown-item' onclick='return confirm(\"Delete?\")'
                   href='#' data-id='{$row['department_id']}'>
                    <i class='fa fa-trash'></i> Delete
                </a>
            </td>
        </tr>
    ";

    $sr_no++;
}

if ($html == "") {
    
    $html = "<tr><td colspan='8' class='text-center'>No records found</td></tr>";
}

json_response("success", "Data Loaded", [
    "html"  => $html,
    "total" => $total
]);
?>
