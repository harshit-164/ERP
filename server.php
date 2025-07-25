<?php
//session_start();
if (session_status() === PHP_SESSION_NONE) session_start();
// DB Connection
$host = 'localhost:4306';
$user = 'root';
$password = ''; // default for XAMPP
$database = 'erp'; // your DB name

$db = mysqli_connect($host, $user, $password, $database);

if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Set student_id for demo/testing
if (!isset($_SESSION['student_id'])) {
    $_SESSION['student_id'] = 1; // change this to a valid ID from your `students` table
}
?>
