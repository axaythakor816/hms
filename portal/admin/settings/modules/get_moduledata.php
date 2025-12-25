<?php

use PhpOffice\PhpSpreadsheet\Calculation\Engine\FormattedNumber;
require_once '../../../../core/init.php';

require_login();

if(!has_permission('modules', 'can_view')) {
    json_response('error', 'Access Denine');
    exit;
}

require_role([1]);

if(!verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid Csrf Token");
    exit;
}

$page = filterInput($_POST['page'], 'int');
$perPage = filterInput($_POST['perPage'], 'int');
$sortColumn = filterInput($_POST['sortColumn'] ?? 'module_id', 'string');
$search = filterInput($_POST['search'] ?? '', 'string');
$sortOrder = filterInput($_POST['sortOrder'] ?? 'ASC', "string");

$page = $page ?: 1;
$perPage = ($perPage >= 1 && $perPage <= 100) ? $perPage : 10;

$allowedCols = ['module_id', 'module_name', 'created_at', 'updated_at'];

if(!in_array($sortColumn, $allowedCols)) {
    $sortColumn = 'module_id';

}

$sortOrder = ($sortOrder === 'DESC') ? 'DESC' : 'ASC';

$offset = ($page - 1) * $perPage;

$sql = "SELECT * FROM modules WHERE 1";
$whereValues = [];
$searchType = '';

if(!empty($search)) {
    $sql .= " AND (module_name LIKE ? OR Created_at LIKE ? OR Updated_at LIKE ?)";
    $searchParam = "%$search%";
    $whereValues = [$searchParam, $searchParam, $searchParam];
    $searchType = "sss";
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
    $created_at = format_datetime($row['created_at']);
    $updated_at = format_datetime($row['updated_at']);
    $html .= "<tr>
        <td>
            <div class='form-check check-tables'>
                <input class='form-check-input row-check' type='checkbox' value='{$row['module_id']}'>
            </div>
        </td>
        <td>{$row['module_id']}</td>
        <td>" . ucwords($row['module_name']) . "</td>
        <td>{$created_at}</td>
        <td>{$updated_at}</td> 

        " . (has_permission('modules', 'can_edit') ? "
        <td class='text-end'>
            <a class='dropdown-item edit-btn' href='#'
            data-id='{$row['module_id']}'
            data-module='{$row['module_name']}' >
                <i class='fa-solid fa-pen-to-square m-r-5'></i> Edit  
            </a>
        </td>
        " : "") . "

        " . (has_permission('modules', 'can_delete') ? "
        <td class='text-end'>
            <a class='dropdown-item delete-btn' href='#' 
            data-id='{$row['module_id']}'
            data-name='{$row['module_name']}'>
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