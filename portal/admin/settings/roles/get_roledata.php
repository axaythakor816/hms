<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('roles', 'can_view')) {
	json_response("error", "Access Denied");
	exit;
}

require_role([1]);

if(!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response("error", "Invalid CSRF Token");
}

$page = filterInput($_POST['page'] ?? 1, "int");
$perPage = filterInput($_POST['perPage'] ?? 10, "int");
$search = filterInput($_POST['search'] ?? '', "string");
$sortColumn = filterInput($_POST['sortColumn'] ?? 'id', "string");
$sortOrder = filterInput($_POST['sortOrder'] ?? 'ASC', "string");

$page = $page ?: 1;  
$perPage = ($perPage >= 1 && $perPage <= 100) ? $perPage : 10;

$allowedCols = ['id'];
$searchablecol = [];
$selectfield = ['id'];
if(has_sub_permission("roles", "role_name", "can_view")) {
    $selectfield[] = 'role_name';
    $allowedCols[] = 'role_name';
    $searchablecol[] = 'role_name';
}

if(has_sub_permission("roles", "created_at", "can_view")) {
    $selectfield[] = 'created_at';
    $allowedCols[] = 'created_at';
    $searchablecol[] = 'created_at';
}
if(has_sub_permission("roles", "updated_at", "can_view")) {
    $selectfield[] = 'updated_at';
    $allowedCols[] = 'updated_at';
    $searchablecol[] = 'updated_at';
}

if (!in_array($sortColumn, $allowedCols)) {
    $sortColumn = 'id';
}

$sortOrder = ($sortOrder === "DESC") ? "DESC" : "ASC";

$offset = ($page - 1) * $perPage;

$sql = "SELECT " . implode(", ", $selectfield) . " FROM roles WHERE 1";
$whereValues = [];
$searchType  = "";

if(!empty($search) && !empty($searchablecol)) {
    $orParts = [];
    foreach($searchablecol as $col){
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

    $created_at = (isset($row['created_at']) ? format_datetime($row['created_at']) : "");
    $updated_at = (isset($row['updated_at']) ? format_datetime($row['updated_at']) : "");

    $html .= "
        <tr>
            <td>
                <div class='form-check check-tables'>
                    <input class='form-check-input row-check' type='checkbox' value='{$row['id']}'>
                </div>
            </td>
            <td>{$row['id']}</td>
            " . (isset($row['role_name']) ? "
                <td>" . ucwords($row['role_name']) . "</td>
            " : "") . "

            " . (!empty($created_at) ? "
                <td>{$created_at}</td>
            " : "") . "

            " . (!empty($updated_at) ? "
                <td>{$updated_at}</td>
            " : "") . "

             " . (has_permission('roles', 'can_edit') ? "

            <td class='text-end'>
                <a class='dropdown-item edit-btn' href='#'
                data-id='{$row['id']}'
                " . (isset($row['role_name']) ? "
                data-role='{$row['role_name']}' " : "") . "
                 >
                    <i class='fa-solid fa-pen-to-square m-r-5'></i> Edit
                </a>
            </td>
            " : "") . "

            " . (has_permission('roles', 'can_delete') ? "

            <td class='text-end'>
                <a class='dropdown-item delete-btn' href='#' 
                data-id='{$row['id']}'
                " . (isset($row['role_name']) ? "
                data-name='{$row['role_name']}'" : "") . "
                >
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
