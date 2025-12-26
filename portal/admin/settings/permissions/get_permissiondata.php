<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('permissions', 'can_view')) {
	json_response("error", "Access Denine");
	exit;
}

require_role([1]);

if(!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response("error", "Invalid CSRF Token");
}

$page       = filterInput($_POST['page'] ?? 1, "int");
$perPage    = filterInput($_POST['perPage'] ?? 10, "int");
$search     = filterInput($_POST['search'] ?? '', "string");
$sortColumn = filterInput($_POST['sortColumn'] ?? 'permission_id', "string");
$sortOrder  = filterInput($_POST['sortOrder'] ?? 'ASC', "string");

$page    = $page ?: 1;  
$perPage = ($perPage >= 1 && $perPage <= 100) ? $perPage : 10;

$allowedCols = ['permission_id', 'role_id', 'module_id', "can_view", "can_add", "can_edit", "can_delete", "created_at", "updated_at"];
if (!in_array($sortColumn, $allowedCols)) {
    $sortColumn = 'permission_id';
}

$sortOrder = ($sortOrder === "DESC") ? "DESC" : "ASC";

$offset = ($page - 1) * $perPage;

$sql = "SELECT rp.*, r.role_name, m.module_name FROM role_permissions rp LEFT JOIN roles r on rp.role_id = r.id LEFT JOIN modules m on rp.module_id = m.module_id WHERE 1";
$whereValues = [];
$searchType  = "";

if (!empty($search)) {
    $sql .= " AND (r.role_name LIKE ? OR m.module_name LIKE ? OR rp.created_at LIKE ? OR rp.updated_at LIKE ?)";
    $searchParam = "%$search%";
    $whereValues = [$searchParam, $searchParam, $searchParam, $searchParam];
    $searchType  = "ssss";
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
        json_response($result['status'], "Query failed" . $result['error'], "", "");
    }

$html = "";
$sr_no = $offset + 1;

foreach ($result['data'] as $row) {

    $role_name = ucfirst(get_label("role_name", "roles", "id", $row['role_id']));
    $can_view = getYesNoLabel($row['can_view']);
    $can_add = getYesNoLabel($row['can_add']);
    $can_edit = getYesNoLabel($row['can_edit']);
    $can_delete = getYesNoLabel($row['can_delete']);
    $module = get_label("module_name", "modules", "module_id", $row['module_id']);

    $created_at =  format_datetime($row['created_at']);
    $updated_at =  format_datetime($row['updated_at']
    // ,"Y-m-d H:i:s"
    );

    $html .= "
        <tr>
            <td>
                <div class='form-check check-tables'>
                    <input class='form-check-input row-check' type='checkbox' value='{$row['permission_id']}'>
                </div>
            </td>
            <td>{$row['permission_id']}</td>
            <td>{$role_name}</td>
            <td>" . ucwords($module) . "</td>
            <td>{$can_view}</td>
            <td>{$can_add}</td>
            <td>{$can_edit}</td>
            <td>{$can_delete}</td>
            <td>{$created_at}</td>
            <td>{$updated_at}</td>

            " . (has_permission('permissions', 'can_edit') ? "

            <td class='text-end'>
                <a class='dropdown-item edit-btn' href='#'
                data-id='{$row['permission_id']}'
                data-role='{$row['role_id']}'
                data-module='{$row['module_id']}'
                data-can_view='{$row['can_view']}'
                data-can_add='{$row['can_add']}'
                data-can_edit='{$row['can_edit']}'
                data-can_delete='{$row['can_delete']}' >
                    <i class='fa-solid fa-pen-to-square m-r-5'></i> Edit  
                </a>
            </td>
            " : "") . "

            " . (has_permission('permissions', 'can_delete') ? "
            <td class='text-end'>
                <a class='dropdown-item delete-btn' href='#' 
                data-id='{$row['permission_id']}'
                data-name='{$module}'>
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
