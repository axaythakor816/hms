<?php

// --------------------------------------
// Sanitize Input (Array + String)
// --------------------------------------
function filteration($data)
{
    foreach ($data as $key => $value) {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value, ENT_QUOTES);
        $value = strip_tags($value);

        $data[$key] = $value;
    }
    return $data;
}

// --------------------------------------
// Advanced Input Filter
// --------------------------------------
function filterInput($input, $type = "string")
{
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
            return ($d && $d->format('Y-m-d') === $input) ? $input : false;

        case "datetime":
            $d = DateTime::createFromFormat('Y-m-d H:i:s', $input);
            return ($d && $d->format('Y-m-d H:i:s') === $input) ? $input : false;

        default:
            return htmlspecialchars(strip_tags($input), ENT_QUOTES);
    }
}

function validate($data, $rules) {
    $errors = [];

    foreach ($rules as $field => $ruleString) {

        $rulesArray = explode('|', $ruleString);
        $value = trim($data[$field] ?? '');

        foreach ($rulesArray as $rule) {

            // -------------------------
            // required
            // -------------------------
            if ($rule === 'required' && $value === '') {
                $errors[$field][] = ucfirst($field) . " is required.";
                break;
            }

            // -------------------------
            // email
            // -------------------------
            if ($rule === 'email' && $value !== '' &&
                !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$field][] = "Invalid email format.";
                break;
            }

            // -------------------------
            // only letters (Name)
            // -------------------------
            if ($rule === 'name' && $value !== '' &&
                !preg_match('/^[A-Za-z ]+$/', $value)) {
                $errors[$field][] = "Name must contain only letters.";
                break;
            }

            // -------------------------
            // username (letters, numbers, _)
            // -------------------------
           
            if ($rule === 'username' && $value !== '') {

                $isUsername = preg_match('/^[A-Za-z0-9_]{3,20}$/', $value);
                $isMobile   = preg_match('/^[0-9]{10}$/', $value);
                $isEmail    = filter_var($value, FILTER_VALIDATE_EMAIL);

                if (!$isUsername && !$isMobile && !$isEmail) {
                    $errors[$field][] = "Invalid UserName";
                    break;
                }
            }


            // -------------------------
            // mobile: 10 digits
            // -------------------------
            if ($rule === 'mobile' && $value !== '' &&
                !preg_match('/^[0-9]{10}$/', $value)) {
                $errors[$field][] = "Invalid mobile number (10 digits required).";
                break;
            }

            // -------------------------
            // numeric
            // -------------------------
            if ($rule === 'numeric' && $value !== '' &&
                !is_numeric($value)) {
                $errors[$field][] = ucfirst($field) . " must be numeric.";
                break;

            }

            // -------------------------
            // digits:6 (pincode)
            // -------------------------
            if (strpos($rule, 'digits:') === 0) {
                $digit = (int) explode(':', $rule)[1];
                if (!preg_match('/^[0-9]{'.$digit.'}$/', $value)) {
                    $errors[$field][] = ucfirst($field) . " must be $digit digits.";
                break;

                }
            }

            // -------------------------
            // strong password (A-Z, a-z, 0-9, symbol)
            // -------------------------
            if ($rule === 'password_strong' && $value !== '' &&
                !preg_match('/^(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*\W).{6,}$/', $value)) {

                $errors[$field][] = "Password must contain uppercase, lowercase, digit & special char.";
                break;

            }

            // -------------------------
            // confirm password match
            // match:password
            // -------------------------
            if (strpos($rule, 'match:') === 0) {
                $matchField = explode(':', $rule)[1];
                if ($value !== ($data[$matchField] ?? '')) {
                    $errors[$field][] = ucfirst($field) . " must match " . ucfirst($matchField) . ".";
                break;

                }
            }

            // -------------------------
            // date (yyyy-mm-dd)
            // -------------------------
            if ($rule === 'date' && $value !== '' &&
                !preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
                $errors[$field][] = "Invalid date format (YYYY-MM-DD).";
                break;

            }

            // -------------------------
            // min length
            // -------------------------
            if (strpos($rule, 'min:') === 0) {
                $min = (int) explode(':', $rule)[1];
                if (strlen($value) < $min) {
                    $errors[$field][] = ucfirst($field) . " must be at least $min characters.";
                    break;
                    
                }
            }

            // -------------------------
            // max length
            // -------------------------
            if (strpos($rule, 'max:') === 0) {
                $max = (int) explode(':', $rule)[1];
                if (strlen($value) > $max) {
                    $errors[$field][] = ucfirst($field) . " must not exceed $max characters.";
                    break;

                }
            }

            // -------------------------
            // min_value (number)
            // -------------------------
            if (strpos($rule, 'min_value:') === 0) {
                $min = (int) explode(':', $rule)[1];
                if (is_numeric($value) && $value < $min) {
                    $errors[$field][] = ucfirst($field) . " must be at least $min.";
                    break;

                }
            }

            // -------------------------
            // max_value (number)
            // -------------------------
            if (strpos($rule, 'max_value:') === 0) {
                $max = (int) explode(':', $rule)[1];
                if (is_numeric($value) && $value > $max) {
                    $errors[$field][] = ucfirst($field) . " must not exceed $max.";
                    break;

                }
            }

            // -------------------------
            // custom pattern (regex:/.../)
            // -------------------------
            if (strpos($rule, 'regex:') === 0) {
                $pattern = substr($rule, 6); // regex:/pattern/
                if (!preg_match($pattern, $value)) {
                    $errors[$field][] = ucfirst($field) . " format is invalid.";
                    break;

                }
            }
        }
    }

    return $errors;
}

// --------------------------------------
// Delete File
// --------------------------------------
function deletefile($filePath) {
    if (file_exists($filePath) && is_file($filePath)) {
        return unlink($filePath);
    }
    return false;
}

// --------------------------------------
// Check File
// --------------------------------------
function checkfile($fileInputName) {

    if ((!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] != 0)) {
        return false;
    }else{
        return true;
    }

}

// --------------------------------------
// Upload File
// --------------------------------------
function uploadfile($fileInputName, $uploadFolder = "uploads/", $table = "", $id = null, $idcolumn = "", $allowedTypes = ['jpg','jpeg','png','pdf','docx']) {
    global $conn;

    // Ensure upload folder exists
    if (!is_dir($uploadFolder)) {
        mkdir($uploadFolder, 0755, true);
    }

    $oldFileName = "";

    // Fetch old filename if this is an update
    if ($id && $table && $idcolumn) {
        $column = str_replace("edit_", "", $fileInputName);
        $id = intval($id);

        // -----------------------------
        // Prepared Statement
        // -----------------------------
        $sql = "SELECT `$column` FROM `$table` WHERE `$idcolumn` = ? LIMIT 1";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $oldFileName = $row[$column];
            }
            mysqli_stmt_close($stmt);
        } else {
            die("Prepare failed: " . mysqli_error($conn));
        }
    }

    // Check if a new file is uploaded
    if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] !== 0) {
        // No new file uploaded, return old filename (if update) or empty string (if insert)
        return $oldFileName;
    }

    // Get original filename & extension
    $fileName = $_FILES[$fileInputName]['name'];
    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Validate allowed file types
    if (!in_array($ext, $allowedTypes)) {
        return $oldFileName; // invalid type, keep old filename
    }

    // Create unique filename
    $uniqueName = ($id ? $id . "_" : "") . time() . "_" . uniqid() . "." . $ext;

    $targetPath = rtrim($uploadFolder, '/') . '/' . $uniqueName;

    // Move uploaded file
    if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $targetPath)) {

        // Delete old file if updating
        if (!empty($oldFileName)) {
            $oldPath = rtrim($uploadFolder, '/') . '/' . $oldFileName;
            if (file_exists($oldPath) && is_file($oldPath)) {
                unlink($oldPath);
            }
        }

        return $uniqueName;
    }

    // If move failed, return old filename
    return $oldFileName;
}


// --------------------------------------
// Base URL
// --------------------------------------
function base_url($path = "")
{
     $root = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'];

    return rtrim($root, "/") . "/" . ltrim($path, "/");
    // return rtrim($_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/hms/", "/") . "/" . ltrim($path, "/");
}

// --------------------------------------
// Redirect (PHP Based)
// --------------------------------------
function redirect($url)
{
    header("Location: " . $url);
    exit;
}

// --------------------------------------
// Redirect JS Based (Optional)
// --------------------------------------
function js_redirect($url, $delay = 0) {
    echo "<script>
        setTimeout(function() {
            window.location.href = '$url';
        }, $delay);
    </script>";
    exit;
}

// --------------------------------------
// Money Format
// --------------------------------------
function money($amt)
{
    return number_format((float)$amt, 2, '.', ',');
}

// --------------------------------------
// UUID Generator
// --------------------------------------
function uuid()
{
    return bin2hex(random_bytes(16));  // 32 char UUID
}

// --------------------------------------
// JSON Response Helper
// --------------------------------------
function json_response($status, $msg, $data = [], $errors = [])
{
    header('Content-Type: application/json');
    echo json_encode([
        "status" => $status,
        "message" => $msg,
        "data" => $data, 
        "errors" => $errors
    ]);
    exit;
}


function showalert($type = "success", $msg = "Message", $position = "top-center") {
    // Determine Bootstrap class
    $bs_class = ($type === "success") ? "alert-success" : "alert-danger";

    // Position styles
    $positions = [
        "top-left" => "top:20px; left:20px;",
        "top-center" => "top:20px; left:50%; transform:translateX(-50%);",
        "top-right" => "top:20px; right:20px;",
        "bottom-left" => "bottom:20px; left:20px;",
        "bottom-center" => "bottom:20px; left:50%; transform:translateX(-50%);",
        "bottom-right" => "bottom:20px; right:20px;"
    ];

    $posStyle = isset($positions[$position]) ? $positions[$position] : $positions["top-center"];

    echo <<<ALERT
    <div class="custom-alert-wrapper" style="position:fixed; z-index:9999; $posStyle">
        <div class="alert $bs_class alert-dismissible fade show text-center" role="alert" style="min-width:350px; padding:20px; font-size:16px;">
            <strong class="me-3">$msg</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="position:absolute; top:8px; right:10px;"></button>
        </div>
    </div>
    ALERT;
}


?>

