<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Only POST requests are allowed."]);
    exit;
}
include "./../../../confiq/connect.php";

$quiz_id = $_POST['quiz_id'] ?? null;
$title = $_POST['title'] ?? null;
$description = $_POST['description'] ?? null;

if (empty($quiz_id) || empty($title) || empty($description)) {
    echo json_encode(["error" => "Missing required fields."]);
    exit;
}

$sql = "UPDATE quizzes SET title = ?, description = ? WHERE quiz_id = ?";
$stmt = mysqli_prepare($connection, $sql);
