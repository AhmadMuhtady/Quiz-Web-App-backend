<?php
header('Content-Type: application/json');
include "./../../../confiq/connect.php";

$sql - 'SELECT * FROM quizzes';
$result = mysqli_query($connection, $sql);

$quizzes = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $quizzes[] = $row;
    }
}

echo json_encode($quizzes);
?>