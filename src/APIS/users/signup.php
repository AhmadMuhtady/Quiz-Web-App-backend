<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Only POST requests are allowed."]);
    exit;
}

include '../../../confiq/connect.php';

$first_name = $_POST['first_name'] ?? null;
$last_name = $_POST['last_name'] ?? null;
$email = $_POST['email'] ?? null;
$password_hash = $_POST['password_hash'] ?? null;

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
$hashed_password = password_hash($password_hash, PASSWORD_DEFAULT);
$insert_sql = "INSERT INTO users (first_name,last_name, email, password_hash) VALUES (?, ?,?, ?)";
$insert_stmt = mysqli_prepare($connection, $insert_sql);

if ($insert_stmt) {
    mysqli_stmt_bind_param($insert_stmt, "ssss", $first_name,$last_name, $email, $hashed_password);
    mysqli_stmt_execute($insert_stmt);

    if (mysqli_stmt_affected_rows($insert_stmt) > 0) {
        echo json_encode(["success" => true, "message" => "User registered successfully!"]);
    } else {
        echo json_encode(["error" => "Failed to register user."]);
    }
} else {
    echo json_encode(["error" => "Failed to prepare insert statement."]);
}
?>