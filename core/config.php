<?php
require_once "env.php";

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

if (!$conn) {
    die("DB Connection Failed: " . mysqli_connect_error());
}
