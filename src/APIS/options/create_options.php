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

