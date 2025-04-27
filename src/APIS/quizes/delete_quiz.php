<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Only POST requests are allowed."]);
    exit;
}
include "./../../../confiq/connect.php";

$quiz_id = $_POST['quiz_id'] ?? null;
if (empty($quiz_id)) {
    echo json_encode(["error" => "quiz_id is required."]);
    exit;
}
$sql = "DELETE FROM quizzes WHERE quiz_id = ?";
$stmt = mysqli_prepare($connection, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $quiz_id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo json_encode(["success" => true, "message" => "Quiz deleted successfully!"]);
    } else {
        echo json_encode(["error" => "No quiz found with that ID."]);
    }
} else {
    echo json_encode(["error" => "Failed to prepare statement."]);
}
?>