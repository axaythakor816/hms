<?php

require_once '../../../../core/init.php';

require_login();

if (!has_permission('permissions', 'can_view')) {
    json_response('error', 'Access Denied');
    exit;
}

require_role([1, 6]);

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response('error', 'Invalid CSRF Token');
    exit;
}

$page = filterInput($_POST['page'], 'int');
$perPage = filterInput($_POST['perPage'], 'int');
$sortColumn = filterInput($_POST['sortColumn'] ?? 'permission_id', 'string');
$search = filterInput($_POST['search'] ?? '', 'string');
$sortOrder  = filterInput($_POST['sortOrder'] ?? 'ASC', 'string');

$page    = $page ?: 1;
$perPage = ($perPage >= 1 && $perPage <= 100) ? $perPage : 10;

$allowedCols = ['permission_id'];
$searchableCol = [];
$selectField = ['rp.permission_id', 'rp.role_id', 'rp.module_id'];

if (has_sub_permission('permissions', 'role_id', 'can_view')) {
    $selectField[] = 'r.role_name';
    $allowedCols[] = 'role_name';
    $searchableCol[] = 'r.role_name';
}

if (has_sub_permission('permissions', 'module_id', 'can_view')) {
    $selectField[] = 'm.module_name';
    $allowedCols[] = 'module_name';
    $searchableCol[] = 'm.module_name';
}

$permCols = ['can_view', 'can_add', 'can_edit', 'can_delete'];
foreach ($permCols as $col) {
    if (has_sub_permission('permissions', $col, 'can_view')) {
        $selectField[] = "rp.$col";
        $allowedCols[] = $col;
        $searchableCol[] = "rp.$col";
    }
}

if (has_sub_permission('permissions', 'created_at', 'can_view')) {
    $selectField[] = 'rp.created_at';
    $allowedCols[] = 'created_at';
    $searchableCol[] = 'rp.created_at';
}

if (has_sub_permission('permissions', 'updated_at', 'can_view')) {
    $selectField[] = 'rp.updated_at';
    $allowedCols[] = 'updated_at';
    $searchableCol[] = 'rp.updated_at';
}

if (!in_array($sortColumn, $allowedCols)) {
    $sortColumn = 'permission_id';
}

$sortOrder = ($sortOrder === 'DESC') ? 'DESC' : 'ASC';

$offset = ($page - 1) * $perPage;

$sql = "SELECT " . implode(", ", $selectField) . ", rp.role_id, rp.module_id 
        FROM role_permissions rp 
        LEFT JOIN roles r ON rp.role_id = r.id 
        LEFT JOIN modules m ON rp.module_id = m.module_id 
        WHERE 1";

$whereValues = [];
$searchType = '';

if (!empty($search) && !empty($searchableCol)) {
    $orParts = [];
    foreach ($searchableCol as $col) {
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
$datatypes = $searchType . 'ii';

$result = select($sql, $values, $datatypes);

if ($result['status'] === 'error') {
    json_response('error', 'Query failed: ' . $result['error']);
}

$html = "";

foreach ($result['data'] as $row) {
    $can_view = isset($row['can_view']) ? getYesNoLabel($row['can_view']) : '';
    $can_add = isset($row['can_add']) ? getYesNoLabel($row['can_add']) : '';
    $can_edit = isset($row['can_edit']) ? getYesNoLabel($row['can_edit']) : '';
    $can_delete = isset($row['can_delete']) ? getYesNoLabel($row['can_delete']) : '';
    $created_at = isset($row['created_at']) ? format_datetime($row['created_at']) : '';
    $updated_at = isset($row['updated_at']) ? format_datetime($row['updated_at']) : '';

    $html .= "<tr>
        <td>
            <div class='form-check check-tables'>
                <input class='form-check-input row-check' type='checkbox' value='{$row['permission_id']}'>
            </div>
        </td>
        <td>{$row['permission_id']}</td>
        " . (isset($row['role_name']) ? "<td>{$row['role_name']}</td>" : "") . "
        " . (isset($row['module_name']) ? "<td>{$row['module_name']}</td>" : "") . "
        " . (!empty($can_view) ? "<td>{$can_view}</td>" : "") . "
        " . (!empty($can_add) ? "<td>{$can_add}</td>" : "") . "
        " . (!empty($can_edit) ? "<td>{$can_edit}</td>" : "") . "
        " . (!empty($can_delete) ? "<td>{$can_delete}</td>" : "") . "
        " . (!empty($created_at) ? "<td>{$created_at}</td>" : "") . "
        " . (!empty($updated_at) ? "<td>{$updated_at}</td>" : "") . "

        " . (has_permission('permissions', 'can_edit') ? "
        <td class='text-end'>
            <a class='dropdown-item edit-btn' href='#'
                data-id='{$row['permission_id']}'
                data-role='{$row['role_id']}'
                data-module='{$row['module_id']}'
                data-can_view='" . (isset($row['can_view']) ? $row['can_view'] : '') . "'
                data-can_add='" . (isset($row['can_add']) ? $row['can_add'] : '') . "'
                data-can_edit='" . (isset($row['can_edit']) ? $row['can_edit'] : '') . "'
                data-can_delete='" . (isset($row['can_delete']) ? $row['can_delete'] : '') . "'>
                <i class='fa-solid fa-pen-to-square m-r-5'></i> Edit
            </a>
        </td>
        " : "") . "

        " . (has_permission('permissions', 'can_delete') ? "
        <td class='text-end'>
            <a class='dropdown-item delete-btn' href='#'
               data-id='{$row['permission_id']}'
               data-name='" . (isset($row['module_name']) ? $row['module_name'] : '') . "'>
                <i class='fa fa-trash'></i> Delete
            </a>
        </td>
        " : "") . "
    </tr>";
}

if ($html === "") {
    $html = "<tr><td colspan='12' class='text-center'>No records found</td></tr>";
}

json_response('success', 'Data Loaded', [
    'total' => $total,
    'html' => $html
]);

?>
