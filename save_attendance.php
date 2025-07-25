<?php
include("con.php");

$updated_attendance = $_POST['attendance'] ?? [];
$previous_day = $_POST['date'] ?? '';
$department = $_POST['department'] ?? ''; // This is actually dept_id now

$response = ["status" => "success", "message" => "✅ Attendance saved/updated successfully!"];

try {
    foreach ($updated_attendance as $reg_no => $periods) {
        // Check if record exists
        $checkStmt = $conn->prepare("SELECT COUNT(*) 
            FROM attendance 
            WHERE date = ? 
            AND branch = ? 
            AND reg_no = ?
        ");
        $checkStmt->bind_param("sss", $previous_day, $department, $reg_no);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();
            
        if ($count > 0) {
            // Update if record exists
            $stmt = $conn->prepare("UPDATE attendance
                SET period_1=?, period_2=?, period_3=?, period_4=?, period_5=?, period_6=?, period_7=? 
                WHERE date=? AND branch=? AND reg_no=?");
        } else {
            // Insert if not found
            $stmt = $conn->prepare("INSERT INTO attendance 
                (period_1, period_2, period_3, period_4, period_5, period_6, period_7, date, branch, reg_no) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        }

        if (!$stmt) {
            throw new Exception("❌ Statement error: " . $conn->error);
        }

        $stmt->bind_param("ssssssssss",
            $periods[1], $periods[2], $periods[3], $periods[4], $periods[5], $periods[6], $periods[7],
            $previous_day, $department, $reg_no
        );

        if (!$stmt->execute()) {
            throw new Exception("⚠ Error saving attendance for Reg No: $reg_no");
        }

        $stmt->close();
    }

    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

$conn->close();
?>
