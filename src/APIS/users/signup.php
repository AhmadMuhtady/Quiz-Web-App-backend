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
$check_sql =