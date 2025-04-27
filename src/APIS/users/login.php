<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Only POST requests are allowed."]);
    exit;
}
include "../../../confiq/connect.php";

$email = $_POST['email'] ?? null;
$password_hash = $_POST['password_hash'] ?? null;

if (empty($email) || empty($password_hash)) {
    echo json_encode(["error" => "Email and password are required."]);
    exit;
}

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    if (password_verify($password_hash, $row['password_hash'])) {
        echo json_encode([
            "success" => true,
            "message" => "Login successful!",
            "user" => [
                "user_id" => $row['user_id'],
                "email" => $row['email']
            ]
        ]);
        