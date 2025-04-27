<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Only POST requests are allowed."]);
    exit;
}
include "../../../confiq/connect.php";

$quizzes = $_POST["quiz_id"] ?? null;
$question_text = $_POST["question_text"] ?? null;

