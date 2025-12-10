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
function checkDuplicateFields($table, $fields = [], $id = null) {
    $conn = $GLOBALS['conn'];

    if (empty($fields)) {
        return ["status" => "error", "message" => "No fields provided"];
    }

    $placeholders = [];
    $values = [];
    $types = "";

    foreach ($fields as $field => $value) {
        $placeholders[] = "$field=?";
        $values[] = $value;
        $types .= "s";
    }

    $query = "SELECT * FROM $table WHERE (" . implode(" OR ", $placeholders) . ")";

    if ($id) {
        $query .= " AND id<>?";
        $values[] = $id;
        $types .= "i";
    }

    if ($stmt = mysqli_prepare($conn, $query)) {

        mysqli_stmt_bind_param($stmt, $types, ...$values);

        if (mysqli_stmt_execute($stmt)) {

            $result = mysqli_stmt_get_result($stmt);
            $errors = [];

            while ($row = mysqli_fetch_assoc($result)) {
                foreach ($fields as $field => $value) {
                    if ($row[$field] == $value) {
                        $errors[$field] = ucfirst($field) . " already exists";
                    }
                }
            }

            mysqli_stmt_close($stmt);

            return empty($errors)
                ? ["status" => "unique"]
                : ["status" => "duplicate", "errors" => $errors];
        }
    }

    return ["status" => "error", "message" => mysqli_error($conn)];
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