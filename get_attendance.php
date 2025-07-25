<?php
// get_attendance.php

include("con.php");

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from the form
$semester = isset($_POST['semester']) ? $_POST['semester'] : '';
$month = isset($_POST['month']) ? $_POST['month'] : '';
$year = isset($_POST['year']) ? $_POST['year'] : '';
$enrollmentnumber = isset($_POST['h_sid']) ? $_POST['h_sid'] : '';

// Sanitize the input data to prevent SQL injection
$semester = mysqli_real_escape_string($conn, $semester);
$month = mysqli_real_escape_string($conn, $month);
$year = mysqli_real_escape_string($conn, $year);
$enrollmentnumber = mysqli_real_escape_string($conn, $enrollmentnumber);

// Construct the SQL query
$sql = "SELECT * FROM student_attendance WHERE `sid` = '$enrollmentnumber' AND semester = '$semester' AND month = '$month' AND year = '$year'";

$result = mysqli_query($conn, $sql);

// Check if any rows are returned
if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Semester</th><th>Month</th><th>Year</th><th>Total Working Hours</th><th>Hours Attended</th><th>Percentage</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['semester'] . "</td>";
        echo "<td>" . $row['month'] . "</td>";
        echo "<td>" . $row['year'] . "</td>";
        echo "<td>" . $row['totalworkinghours'] . "</td>";
        echo "<td>" . $row['hoursattended'] . "</td>";
        echo "<td>" . $row['percentage'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>No attendance data found for the selected criteria for this student.</p>";
}

// Close the database connection
mysqli_close($conn);
?>