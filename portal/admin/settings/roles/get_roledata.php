<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('roles', 'can_view')) {
	showalert("error", "Access Denine");
	exit;
}

require_role([1]);

if(!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response("error", "Invalid CSRF Token");
}

$page       = filterInput($_POST['page'] ?? 1, "int");
$perPage    = filterInput($_POST['perPage'] ?? 10, "int");
$search     = filterInput($_POST['search'] ?? '', "string");
$sortColumn = filterInput($_POST['sortColumn'] ?? 'id', "string");
$sortOrder  = filterInput($_POST['sortOrder'] ?? 'ASC', "string");

$page    = $page ?: 1;  
$perPage = ($perPage >= 1 && $perPage <= 100) ? $perPage : 10;

$allowedCols = ['id', 'role_name', "created_at", "updated_at"];
if (!in_array($sortColumn, $allowedCols)) {
    $sortColumn = 'id';
}

$sortOrder = ($sortOrder === "DESC") ? "DESC" : "ASC";

$offset = ($page - 1) * $perPage;

$sql = "SELECT * FROM roles WHERE 1";
$whereValues = [];
$searchType  = "";

if (!empty($search)) {
    $sql .= " AND (role_name LIKE ? OR created_at LIKE ? OR updated_at LIKE ?)";
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
    json_response("error", "Query failed" . $result['error'], "", "");
}

$html = "";
$sr_no = $offset + 1;

foreach ($result['data'] as $row) {

    $created_at =  format_datetime($row['created_at']);
    $updated_at =  format_datetime($row['updated_at']
    // ,"Y-m-d H:i:s"
    );

    $html .= "
        <tr>
            <td>
                <div class='form-check check-tables'>
                    <input class='form-check-input row-check' type='checkbox' value='{$row['id']}'>
                </div>
            </td>
            <td>{$row['id']}</td>
            <td>" . ucwords($row['role_name']) . "</td>
            <td>{$created_at}</td>
            <td>{$updated_at}</td>

             " . (has_permission('roles', 'can_edit') ? "

            <td class='text-end'>
                <a class='dropdown-item edit-btn' href='#'
                data-id='{$row['id']}'
                data-role='{$row['role_name']}' >
                    <i class='fa-solid fa-pen-to-square m-r-5'></i> Edit
                </a>
            </td>
            " : "") . "

            " . (has_permission('roles', 'can_delete') ? "

            <td class='text-end'>
                <a class='dropdown-item delete-btn' href='#' 
                data-id='{$row['id']}'
                data-name='{$row['role_name']}'>
                    <i class='fa fa-trash'></i> Delete
                </a>
            </td>
            " : "") . "

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
