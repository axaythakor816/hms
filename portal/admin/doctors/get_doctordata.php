<?php

// use PhpOffice\PhpSpreadsheet\Calculation\Engine\FormattedNumber;
require_once '../../../core/init.php';

require_login();
if(!has_permission("doctors", "can_view")) {
    json_response("error", "Access Denied You Are Not Authorize Persion");	
	exit;
}
if(!verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid CSRF Token", "", "");
}

$page = filterInput($_POST['page'], "int");
$perPage = filterInput($_POST['perPage'] ?? 10, "int");
$search = filterInput($_POST['search'] ?? '', "string");
$sortColumn = filterInput($_POST['sortColumn'] ?? 'doctor_id', "string");
$sortOrder = filterInput($_POST['sortOrder'] ?? 'ASC', "string");

$page = $page ?: 1;
$perPage = ($perPage >= 1 && $perPage <= 100) ? $perPage : 10;

$allowedCols = [
    'doctor_id', 'first_name', 'email', 'phone', 'gender', 'dob', 'status', 'specialty','sub_specialty', 'qualification', 'years_experience', 'medical_license_no', 'consultation_fee', 'available_days','available_time_from', 'languages_spoken', 'doctor_status', 'department_name', 'created_at', 'updated_at'
];

if(!in_array($sortColumn, $allowedCols)) {
    $sortColumn = 'doctor_id';
}
$sortOrder = ($sortOrder === "DESC") ? "DESC" : "ASC";
$offset = ($page - 1) * $perPage;

$sql = "SELECT
    -- USERS
    u.user_id,
    u.first_name,
    u.last_name,
    u.profile_image,
    u.email,
    u.phone,
    u.gender,
    u.dob,
    u.status AS user_status,
    
    -- DOCTORS
    d.doctor_id,
    d.specialty,
    d.sub_specialty,
    d.qualification,
    d.years_experience,
    d.department_id,
    d.medical_license_no,
    d.license_issue_date,
    d.license_expiry_date,
    d.consultation_fee,
    d.available_days,
    d.available_time_from,
    d.available_time_to,
    d.languages_spoken,
    d.bio,
    d.street, 
    d.city, 
    d.state, 
    d.pincode,
    d.doctor_status,
    d.is_consultation_online,
    d.ratings_avg,
    d.ratings_count,
    d.two_fa_enabled,
    d.meta,
    d.created_at AS doctor_created_at,
    d.updated_at AS doctor_updated_at,

    -- DEPARTMENTS
    dep.department_name

    FROM doctors d
    INNER JOIN users u 
        ON u.user_id = d.user_id
    LEFT JOIN departments dep 
        ON dep.department_id = d.department_id WHERE 1";
$whereValues = [];
$searchType = "";

if(!empty($search)) {
    $sql .= " AND (u.first_name LIKE ? OR u.last_name LIKE ? OR u.phone LIKE ? OR u.email LIKE ? OR u.dob LIKE ? OR d.specialty LIKE ? OR d.sub_specialty LIKE ? OR d.qualification LIKE ? OR d.medical_license_no LIKE ? OR dep.department_name LIKE ?)";
    $searchParam = "%$search%";
    $whereValues= [$searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam];
    $searchType = "ssssssssss";
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


if($result['status'] == "error") {
    json_response("error", "Query failed" . $result['error'], "", "");
}
$html = "";
$sr_no = $offset + 1;

foreach($result['data'] as $row) {
    $dob = format_datetime($row['dob'], "Y-m-d");
    $created_at =  format_datetime($row['doctor_created_at']);
    $updated_at =  format_datetime($row['doctor_updated_at']);

    $html .= "<tr>
                <td>
                    <div class='form-check check-tables'>
                        <input class='form-check-input row-check' type='checkbox' value='{$row['department_id']}'>
                    </div>
                </td>
                <td>{$row['doctor_id']}</td>
                <td>" . ucwords(clean($row['first_name']) . " " . clean($row['last_name'])) . "</td>
                <td>" . clean($row['phone']) . "</td>
                <td>" . clean($row['email']) . "</td>
                <td>" . $dob . "</td>
                <td>" . ucwords(clean($row['gender'])) . "</td>
                <td>" . ucwords(clean($row['user_status'])) . "</td>
                <td>" . ucwords(clean($row['specialty'])) . "</td>
                <td>" . ucwords(clean($row['sub_specialty'])) . "</td>
                <td>" . strtoupper(clean($row['qualification'])) . "</td>
                <td>" . clean($row['years_experience']) . "</td>
                <td>" . ucwords(clean($row['department_name'])) . "</td>
                <td>" . clean($row['medical_license_no']) . "</td>
                <td>" . clean($row['consultation_fee']) . "</td>
                <td>" . clean($row['available_days']) . "</td>
                <td>" . format_datetime($row['available_time_from']) . (!empty($row['available_time_from']) && !empty($row['available_time_to']) ? ' to ' : '') . format_datetime($row['available_time_to']) . "</td>
                <td>" . ucwords(clean($row['languages_spoken'])) . "</td>
                <td>" . ucwords(clean($row['bio'])) . "</td>
                <td>" . ucwords(clean($row['doctor_status'])) . "</td>
                <td>" 
                . ucwords(implode(", ", array_filter([clean($row['street']), clean($row['city']), clean($row['state'])]))) . (!empty($row['pincode']) ? " - " . clean($row['pincode']) : '') . "</td>
                <td>" . $created_at . "</td>
                <td>" . $updated_at . "</td>
                " . (has_permission('doctors', 'can_edit') ? "
                        <td class='text-end'>
                            <a class='dropdown-item edit-btn' href='#'
                                data-id='{$row['doctor_id']}'
                                data-first_name='{$row['first_name']}'
                                data-last_name='{$row['last_name']}'
                                data-email='{$row['email']}'
                                data-phone='{$row['phone']}'
                                data-dob='{$row['dob']}'
                                data-gender='{$row['gender']}'
                                data-status='{$row['user_status']}'>
                                <i class='fa-solid fa-pen-to-square m-r-5'></i> Edit
                            </a>
                        </td>
                        " : "") . "

                        " . (has_permission('doctors', 'can_delete') ? "
                        <td class='text-end'>
                            <a class='dropdown-item delete-btn' href='#' 
                            data-id='{$row['doctor_id']}'
                            data-name='{$row['first_name']}'>
                                <i class='fa fa-trash'></i> Delete
                            </a>
                        </td>
                        " : "") . "
            </tr>";
}

if($html == '') {
    $html = "<tr><td colspan='21' class='text-center'>No records found</td></tr>";

}

json_response("success", "Data Loaded", ["total" => $total, "html" => $html]);



?>