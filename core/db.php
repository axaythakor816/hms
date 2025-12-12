<?php

// --------------------------------------
// CRUD – INSERT
// --------------------------------------
function insert($sql, $values, $datatypes) {
    $conn = $GLOBALS['conn'];

    if ($stmt = mysqli_prepare($conn, $sql)) {

        if (!mysqli_stmt_bind_param($stmt, $datatypes, ...$values)) {
            $error = mysqli_stmt_error($stmt);
            mysqli_stmt_close($stmt);
            return ["status" => "error", "message" => "Parameter binding failed : " . $error];
        }

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return ["status" => "success", "message" => "Record inserted successfully"];
        } else {
            $error = mysqli_stmt_error($stmt);
            mysqli_stmt_close($stmt);
            return ["status" => "error", "message" => "Query execution failed" . $error];
        }
    }else{
        return ["status" => "error", "message" => "Query preparation failed : " . mysqli_error($conn)];
    }
}

// --------------------------------------
// CRUD – UPDATE
// --------------------------------------
function update($sql, $values, $datatypes) {
    $conn = $GLOBALS['conn'];

    if ($stmt = mysqli_prepare($conn, $sql)) {

        if (!mysqli_stmt_bind_param($stmt, $datatypes, ...$values)) {
            $error = mysqli_stmt_error($stmt);
            mysqli_stmt_close($stmt);
            return ["status" => "error", "message" => "Parameter binding failed : " . $error];
        }

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return ["status" => "success", "message" => "Record updated successfully"];
        } else {
            $error = mysqli_error($conn);
            mysqli_stmt_close($stmt);
            return ["status" => "error", "message" => "Query execution failed", "error" => $error];
        }

    }else{
        return ["status" => "error", "message" => "Query preparation failed", "error" => mysqli_error($conn)];
    }
}

// --------------------------------------
// CRUD – SELECT
// --------------------------------------
function select($sql, $values = [], $datatypes = "") {
    $conn = $GLOBALS['conn'];

    if ($stmt = mysqli_prepare($conn, $sql)) {

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

            return [
                "status" => "success",
                "message" => "Query executed successfully",
                "rows"   => count($data),
                "data"   => $data
            ];
        }
    }else{
        return ["status" => "error", "message" => "Query failed", "error" => mysqli_error($conn)];
    }
}

// --------------------------------------
// CRUD – DELETE
// --------------------------------------
function delete($sql, $values, $datatypes) {
    $conn = $GLOBALS['conn'];

    if ($stmt = mysqli_prepare($conn, $sql)) {

        if (!mysqli_stmt_bind_param($stmt, $datatypes, ...$values)) {
            $error = mysqli_stmt_error($stmt);
            mysqli_stmt_close($stmt);
            return ["status" => "error", "message" => "Parameter binding failed : " . $error];
        }

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return ["status" => "success", "message" => "Record deleted"];
        } else {
            $error = mysqli_error($conn);
            mysqli_stmt_close($stmt);
            return ["status" => "error", "message" => "Query failed", "error" => $error];
        }
    }else{
        return ["status" => "error", "message" => "Query preparation failed", "error" => mysqli_error($conn)];
    }
}

// --------------------------------------
// Check Duplicate Email / Mobile / Username
// --------------------------------------
function checkDuplicateFields($table, $fields = [], $id = [], $operator = "OR") {

    if (empty($fields)) {
        return ["status" => "error", "message" => "No fields provided"];
    }

    $conditions = [];
    $values = [];
    $types = "";

    foreach ($fields as $field => $value) {
        $conditions[] = "$field = ?";
        $values[] = $value;
        if (is_int($value)) {
            $types .= "i";
        } elseif (is_float($value)) {
            $types .= "d";
        } elseif (is_null($value)) {
            $types .= "s"; 
        } elseif (is_bool($value)) {
            $types .= "i"; 
        } else {
            $types .= "s";
        }
    }

    $where = "(" . implode(" $operator ", $conditions) . ")";

    if (!empty($id)) {
        foreach ($id as $col => $val) {
            $where .= " AND $col <> ?";
            $values[] = $val;

            $types .= is_int($val) ? "i" : (is_float($val) ? "d" : "s");
        }
    }

    $sql = "SELECT * FROM $table WHERE $where";

    $result = select($sql, $values, $types);

    if ($result['status'] !== "success") {
        return ["status" => "error", "message" => $result['message']];
    }

    $errors = [];

    if ($result['rows'] > 0) {
        foreach ($result['data'] as $row) {
            foreach ($fields as $field => $value) {
                if (strtolower($row[$field]) == strtolower($value)) {
                    $errors[$field] = ucfirst($field) . " already exists";
                }
            }
        }
    }

    return empty($errors)
        ? ["status" => "unique"]
        : ["status" => "duplicate", "errors" => $errors];
}

// --------------------------------------
// Generic Select
// --------------------------------------
function getselectdata($tablename) {
    $conn = $GLOBALS['conn'];

    $result = mysqli_query($conn, "SELECT * FROM $tablename");

    if (!$result) {
        return ["status" => "error", "message" => mysqli_error($conn)];
    }

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

?>