<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('manage users', 'can_view')) {
	json_response("error", "Access Denied");
	exit;
}

require_role([1]);

if(!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response("error", "Invalid CSRF Token");
}

$page = filterInput($_POST['page'] ?? 1, "int");
$perPage = filterInput($_POST['perPage'] ?? 10, "int");
$search = filterInput($_POST['search'] ?? "", "string");
$sortColumn = filterInput($_POST['sortColumn'] ?? "user_id", "string");
$sortOrder = filterInput($_POST['sortOrder'] ?? "ASC", "string");

$allowedCols = ["user_id", "uuid", "first_name", "last_name", "email", "phone", "role_id", "gender", "dob", "status", "created_at", "updated_at"];

$page = $page ?: 1;
$perPage = ($perPage >= 1 && $perPage <=100) ? $perPage : 10;

if(!in_array($sortColumn, $allowedCols)) {
    $sortColumn = "user_id";
}

$sortOrder = ($sortOrder == "DESC") ? "DESC" : "ASC";

$offset = ($page - 1) * $perPage;

$sql = "SELECT u.*, r.role_name FROM users u LEFT JOIN  roles r on u.role_id = r.id WHERE 1";
$whereValues = [];
$searchType = "";

if(!empty($search)) {
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

if($result['status'] == 'error') {
    json_response($result['status'], 'Query Failed' . $result['message'], '', '');

}
$html = "";
foreach($result['data'] as $row) {

    $created_at = format_datetime($row['created_at']);
    $updated_at = format_datetime($row['updated_at']);
    $dob = format_datetime($row['dob'], 'd M Y');

    // Status color
    $status = strtolower(trim($row['status'])); // Trim spaces aur lowercase
    $statusClass = $status === 'active' ? 'status-green' :
                ($status === 'pending' ? 'status-orange' :
                ($status === 'blocked' ? 'status-red' :
                ($status === 'inactive' ? 'status-gray' : 'status-gray')));

    $role = get_label("role_name", "roles", "id", $row['role_id']);

    $html .= "<tr>
        <td class='text-center'>
            <input class='form-check-input row-check' type='checkbox' value='{$row['user_id']}'>
        </td>
        <td>{$row['user_id']}</td>
        <td>{$row['uuid']}</td>
        <td>" . ucwords(clean($row['first_name'])) . "</td>
        <td>" . ucwords(clean($row['last_name'])) . "</td>
        <td>" . clean($row['email']) . "</td>
        <td>" . clean($row['phone']) . "</td>
        <td>" . ucwords(clean($role)) . "</td>
        <td>" . ucwords(clean($row['gender'] ?? '-')) . "</td>
        <td>{$dob}</td>
        <td>
            <button class='custom-badge $statusClass'>" . ucwords(clean($row['status'])) . "</button>
        </td>
        <td>{$created_at}</td>
        <td>{$updated_at}</td>
        " . (has_permission('manage users', 'can_edit') ? "
        <td class='text-end'>
            <a class='dropdown-item edit-btn' href='#'
                data-id='{$row['user_id']}'
                data-first_name='{$row['first_name']}'
                data-last_name='{$row['last_name']}'
                data-email='{$row['email']}'
                data-phone='{$row['phone']}'
                data-role='{$row['role_id']}'
                data-dob='{$row['dob']}'
                data-gender='{$row['gender']}'
                data-status='{$row['status']}'>
                <i class='fa-solid fa-pen-to-square m-r-5'></i> Edit
            </a>
        </td>
        " : "") . "

        " . (has_permission('manage users', 'can_delete') ? "
        <td class='text-end'>
            <a class='dropdown-item delete-btn' href='#' 
            data-id='{$row['user_id']}'
            data-name='{$row['first_name']}'>
                <i class='fa fa-trash'></i> Delete
            </a>
        </td>
        " : "") . "
    </tr>";
}

if($html == '') {
    $html = "<tr><td colspan='8' class='text-center'>No records found</td></tr>";

}

json_response("success", "Data Loaded", ["total" => $total, "html" => $html]);
?>