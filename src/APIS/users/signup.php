<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Only POST requests are allowed."]);
    exit;
}

include '../../../confiq/connect.php';

$first_name = $_Post['first_name'] ?? null;
$last_name = $_Post['last_name'] ?? null;
$email = $_Post['email'] ?? null;
$password_hash = $_Post['password_hash'] ?? null;

if (empty($first_name) || empty($last_name) || empty($email) || empty($password_hash)) {
    echo json_encode(["error" => "All fields are required."]);
    exit;
}
$check_sql = "SELECT * FROM users WHERE email = ?";
$check_stmt = mysqli_prepare($connection, $check_sql);
mysqli_stmt_bind_param($check_stmt, "s", $email);
mysqli_stmt_execute($check_stmt);
$check_result = mysqli_stmt_get_result($check_stmt);

if (mysqli_num_rows($check_result) > 0) {
    echo json_encode(["error" => "Email already registered."]);
    exit;
}
