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

if (empty($question_id) || empty($option_text)) || empty($is_correct)) {
    echo json_encode(["error"=> "quiz_id, question_text and is_correct are required"]);
    exit;
}