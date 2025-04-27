<?php
$host = 'localhost';
$db = 'quiz_web_app';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$connection = mysqli_connect($host, $user, $pass, $db);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error()); 
}else {
    echo "Connected successfully!";
}

