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

function validate($data, $rules)
{
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
            }

            // -------------------------
            // email
            // -------------------------
            if ($rule === 'email' && $value !== '' &&
                !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$field][] = "Invalid email format.";
            }

            // -------------------------
            // only letters (Name)
            // -------------------------
            if ($rule === 'name' && $value !== '' &&
                !preg_match('/^[A-Za-z ]+$/', $value)) {
                $errors[$field][] = "Name must contain only letters.";
            }

            // -------------------------
            // username (letters, numbers, _)
            // -------------------------
            if ($rule === 'username' && $value !== '' &&
                !preg_match('/^[A-Za-z0-9_]{3,20}$/', $value)) {
                $errors[$field][] = "Invalid username (only letters, numbers, underscore allowed).";
            }

            // -------------------------
            // mobile: 10 digits
            // -------------------------
            if ($rule === 'mobile' && $value !== '' &&
                !preg_match('/^[0-9]{10}$/', $value)) {
                $errors[$field][] = "Invalid mobile number (10 digits required).";
            }

            // -------------------------
            // numeric
            // -------------------------
            if ($rule === 'numeric' && $value !== '' &&
                !is_numeric($value)) {
                $errors[$field][] = ucfirst($field) . " must be numeric.";
            }

            // -------------------------
            // digits:6 (pincode)
            // -------------------------
            if (strpos($rule, 'digits:') === 0) {
                $digit = (int) explode(':', $rule)[1];
                if (!preg_match('/^[0-9]{'.$digit.'}$/', $value)) {
                    $errors[$field][] = ucfirst($field) . " must be $digit digits.";
                }
            }

            // -------------------------
            // strong password (A-Z, a-z, 0-9, symbol)
            // -------------------------
            if ($rule === 'password_strong' && $value !== '' &&
                !preg_match('/^(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*\W).{6,}$/', $value)) {

                $errors[$field][] = "Password must contain uppercase, lowercase, digit & special char.";
            }

            // -------------------------
            // confirm password match
            // match:password
            // -------------------------
            if (strpos($rule, 'match:') === 0) {
                $matchField = explode(':', $rule)[1];
                if ($value !== ($data[$matchField] ?? '')) {
                    $errors[$field][] = ucfirst($field) . " must match " . ucfirst($matchField) . ".";
                }
            }

            // -------------------------
            // date (yyyy-mm-dd)
            // -------------------------
            if ($rule === 'date' && $value !== '' &&
                !preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
                $errors[$field][] = "Invalid date format (YYYY-MM-DD).";
            }

            // -------------------------
            // min length
            // -------------------------
            if (strpos($rule, 'min:') === 0) {
                $min = (int) explode(':', $rule)[1];
                if (strlen($value) < $min) {
                    $errors[$field][] = ucfirst($field) . " must be at least $min characters.";
                }
            }

            // -------------------------
            // max length
            // -------------------------
            if (strpos($rule, 'max:') === 0) {
                $max = (int) explode(':', $rule)[1];
                if (strlen($value) > $max) {
                    $errors[$field][] = ucfirst($field) . " must not exceed $max characters.";
                }
            }

            // -------------------------
            // min_value (number)
            // -------------------------
            if (strpos($rule, 'min_value:') === 0) {
                $min = (int) explode(':', $rule)[1];
                if (is_numeric($value) && $value < $min) {
                    $errors[$field][] = ucfirst($field) . " must be at least $min.";
                }
            }

            // -------------------------
            // max_value (number)
            // -------------------------
            if (strpos($rule, 'max_value:') === 0) {
                $max = (int) explode(':', $rule)[1];
                if (is_numeric($value) && $value > $max) {
                    $errors[$field][] = ucfirst($field) . " must not exceed $max.";
                }
            }

            // -------------------------
            // custom pattern (regex:/.../)
            // -------------------------
            if (strpos($rule, 'regex:') === 0) {
                $pattern = substr($rule, 6); // regex:/pattern/
                if (!preg_match($pattern, $value)) {
                    $errors[$field][] = ucfirst($field) . " format is invalid.";
                }
            }
        }
    }

    return $errors;
}


// --------------------------------------
// Base URL
// --------------------------------------
function base_url($path = "")
{
    return rtrim($_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/hms/", "/") . "/" . ltrim($path, "/");
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
function js_redirect($url) {
    echo "<script>window.location.href='$url';</script>";
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

function alert($type, $msg) {
    $bs_class = ($type == "success") ? "alert-success" : "alert-danger";

    echo <<<alert
    <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
      <strong class="me-3">$msg</strong> 
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  alert;
}

?>

