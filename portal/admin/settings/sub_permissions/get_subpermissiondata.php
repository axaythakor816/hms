<?php

require_once '../../../../core/init.php';

require_login();

if (!has_permission('sub permissions', 'can_view')) {
    json_response("error", "Access Denied");
    exit;
}

require_role([1]);

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response("error", "Invalid CSRF Token");
}

$page = filterInput($_POST['page'] ?? 1, "int");
$perPage = filterInput($_POST['perPage'] ?? 10, "int");
$search = filterInput($_POST['search'] ?? '', "string");
$sortColumn = filterInput($_POST['sortColumn'] ?? 'sub_permission_id', "string");
$sortOrder = filterInput($_POST['sortOrder'] ?? 'ASC', "string");

$page = $page ?: 1;
$perPage = ($perPage >= 1 && $perPage <= 100) ? $perPage : 10;

$selectFields = ['fp.sub_permission_id'];
$allowedCols = ['sub_permission_id'];
$searchableCols = [];

if (has_sub_permission('sub permissions', 'role_id', 'can_view')) {
    $selectFields[] = 'r.role_name';
    $selectFields[] = 'fp.role_id';
    $allowedCols[] = 'role_name';
    $searchableCols[] = 'r.role_name';
}

if (has_sub_permission('sub permissions', 'module_id', 'can_view')) {
    $selectFields[] = 'm.module_name';
    $selectFields[] = 'f.module_id';
    $allowedCols[] = 'module_name';
    $searchableCols[] = 'm.module_name';
}

if (has_sub_permission('sub permissions', 'field_id', 'can_view')) {
    $selectFields[] = 'f.field_name';
    $selectFields[] = 'fp.field_id';
    $allowedCols[] = 'field_name';
    $searchableCols[] = 'f.field_name';
}

$permCols = ['can_view', 'can_add', 'can_edit', 'can_delete'];
foreach ($permCols as $col) {
    if (has_sub_permission('sub permissions', $col, 'can_view')) {
        $selectFields[] = "fp.$col";
        $allowedCols[] = $col;
        $searchableCols[] = "fp.$col";
    }
}

if (has_sub_permission('sub permissions', 'created_at', 'can_view')) {
    $selectFields[] = 'fp.created_at';
    $allowedCols[] = 'created_at';
    $searchableCols[] = 'fp.created_at';
}

if (has_sub_permission('sub permissions', 'updated_at', 'can_view')) {
    $selectFields[] = 'fp.updated_at';
    $allowedCols[] = 'updated_at';
    $searchableCols[] = 'fp.updated_at';
}

if (!in_array($sortColumn, $allowedCols)) {
    $sortColumn = 'sub_permission_id';
}

$sortOrder = ($sortOrder === "DESC") ? "DESC" : "ASC";
$offset = ($page - 1) * $perPage;

$sql = "SELECT " . implode(", ", $selectFields) . " 
        FROM field_permissions fp
        LEFT JOIN roles r ON fp.role_id = r.id
        LEFT JOIN fields f ON fp.field_id = f.field_id
        LEFT JOIN modules m ON f.module_id = m.module_id
        WHERE 1";

$whereValues = [];
$searchType = '';

if (!empty($search) && !empty($searchableCols)) {
    $orParts = [];
    foreach ($searchableCols as $col) {
        $orParts[] = "$col LIKE ?";
        $whereValues[] = "%$search%";
        $searchType .= 's';
    }
    $sql .= " AND (" . implode(" OR ", $orParts) . ")";
}

$totalResult = select($sql, $whereValues, $searchType);
$total = $totalResult['rows'];

$sql .= " ORDER BY $sortColumn $sortOrder LIMIT ?, ?";
$values = $whereValues;
$values[] = $offset;
$values[] = $perPage;
$datatypes = $searchType . "ii";

$result = select($sql, $values, $datatypes);

if ($result['status'] === "error") {
    json_response("error", "Query failed: " . $result['error']);
}

$html = "";
foreach ($result['data'] as $row) {

    $can_view = isset($row['can_view']) ? getYesNoLabel($row['can_view']) : '';
    $can_add  = isset($row['can_add']) ? getYesNoLabel($row['can_add']) : '';
    $can_edit = isset($row['can_edit']) ? getYesNoLabel($row['can_edit']) : '';
    $can_delete = isset($row['can_delete']) ? getYesNoLabel($row['can_delete']) : '';
    $created_at = isset($row['created_at']) ? format_datetime($row['created_at']) : '';
    $updated_at = isset($row['updated_at']) ? format_datetime($row['updated_at']) : '';

    $html .= "<tr>
        <td>
            <div class='form-check check-tables'>
                <input class='form-check-input row-check' type='checkbox' value='{$row['sub_permission_id']}'>
            </div>
        </td>
        <td>{$row['sub_permission_id']}</td>
        " . (isset($row['role_name']) ? "<td>{$row['role_name']}</td>" : "") . "
        " . (isset($row['module_name']) ? "<td>{$row['module_name']}</td>" : "") . "
        " . (isset($row['field_name']) ? "<td>{$row['field_name']}</td>" : "") . "
        " . (!empty($can_view) ? "<td>{$can_view}</td>" : "") . "
        " . (!empty($can_add) ? "<td>{$can_add}</td>" : "") . "
        " . (!empty($can_edit) ? "<td>{$can_edit}</td>" : "") . "
        " . (!empty($can_delete) ? "<td>{$can_delete}</td>" : "") . "
        " . (!empty($created_at) ? "<td>{$created_at}</td>" : "") . "
        " . (!empty($updated_at) ? "<td>{$updated_at}</td>" : "") . "

        " . (has_permission('sub permissions', 'can_edit') ? "
        <td class='text-end'>
            <a class='dropdown-item edit-btn' href='#'
                data-id='{$row['sub_permission_id']}'
                data-role='" . (isset($row['role_id']) ? $row['role_id'] : '') . "'
                data-module='" . (isset($row['module_id']) ? $row['module_id'] : '') . "'
                data-field='" . (isset($row['field_id']) ? $row['field_id'] : '') . "'
                data-can_view='" . (isset($row['can_view']) ? $row['can_view'] : '') . "'
                data-can_add='" . (isset($row['can_add']) ? $row['can_add'] : '') . "'
                data-can_edit='" . (isset($row['can_edit']) ? $row['can_edit'] : '') . "'
                data-can_delete='" . (isset($row['can_delete']) ? $row['can_delete'] : '') . "'>
                <i class='fa-solid fa-pen-to-square m-r-5'></i> Edit
            </a>
        </td>
        " : "") . "

        " . (has_permission('sub permissions', 'can_delete') ? "
        <td class='text-end'>
            <a class='dropdown-item delete-btn' href='#'
               data-id='{$row['sub_permission_id']}'
               data-name='" . (isset($row['field_name']) ? $row['field_name'] : '') . "'>
                <i class='fa fa-trash'></i> Delete
            </a>
        </td>
        " : "") . "
    </tr>";
}

if ($html === "") {
    $html = "<tr><td colspan='12' class='text-center'>No records found</td></tr>";
}

json_response("success", "Data Loaded", [
    "html"  => $html,
    "total" => $total
]);

?>
