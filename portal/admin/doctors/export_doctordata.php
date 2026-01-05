<?php
require_once '../../../core/init.php';

require_login();

if(!has_permission('doctors', 'can_view')) {
    json_response("error", "Access Denied");
}

require_role([1]);

if(!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response("error", "Invalid CSRF Token");
}

$page       = filterInput($_POST['page'] ?? 1, "int");
$perPage    = filterInput($_POST['perPage'] ?? 10, "int");
$search     = filterInput($_POST['search'] ?? '', "string");
$sortColumn = filterInput($_POST['sortColumn'] ?? 'doctor_id ', "string");
$sortOrder  = filterInput($_POST['sortOrder'] ?? 'ASC', "string");
$type       = filterInput($_POST['type'] ?? 'pdf', "string");

$page    = $page ?: 1;
$perPage = ($perPage >= 1 && $perPage <= 100) ? $perPage : 10;

$allowedCols = [
    'doctor_id', 'first_name', 'email', 'phone', 'gender', 'dob', 'status', 'specialty','sub_specialty', 'qualification', 'years_experience', 'medical_license_no', 'consultation_fee', 'available_days','available_time_from', 'languages_spoken', 'doctor_status', 'department_name', 'created_at', 'updated_at'
];

if (!in_array($sortColumn, $allowedCols)) {
    $sortColumn = 'doctor_id';
}

$sortOrder = ($sortOrder === "DESC") ? "DESC" : "ASC";

$offset = ($page - 1) * $perPage;

$sql = "SELECT
    -- USERS
    -- u.user_id,
    u.first_name,
    u.middle_name,
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
$totalResult = select($totalSql, $whereValues, $searchType);

$total = $totalResult['rows'];

$sql .= " ORDER BY $sortColumn $sortOrder LIMIT ?, ?";

$values = $whereValues;
$values[] = $offset;
$values[] = $perPage;

$datatypes = $searchType . "ii";

$result = select($sql, $values, $datatypes);

if ($result['status'] == "error") {
    json_response("error", "Query failed" .$result['error'] , "", "");
}

if(empty($result['data'])) {
    json_response("error", "No Data Available For This Filter.");
}

foreach ($result['data'] as &$row) {

    $row['is_consultation_online'] = getYesNoLabel($row['is_consultation_online']);

    $row['two_fa_enabled'] = ($row['two_fa_enabled'] == 0) ? "Disabled" : "Enabled";
}

switch ($type) {
    case 'csv':
        exportCSV($result['data'], "Doctor.csv");
        break;
    case 'txt':
        exportTXT($result['data'], "Doctor.txt");
        break;
    case 'pdf':
        exportPDF($result['data'], "Doctor.pdf");
        break;
    case 'xlsx':
        exportXLSX($result['data'], "Doctor.xlsx");
        break;
    default:
        json_response("error","Invalid export type! Use csv, txt, pdf, or xlsx.");
}

?>
