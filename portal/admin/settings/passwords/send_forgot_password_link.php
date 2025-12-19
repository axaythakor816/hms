<?php
require_once '../../../../core/init.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $genericMsg = "If email exists, reset link has been sent.";

    // 1️⃣ Select user by email
    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $userId);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($userId) {
            // 2️⃣ Generate token and expiry
            $token = bin2hex(random_bytes(32));
            $tokenHash = hash('sha256', $token);
            $expiry = date("Y-m-d H:i:s", strtotime("+30 minutes"));

            // 3️⃣ Update user with token hash and expiry
            $updateSql = "UPDATE users SET reset_token_hash = ?, reset_token_expiry = ? WHERE id = ?";
            $updateStmt = mysqli_prepare($conn, $updateSql);
            if ($updateStmt) {
                mysqli_stmt_bind_param($updateStmt, "ssi", $tokenHash, $expiry, $userId);
                mysqli_stmt_execute($updateStmt);
                mysqli_stmt_close($updateStmt);

                // 4️⃣ Reset link
                $resetLink = "https://yourdomain.com/reset_password.php?token=$token";

                // Send email (mailUser function or PHPMailer)
                // mailUser($email, $resetLink);
            }
        }
    }

    echo $genericMsg;
}
?>
