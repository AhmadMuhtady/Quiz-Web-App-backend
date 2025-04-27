<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Only POST requests are allowed."]);
    exit;
}
include "./../../../confiq/connect.php";

$title = $_POST['title'] ?? null;
$description = $_POST['description'] ?? null;
$created_by = $_POST['created_by'] ?? null;

if (empty($title) || empty($description) || empty($created_by)) {   
    echo json_encode(["error" => "Missing required fields"]);
    exit;
}
$sql = "INSERT INTO quizzes (title, description, created_by) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($connection, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssi", $title, $description, $created_by);
    mysqli_stmt_execute($stmt);

    echo json_encode(["success" => true, "message" => "Quiz created successfully!"]);
} else {
    echo json_encode(["error" => "Failed to prepare statement."]);
}
?>
