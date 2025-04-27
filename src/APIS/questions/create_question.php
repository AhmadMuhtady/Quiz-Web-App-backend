<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Only POST requests are allowed."]);
    exit;
}
include "../../../confiq/connect.php";

$quizzes = $_POST["quiz_id"] ?? null;
$question_text = $_POST["question_text"] ?? null;

if (empty($quiz_id) || empty($question_text)) {
    echo json_encode(["error" => "quiz_id and question_text are required."]);
    exit;
}
$check_quiz_sql = "SELECT quiz_id FROM quizzes WHERE quiz_id = ?";
$check_quiz_stmt = mysqli_prepare($connection, $check_quiz_sql);

if ($check_quiz_stmt) {
    mysqli_stmt_bind_param($check_quiz_stmt, "i", $quiz_id);
    mysqli_stmt_execute($check_quiz_stmt);
    mysqli_stmt_store_result($check_quiz_stmt);

    if (mysqli_stmt_num_rows($check_quiz_stmt) === 0) {
        echo json_encode(["error" => "Quiz not found. Invalid quiz_id."]);
        exit;
    }} else {
        echo json_encode(["error" => "Failed to prepare quiz check statement."]);
        exit;
    }

    $insert_question_sql = "INSERT INTO questions (quiz_id, question_text) VALUES (?, ?)";
$insert_question_stmt = mysqli_prepare($connection, $insert_question_sql);

if ($insert_question_stmt) {
    mysqli_stmt_bind_param($insert_question_stmt, "is", $quiz_id, $question_text);
    mysqli_stmt_execute($insert_question_stmt);

    if (mysqli_stmt_affected_rows($insert_question_stmt) > 0) {
        echo json_encode(["success" => true, "message" => "Question created successfully!"]);
    } else {
        echo json_encode(["error" => "Failed to create question."]);
    }
} else {
    echo json_encode(["error" => "Failed to prepare insert statement."]);
}
?>