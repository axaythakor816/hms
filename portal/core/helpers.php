<?php

function formValidation($values = []) {
    $errors = [];

    foreach($values as $key => $value) {

    }

}

function insert($sql, $values, $datatypes) {
    $conn = $GLOBALS['conn'];

    if ($stmt = mysqli_prepare($conn, $sql)) {

        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);

            return json_encode([
                "status" => "success",
                "message" => "Record inserted successfully"
            ]);
        } else {
            $error = mysqli_error($conn);
            mysqli_stmt_close($stmt);

            return json_encode([
                "status" => "error",
                "message" => "Query execution failed",
                "error" => $error
            ]);
        }

    } else {
        $error = mysqli_error($conn);
        return json_encode([
            "status" => "error",
            "message" => "Query preparation failed",
            "error" => $error
        ]);
    }
}

function update($sql, $values, $datatypes) {
$conn = $GLOBALS['conn'];
    if($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if(mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);

            return json_encode([
                "status" => "success",
                "message" => "Data Update successfull"
            ]);
        } else {
            $error = mysqli_error($conn);
            mysqli_stmt_close($stmt);
            return json_encode([
                "status" => "success",
                "message" => "Query execution failed",
                "error" => $error
            ]);
        }
        
    } else {
        $error = mysqli_error($conn);
        return json_encode([
            "status" => "error",
            "message" => "Query Preparation Failed",
            "error" => $error
        ]);
    }

}

function select($sql, $values, $datatypes = "") {
    $conn = $GLOBALS['conn'];

    if ($stmt = mysqli_prepare($conn, $sql)) {

        // अगर parameters हैं तो bind करें
        if (!empty($values)) {
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        }

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }

            mysqli_stmt_close($stmt);

            if (count($data) > 0) {
                return json_encode([
                    "status" => "success",
                    "rows" => count($data),
                    "data" => $data
                ]);
            } else {

                return json_encode([
                    "status" => "success",
                    "rows" => 0,
                    "data" => [],
                    "message" => "No records found"
                ]);
            }

        } else {
            $error = mysqli_error($conn);
            mysqli_stmt_close($stmt);

            // ⚠️ Query execute error
            return json_encode([
                "status" => "error",
                "message" => "Query execution failed",
                "error" => $error
            ]);
        }

    } else {
        $error = mysqli_error($conn);

        return json_encode([
            "status" => "error",
            "message" => "Query preparation failed",
            "error" => $error
        ]);
    }
}

function delete($sql, $values, $datatypes) {
    $conn = $GLOBALS['conn'];

    if($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if(mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);

            return json_encode([
                "status" => "success",
                "message" => "Record Delete Successfully"
            ]);
        } else {
            $error = mysqli_errno($conn);
            mysqli_stmt_close($stmt);
            return json_encode([
                "status" => "error", 
                "message" => "Query execution failed",
                "error" => $error

            ]);
        }
    } else {
        $error = mysqli_error($conn);

        return json_encode([
            "status" => "error",
            "message" => "Query preparation failed",
            "error" => $error
        ]);
    }
}

function checkDuplicateFields($table, $fields = [], $id = null) {
    $conn = $GLOBALS['conn'];
    if (empty($fields)) {
        return json_encode([
            "status" => "error",
            "message" => "No fields provided for duplicate check"
        ]);
    }

    $placeholders = [];
    $values = [];
    $types = "";

    foreach ($fields as $field => $value) {
        $placeholders[] = "$field=?";
        $values[] = $value;
        $types .= "s"; // assuming all string, modify if needed
    }

    $query = "SELECT * FROM $table WHERE (" . implode(" OR ", $placeholders) . ")";
    if ($id) {
        $query .= " AND id<>?";
        $values[] = $id;
        $types .= "i"; // id is integer
    }

    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, $types, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $errors = [];

            while ($row = mysqli_fetch_assoc($result)) {
                foreach ($fields as $field => $value) {
                    if ($row[$field] === $value) {
                        $errors[$field] = ucfirst($field) . " already exists";
                    }
                }
            }

            mysqli_stmt_close($stmt);

            if (!empty($errors)) {
                return json_encode([
                    "status" => "duplicate",
                    "rows" => count($errors),
                    "errors" => $errors,
                    "message" => "Duplicate fields found"
                ]);
            } else {
                return json_encode([
                    "status" => "unique",
                    "rows" => 0,
                    "message" => "No duplicates found"
                ]);
            }

        } else {
            $error = mysqli_error($conn);
            mysqli_stmt_close($stmt);
            return json_encode([
                "status" => "error",
                "message" => "Query execution failed",
                "error" => $error
            ]);
        }
    } else {
        $error = mysqli_error($conn);
        return json_encode([
            "status" => "error",
            "message" => "Query preparation failed",
            "error" => $error
        ]);
    }
}

function filterInput($input, $type = "string") {

    if (is_array($input)) {
        $filtered = [];
        foreach ($input as $key => $value) {
            $filtered[$key] = filterInput($value, $type);
        }
        return $filtered;
    }

    switch ($type) {
        case "int":
        case "integer":
            return filter_var($input, FILTER_VALIDATE_INT);

        case "float":
        case "double":
            return filter_var($input, FILTER_VALIDATE_FLOAT);

        case "email":
            return filter_var($input, FILTER_VALIDATE_EMAIL);

        case "url":
            return filter_var($input, FILTER_VALIDATE_URL);

        case "boolean":
        case "bool":
            return filter_var($input, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        case "string":
            return filter_var($input, FILTER_SANITIZE_STRING);

        case "text":
            return filter_var($input, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        case "date":
            $d = DateTime::createFromFormat('Y-m-d', $input);
            return $d && $d->format('Y-m-d') === $input ? $input : false;

        case "datetime":
            $d = DateTime::createFromFormat('Y-m-d H:i:s', $input);
            return $d && $d->format('Y-m-d H:i:s') === $input ? $input : false;

        default:
            return htmlspecialchars(strip_tags($input));
    }
}

// $inputs = [
//     "name" => "<b>John Doe</b>",
//     "age" => "25",
//     "email" => "john@example.com",
//     "is_active" => "1",
//     "dob" => "1998-05-12"
// ];

// $types = [
//     "name" => "string",
//     "age" => "int",
//     "email" => "email",
//     "is_active" => "bool",
//     "dob" => "date"
// ];

// // Filter all
// $filteredInputs = [];
// foreach ($inputs as $key => $value) {
//     $filteredInputs[$key] = filterInput($value, $types[$key]);
// }

// print_r($filteredInputs);


function getselectdata($tablename) {
    // $allowed_tables = ['fine_locations', 'broad_locations', 'user_types', 'domains'];
    // if (!in_array($tablename, $allowed_tables)) {
    //     return ['status' => 'error', 'message' => 'Invalid table name'];
    // }
   
    global $conn;

    $query = "SELECT * FROM $tablename";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        return ['status' => 'error', 'message' => mysqli_error($conn)];
    }

    if (mysqli_num_rows($result) === 0) {
        return [];
    }

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function checkdata($data, $columnname) {
    if (isset($data['status']) && $data['status'] === 'error') {
        header('Content-Type: application/json');
        echo json_encode($data);
    } elseif (empty($data)) {
        echo '<option>No data found</option>';
    } else {
        echo '<option value="">Select</option>';
        foreach ($data as $row) {
            
            echo '<option value="' . $row[$columnname] . '">' . $row[$columnname] . '</option>';
        }
    }
}

// -----------------------------------------------
// helpers.php – Generic Helper Functions
// -----------------------------------------------

// Base URL
function base_url($path = "")
{
    return rtrim($_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/hms/", "/") . "/" . ltrim($path, "/");
}

// Redirect
function redirect($url)
{
    header("Location: " . $url);
    exit;
}

// Format money
function money($amt)
{
    return number_format((float)$amt, 2, '.', ',');
}

// UUID
function uuid()
{
    return bin2hex(random_bytes(16));
}

// JSON response
function json_response($status, $msg, $data = [])
{
    header('Content-Type: application/json');
    echo json_encode([
        "status" => $status,
        "message" => $msg,
        "data" => $data
    ]);
    exit;
}

?>