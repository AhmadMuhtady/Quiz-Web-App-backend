<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Only POST requests are allowed."]);
    exit;
}
include "../../../confiq/connect.php";

$question_id = $_POST["question_id"] ?? null;
$option_text = $_POST["option_text"] ?? null;
$is_correct = $_POST["is_correct"] ?? null;

if (empty($question_id) || empty($option_text) || empty($is_correct)) {
    echo json_encode(["error"=> "question_id, question_text and is_correct are required"]);
    exit;
}

if (!in_array($is_correct, [0, 1], true)) {
    echo json_encode(["error" => "is_correct must be either 0 (false) or 1 (true)."]);
    exit;
}

$check_question_sql = "SELECT question_id FROM questions WHERE question_id = ?";
$check_question_stmt = mysqli_prepare($connection, $check_question_sql);
if ($check_question_stmt) {
    mysqli_stmt_bind_param($check_question_stmt, "i", $question_id);
    mysqli_stmt_execute($check_question_stmt);
    mysqli_stmt_store_result($check_question_stmt);

    if (mysqli_stmt_num_rows($check_question_stmt) === 0) {
        echo json_encode(["error" => "Question not found. Invalid question_id."]);
        exit;
    }
} else {
    echo json_encode(["error" => "Failed to prepare question check statement."]);
    exit;
}

$insert_option_sql = "INSERT INTO options (question_id, option_text, is_correct) VALUES (?, ?, ?)";
$insert_option_stmt = mysqli_prepare($connection, $insert_option_sql);

if ($insert_option_stmt) {
    mysqli_stmt_bind_param($insert_option_stmt, "isi", $question_id, $option_text, $is_correct);
    mysqli_stmt_execute($insert_option_stmt);

    if (mysqli_stmt_affected_rows($insert_option_stmt) > 0) {
        echo json_encode(["success" => true, "message" => "Option created successfully!"]);
    } else {
        echo json_encode(["error" => "Failed to create option."]);
    }
} else {
    echo json_encode(["error" => "Failed to prepare insert statement."]);
}
?>