<?php
$host = 'localhost';
$db = 'db_web_app';
$user = 'root@localhost';
$pass = '';
$charset = 'utf8mb4';

$connection = mysqli_connect($host, $user, $pass, $db);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

