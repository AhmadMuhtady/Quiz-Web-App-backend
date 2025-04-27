<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Only POST requests are allowed."]);
    exit;
}
include "./../../../confiq/connect.php";

$quiz_id = $POST['quiz_id'] ?? null;
if (empty($quiz_id)) {
    echo json_encode(["error" => "quiz_id is required."]);
    exit;
}
