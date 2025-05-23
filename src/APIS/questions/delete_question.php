<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Only POST requests are allowed."]);
    exit;
}
include "../../../confiq/connect.php";

$question_id = $_POST['question_id'] ?? null;

if (empty($question_id)) {
    echo json_encode(["error" => "question_id is required."]);
    exit;
}

$sql = "DELETE FROM questions WHERE question_id = ?";
$stmt = mysqli_prepare($connection, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $question_id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo json_encode(["success" => true, "message" => "Question deleted successfully!"]);
    } else {
        echo json_encode(["error" => "No question found with that ID."]);
    }
} else {
    echo json_encode(["error" => "Failed to prepare statement."]);
}
?>
