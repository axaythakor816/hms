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

$page = $page ?: 1;
$perPage = ($perPage >= 1 && $perPage <= 100) ? $perPage : 10;

$allowedCols = ['module_id'];
$searchableCols = [];
$selectFields = ['module_id'];

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
$offset = ($page - 1) * $perPage;

$sql = "SELECT " . implode(", ", $selectFields) . " FROM modules WHERE 1";
$whereValues = [];
$searchType = "";

if(!empty($search) && !empty($searchableCols)) {
    $orParts = [];
    foreach($searchableCols as $col) {
        $orParts[] = "$col LIKE ?";
        $whereValues[] = "%$search%";
        $searchType .= "s";
    }
    $sql .= " AND (" . implode(" OR ", $orParts) . ")";
}

$totalSql = $sql;
$totalResult = select($totalSql, $whereValues, $searchType);
$total = $totalResult['rows'];

$sql .= " ORDER BY $sortColumn $sortOrder LIMIT ?, ?";
$values = array_merge($whereValues, [$offset, $perPage]);
$datatypes = $searchType . "ii";

$result = select($sql, $values, $datatypes);

if($result['status'] == "error") {
    json_response("error", "Query failed: " . $result['error']);
}

$html = "";
$sr_no = $offset + 1;

foreach($result['data'] as $row) {
    $created_at = isset($row['created_at']) ? format_datetime($row['created_at']) : "";
    $updated_at = isset($row['updated_at']) ? format_datetime($row['updated_at']) : "";

    $html .= "
        <tr>
            <td>
                <div class='form-check check-tables'>
                    <input class='form-check-input row-check' type='checkbox' value='{$row['module_id']}'>
                </div>
            </td>
            <td>{$row['module_id']}</td>
            " . (isset($row['module_name']) ? "<td>" . ucwords($row['module_name']) . "</td>" : "") . "
            " . (!empty($created_at) ? "<td>{$created_at}</td>" : "") . "
            " . (!empty($updated_at) ? "<td>{$updated_at}</td>" : "") . "

            " . (has_permission('modules', 'can_edit') ? "
            <td class='text-end'>
                <a class='dropdown-item edit-btn' href='#'
                    data-id='{$row['module_id']}'
                    " . (isset($row['module_name']) ? "data-module='{$row['module_name']}'" : "") . ">
                    <i class='fa-solid fa-pen-to-square m-r-5'></i> Edit
                </a>
            </td>
            " : "") . "

            " . (has_permission('modules', 'can_delete') ? "
            <td class='text-end'>
                <a class='dropdown-item delete-btn' href='#'
                    data-id='{$row['module_id']}'
                    " . (isset($row['module_name']) ? "data-name='{$row['module_name']}'" : "") . ">
                    <i class='fa fa-trash'></i> Delete
                </a>
            </td>
            " : "") . "
        </tr>
    ";

    $sr_no++;
}

if($html == "") {
    $html = "<tr><td colspan='8' class='text-center'>No records found</td></tr>";
}

json_response("success", "Data Loaded", ["html" => $html, "total" => $total]);
?>
