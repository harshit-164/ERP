<?php
session_start();
// $servername = "localhost:4306"; 
// $username = "root";
// $password = "";
// $dbname = "erp";
include("con.php");
// Create connection
// $connn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// Retrieve and sanitize form data
$degree = $conn->real_escape_string($_GET["degree"]);
$branch = $conn->real_escape_string($_GET["branch"]);
$year = $conn->real_escape_string($_GET["year"]);
$regulation = $conn->real_escape_string($_GET["regulation"]);
$sem = $conn->real_escape_string($_GET["sem"]);

// Query to fetch subjects based on selected criteria
$query = "SELECT id, course_category, course_type, subject_code, subject_name, credit_points, L, T, P 
          FROM subject_module 
          WHERE degree = '$degree' 
          AND branch = '$branch' 
          AND year = '$year' 
          AND regulation = '$regulation' 
          AND semester = '$sem' 
          AND subject_code IS NOT NULL 
          AND subject_name IS NOT NULL"; // Adjust these conditions based on your table structure

$result = $conn->query($query);

$subjects = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Add the row to the subjects array
        $subjects[] = $row;
    }
}

// Return the subjects as a JSON response
header('Content-Type: application/json');
echo json_encode($subjects);

// Close the database connection
$conn->close();
?>