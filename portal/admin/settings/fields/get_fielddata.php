<?php

require_once '../../../../core/init.php';

require_login();

if(!has_permission('modules', 'can_view')) {
    json_response('error', 'Access Denied');
    exit;
}

require_role([1]);

if(!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response("error", "Invalid Csrf Token");
    exit;
}

$page = filterInput($_POST['page'], 'int');
$perPage = filterInput($_POST['perPage'], 'int');
$sortColumn = filterInput($_POST['sortColumn'] ?? 'field_id', 'string');
$search = filterInput($_POST['search'] ?? '', 'string');
$sortOrder = filterInput($_POST['sortOrder'] ?? 'ASC', "string");

$page = $page ?: 1;
$perPage = ($perPage >= 1 && $perPage <= 100) ? $perPage : 10;
$allowedCols = ['field_id'];
$searchablecol = [];
$selectfield = ['f.field_id'];

if (has_sub_permission('fields', 'module_id', 'can_view')) {
    $selectfield[]   = 'm.module_name';
    $allowedCols[]   = 'module_name';
    $searchablecol[] = 'm.module_name';
}

if (has_sub_permission('fields', 'field_name', 'can_view')) {
    $selectfield[]   = 'f.field_name';
    $allowedCols[]   = 'field_name';
    $searchablecol[] = 'f.field_name';
}

if (has_sub_permission('fields', 'created_at', 'can_view')) {
    $selectfield[]   = 'f.created_at';
    $allowedCols[]   = 'created_at';
    $searchablecol[] = 'f.created_at';
}

if (has_sub_permission('fields', 'updated_at', 'can_view')) {
    $selectfield[]   = 'f.updated_at';
    $allowedCols[]   = 'updated_at';
    $searchablecol[] = 'f.updated_at';
}

if(!in_array($sortColumn, $allowedCols)) {
    $sortColumn = 'field_id';
}

$sortOrder = ($sortOrder === 'DESC') ? 'DESC' : 'ASC';

$offset = ($page - 1) * $perPage;

$sql = "SELECT " . implode(", ", $selectfield) . ", f.module_id FROM fields f LEFT JOIN modules m on f.module_id = m.module_id WHERE 1";
$whereValues = [];
$searchType = '';

if (!empty($search) && !empty($searchablecol)) {
    $orParts = [];
    foreach ($searchablecol as $col) {
        $orParts[] = "$col LIKE ?";
        $whereValues[] = "%$search%";
        $searchType .= "s";
    }
    $sql .= " AND (" . implode(" OR ", $orParts) . ")";
}

$totalSql = $sql;
$totalResult = select($sql, $whereValues, $searchType);
$total = $totalResult['rows'];

$sql .= " ORDER BY $sortColumn $sortOrder LIMIT ?, ?";

$values = $whereValues;
$values[] = $offset;
$values[] = $perPage;

$datatypes = $searchType . "ii";

$result = select($sql, $values, $datatypes);

if ($result['status'] == "error") {
    json_response($result['status'], "Query failed" . $result['error'], "", "");
}

$html = "";

foreach($result['data'] as $row) {
    $created_at = isset($row['created_at']) ? format_datetime($row['created_at']) : '';
    $updated_at = isset($row['updated_at']) ? format_datetime($row['updated_at']) : '';
    $html .= "<tr>
        <td>
            <div class='form-check check-tables'>
                <input class='form-check-input row-check' type='checkbox' value='{$row['field_id']}'>
            </div>
        </td>
        <td>{$row['field_id']}</td>
        
        " . (isset($row['module_name']) ? "<td>" . ucwords($row['module_name']) . "</td>" : "") . "
        " . (isset($row['field_name']) ? "<td>" . ucwords($row['field_name']) . "</td>" : "") . "
        " . (!empty($created_at) ? "<td>{$created_at}</td>" : "") . "
        " . (!empty($updated_at) ? "<td>{$updated_at}</td>" : "") . " 

        " . (has_permission('fields', 'can_edit') ? "
        <td class='text-end'>
            <a class='dropdown-item edit-btn' href='#'
            data-id='{$row['field_id']}'
            data-module='{$row['module_id']}'
            " . (isset($row['field_name']) ? "data-field='{$row['field_name']}'" : "") . ">
                <i class='fa-solid fa-pen-to-square m-r-5'></i> Edit  
            </a>
        </td>
        " : "") . "

        " . (has_permission('fields', 'can_delete') ? "
        <td class='text-end'>
            <a class='dropdown-item delete-btn' href='#' 
            data-id='{$row['field_id']}'
            " . (isset($row['field_name']) ? "data-name='{$row['field_name']}'" : "") . ">
                <i class='fa fa-trash'></i> Delete
            </a>
        </td>
        " : "") . "
    </tr>
    ";
}

if($html == "") {
    $html = "<tr><td colspan='8' class='text-center'>No records found</td></tr>";
}

json_response("success", "Data Loaded", ["total" => $total, "html" => $html]);

?>