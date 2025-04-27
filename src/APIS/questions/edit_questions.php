<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Only POST requests are allowed."]);
    exit;
}
include "../../../confiq/connect.php";

$question_id = $_POST['question_id'] ?? null;
$question_text = $_POST['question_text'] ?? null;

if (empty($question_id) || empty($question_text)) {
    echo json_encode(["error" => "Missing required fields."]);
    exit;
}
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "si", $question_text, $question_id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo json_encode(["success" => true, "message" => "Question updated successfully!"]);
    } else {
        echo json_encode(["error" => "No question found with that ID or no change in data."]);
    }
} else {
    echo json_encode(["error" => "Failed to prepare statement."]);
}
?>