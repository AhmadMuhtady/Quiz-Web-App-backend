<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Only POST requests are allowed."]);
    exit;
}
include "../../../confiq/connect.php";

$quiz_id = $_POST['quiz_id'] ?? null;

if (empty($quiz_id)) {
    echo json_encode(["error" => "question_id is required."]);
    exit;
}

$sql = 'SELECT * FROM questions WHERE quiz_id = ?';
$stmt = mysqli_prepare($connection, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $quiz_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $questions = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $questions[] = $row;
        }
    }

    echo json_encode($questions);
} else {
    echo json_encode(["error" => "Failed to prepare statement."]);
}
?>