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

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssi", $title, $description, $quiz_id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo json_encode(["success" => true, "message" => "Quiz updated successfully!"]);
    } else {
        echo json_encode(["error" => "No quiz found with that ID or no change in data."]);
    }
} else {
    echo json_encode(["error" => "Failed to prepare statement."]);
}
?>