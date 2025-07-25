<?php
include("con.php"); // Ensure database connection

// Fetch and sanitize input data
//$batch = trim($_POST["batch"] ?? "");
//$dept = trim($_POST["dept"] ?? "");
//$date = trim($_POST["date"] ?? "");
//$year = trim($_POST["year"] ?? "");


$batch = "2021";
$dept = "1";
$date = "04-30-2025";
$year = '4';
echo "hello";
// Debugging: Log received values
error_log("Received Data: batch=$batch, dept=$dept, date=$date");

// Check if required fields are missing
if (empty($batch) || empty($dept) || empty($date)) {
    die("<p style='color:red;'>⚠ Missing required fields.</p>");
}

// Fix batch format if only year is sent
if (preg_match('/^(\d{4})$/', $batch, $matches)) {
    $batch = $matches[1];
}

// Fetch students from the database
$stmt = $conn->prepare("SELECT 
    s.reg_no, 
    s.name 
FROM 
    students s
JOIN 
    dept d ON s.branch = d.dept_id
WHERE 
    s.batch = ? 
    AND d.dept_id = ? 
    AND s.year = ?;
");
echo "test";
// if (!$stmt) {
    // die("Prepare failed (student fetch): (" . $conn->errno . ") " . $conn->error);
// }
// $stmt->bind_param("sss", $batch, $dept, $year);
// $stmt->execute();
// $result = $stmt->get_result();

// $attendanceStmt = $conn->prepare("SELECT a.reg_no, a.period_1, a.period_2, a.period_3, a.period_4, a.period_5, a.period_6, a.period_7 FROM attendance a JOIN dept d ON a.branch = d.dept_id WHERE a.date = ? AND d.branch = ?");
$attendanceStmt=$conn->prepare("SELECT a.reg_no, a.period_1, a.period_2, a.period_3, a.period_4, a.period_5, a.period_6, a.period_7
FROM attendance a
JOIN dept d ON a.branch = d.dept_id
WHERE a.date = ? AND d.branch = ?
");

echo "test3";
// if (!$attendanceStmt) {
//     die("Prepare failed (attendance fetch): (" . $conn->errno . ") " . $conn->error);
// }
// $attendanceStmt->bind_param("ss", $date, $dept);
// $attendanceStmt->execute();
// $attendanceResult = $attendanceStmt->get_result();


// // Store in associative array by Reg number
// while ($attendanceRow = $attendanceResult->fetch_assoc()) {
//     $attendanceData[$attendanceRow['reg_no']] = $attendanceRow;
// }

// if ($result->num_rows > 0) {
//     echo "<form id='attendanceForm'>";

//     // Add hidden fields
//     echo "<input type='hidden' name='date' value='" . htmlspecialchars($date) . "'>";
//     echo "<input type='hidden' name='department' value='" . htmlspecialchars($dept) . "'>";

//     echo "<table border='1' width='100%' cellpadding='8' style='border-collapse: collapse; text-align: center; margin-top: 70px;'>";
//     echo "<tr style='background-color: #333; color: white; text-align: center;'>";
//     echo "<th>S.No</th><th>Reg No</th><th>Student Name</th>";

//     // Create columns for each period
//     for ($i = 1; $i <= 7; $i++) {
//         echo "<th>Period $i</th>";
//     }
//     echo "</tr>";

//     $count = 1;
//     while ($row = $result->fetch_assoc()) {
//         $studentReg = $row['reg_no'];
//         echo "<tr style='background-color: #f9f9f9; text-align: center;'>";
//         echo "<td>$count</td>";
//         echo "<td>" . $studentReg . "</td>";
//         echo "<td>" . htmlspecialchars($row['name']) . "</td>";

//         // Loop through periods and set default selected option based on saved attendance
//         for ($i = 1; $i <= 7; $i++) {
//             $periodKey = "period_$i";
//             $attendanceStatus = isset($attendanceData[$studentReg][$periodKey]) ? $attendanceData[$studentReg][$periodKey] : '';

//             echo "<td><select name='attendance[" . $studentReg . "][" . $i . "]' style='width: 50px;'>";
//             echo "<option value='P' " . ($attendanceStatus == 'P' ? 'selected' : '') . ">P</option>";
//             echo "<option value='A' " . ($attendanceStatus == 'A' ? 'selected' : '') . ">A</option>";
//             echo "<option value='OD' " . ($attendanceStatus == 'OD' ? 'selected' : '') . ">OD</option>";
//             echo "<option value='H' " . ($attendanceStatus == 'H' ? 'selected' : '') . ">H</option>";
//             echo "</select></td>";
//         }
//         echo "</tr>";
//         $count++;
//     }
//     echo "</table><br>";

//     echo "<button type='submit' id='submitAttendance' style='background-color: #333; color: white; padding: 10px 20px; border: none; cursor: pointer;'>Submit</button>";
//     echo "</form>";
// } else {
//     echo "<p style='color:red;'>⚠ No students found for the selected batch ($batch) and department ($dept).</p>";
// }

// // Clean up
// $stmt->close();
// $attendanceStmt->close();
// $conn->close();
?>
