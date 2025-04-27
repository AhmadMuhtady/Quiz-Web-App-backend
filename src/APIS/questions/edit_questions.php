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