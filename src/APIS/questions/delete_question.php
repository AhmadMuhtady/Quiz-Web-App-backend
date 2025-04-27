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