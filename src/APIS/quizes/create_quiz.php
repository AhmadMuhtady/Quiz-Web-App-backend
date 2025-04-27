<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Only POST requests are allowed."]);
    exit;
}
include "./../../../confiq/connect.php";

$title = $_POST['title'] ?? null;
$discription = $_POST['discription'] ?? null;
$created_by = $_POST['created_by'] ?? null;

if (empty($title) || empty($discription) || empty($created_by)) {   
    echo json_encode(["error" => "Missing required fields"]);
    exit;
    