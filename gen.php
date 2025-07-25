<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

require('fpdf.php');
require('con.php');

// Function to Convert Marks to Grades
function convertToGrade($mark) {
    if ($mark > 90 && $mark <= 100) {
        return 'O';
    } elseif ($mark > 80 && $mark <= 90) {
        return 'A+';
    } elseif ($mark > 70 && $mark <= 80) {
        return 'A';
    } elseif ($mark > 60 && $mark <= 70) {
        return 'B+';
    } elseif ($mark > 55 && $mark <= 60) {
        return 'B';
    } elseif ($mark > 49 && $mark <= 55) {
        return 'C';
    } else {
        return 'U'; // Fail
    }
}

// Function to Get Grade Points
function getGradePoint($grade) {
    switch ($grade) {
        case 'O': return 10;
        case 'A+': return 9;
        case 'A': return 8;
        case 'B+': return 7;
        case 'B': return 6;
        case 'C': return 5;
        default: return 0; // Fail
    }
}

// Validate URL Parameters
if (!isset($_GET['reg_no']) || !isset($_GET['session']) || !isset($_GET['sem'])) {
    die("Error: Missing required parameters. Please check the URL.");
}

$reg_no = $_GET['reg_no'];
$session = $_GET['session'];
$sem = $_GET['sem'];

// Fetch Student Details
$sql = "SELECT s.*, d.branch 
        FROM students s
        LEFT JOIN dept d ON s.branch = d.dept_id
        WHERE s.reg_no = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $reg_no);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Error: No student found with registration number: $reg_no.");
}
$student = $result->fetch_assoc();

// GPA and CGPA Calculation
$sql = "SELECT r.*, s.subject_code, s.credit_points 
        FROM result r
        JOIN subject_module s ON r.subject = s.id
        WHERE r.reg_no = ? AND r.semester = ? AND r.session = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sis", $reg_no, $sem, $session);
$stmt->execute();
$result_data = $stmt->get_result();

$point_arr = [];
$credits_arr = [];
$sem_arr = [];
$overall_result = "PASS";
$arrears = false;

while ($row_r = $result_data->fetch_assoc()) {
    $t_g1 = convertToGrade($row_r["mark"]);
    $t_p1 = getGradePoint($t_g1);
    array_push($point_arr, $t_p1);
    array_push($sem_arr, $row_r["semester"]);
    array_push($credits_arr, $row_r["credit_points"]);

    if ($t_p1 == 0) {
        $arrears = true;
        $overall_result = "FAIL";
    }
}

// Calculate Semester GPA
$semester_weighted_grade_points = 0;
$semester_credits = 0;
for ($i = 0; $i < count($sem_arr); $i++) {
    $semester_credits += $credits_arr[$i];
    $semester_weighted_grade_points += $point_arr[$i] * $credits_arr[$i];
}
$semester_gpa = ($semester_credits > 0) ? $semester_weighted_grade_points / $semester_credits : 0;

// Fixed CGPA Calculation
$sql_semesters = "SELECT DISTINCT semester FROM result WHERE reg_no = ? AND semester <= ? ORDER BY semester";
$stmt_semesters = $conn->prepare($sql_semesters);
$stmt_semesters->bind_param("si", $reg_no, $sem);
$stmt_semesters->execute();
$result_semesters = $stmt_semesters->get_result();

$total_weighted_gpa = 0;
$total_credits = 0;
$cgpa_arrears = false;

while($sem_row = $result_semesters->fetch_assoc()) {
    $current_sem = $sem_row['semester'];
    
    $sql_sem_gpa = "SELECT r.*, s.credit_points 
                   FROM result r
                   JOIN subject_module s ON r.subject = s.id
                   WHERE r.reg_no = ? AND r.semester = ?";
    $stmt_sem_gpa = $conn->prepare($sql_sem_gpa);
    $stmt_sem_gpa->bind_param("si", $reg_no, $current_sem);
    $stmt_sem_gpa->execute();
    $result_sem_gpa = $stmt_sem_gpa->get_result();
    
    $sem_weighted_grade_points = 0;
    $sem_credits = 0;
    $sem_has_arrears = false;
    
    while($row_sem = $result_sem_gpa->fetch_assoc()) {
        $grade = convertToGrade($row_sem["mark"]);
        $grade_point = getGradePoint($grade);
        $credits = $row_sem["credit_points"];
        
        $sem_credits += $credits;
        $sem_weighted_grade_points += $grade_point * $credits;
        
        if ($grade_point == 0) {
            $sem_has_arrears = true;
            $cgpa_arrears = true;
        }
    }
    
    $sem_gpa = ($sem_credits > 0) ? $sem_weighted_grade_points / $sem_credits : 0;
    
    $total_weighted_gpa += $sem_gpa * $sem_credits;
    $total_credits += $sem_credits;
}

$cgpa = ($total_credits > 0) ? $total_weighted_gpa / $total_credits : 0;

// Fetch ALL results including arrears from previous semesters
$sql_result = "SELECT r.semester, r.mark, s.subject_code, s.credit_points
               FROM result r
               JOIN subject_module s ON r.subject = s.id
               WHERE r.reg_no = ? AND r.session = ? 
               AND (r.semester = ? OR 
                   (r.mark < 50 AND r.semester < ? AND NOT EXISTS (
                       SELECT 1 FROM result r2 
                       WHERE r2.reg_no = r.reg_no 
                       AND r2.subject = r.subject 
                       AND r2.session = r.session
                       AND r2.semester > r.semester 
                       AND r2.mark >= 50
                   ))
               )
               ORDER BY r.semester, s.subject_code";
$stmt = $conn->prepare($sql_result);
$stmt->bind_param("ssii", $reg_no, $session, $sem, $sem);
$stmt->execute();
$result_data = $stmt->get_result();

if ($result_data->num_rows == 0) {
    die("Error: No results found for Registration No: $reg_no, Session: $session, Semester: $sem.");
}

// Process Result Data
$semester_data = [];
$has_fail = false;
$current_semester_fail = false;

while ($row = $result_data->fetch_assoc()) {
    $grade = convertToGrade($row['mark']);
    $grade_point = getGradePoint($grade);
    $passed = ($grade_point > 0);
    
    if (!$passed) {
        $has_fail = true;
        if ($row['semester'] == $sem) {
            $current_semester_fail = true;
        }
    }
    
    $semester_data[] = [
        'semester' => $row['semester'],
        'subject_code' => $row['subject_code'],
        'grade' => $grade,
        'result' => $passed ? "PASS" : "FAIL",
        'credits' => $row['credit_points'],
        'is_arrear' => ($row['semester'] < $sem && !$passed)
    ];
}

// Generate PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont("Arial", "B", 16);

// College Header
$pdf->Image("spcet_logo.png", 10, 10, 30, 30);
$pdf->Cell(0, 10, "St. Peter's College of Engineering and Technology", 0, 1, "C");
$pdf->SetFont("Arial", "I", 10);
$pdf->Cell(0, 7, "(An Autonomous Institution)", 0, 1, "C");
$pdf->Cell(0, 7, "Affiliated to Anna University | Approved by AICTE", 0, 1, "C");
$pdf->Cell(0, 7, "Avadi, Chennai-600054", 0, 1, "C");
$pdf->Ln(10);
$pdf->SetDrawColor(128, 128, 128);
$pdf->SetLineWidth(0.5);
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());

// Result Title
$pdf->Ln(3);
$pdf->SetFont("Arial", "", 16);
$pdf->Cell(0, 7, "Result", 0, 1, "L");
$pdf->Ln(3);

// Student Information
$pdf->SetFont("Arial", "", 12);
$pdf->Cell(0, 10, "Name: " . $student['name'], 0, 1, "L");
$pdf->Cell(0, 10, "Register Number: " . $student['reg_no'], 0, 1, "L");
$pdf->Cell(0, 10, "Branch: " . $student['branch'], 0, 1, "L");
$pdf->Ln(7);

// Table Header
$pdf->SetFont("Arial", "B", 12);
$pdf->SetFillColor(137, 176, 231);
$pdf->Cell(30, 10, "Semester", 1, 0, "C", true);
$pdf->Cell(45, 10, "Subject Code", 1, 0, "C", true);
//$pdf->Cell(30, 10, "Credits", 1, 0, "C", true);
$pdf->Cell(30, 10, "Grade", 1, 0, "C", true);
$pdf->Cell(55, 10, "Result", 1, 1, "C", true);
$pdf->SetFont("Arial", "", 12);

// Table Data
foreach ($semester_data as $data) {
    // Highlight arrears in red
    if ($data['is_arrear']) {
        $pdf->SetFillColor(255, 200, 200); // Light red for arrears
    } else {
        $pdf->SetFillColor(255, 255, 255); // White for normal
    }
    
    $pdf->Cell(30, 10, $data['semester'], 1, 0, "C", true);
    $pdf->Cell(45, 10, $data['subject_code'], 1, 0, "C", true);
    //$pdf->Cell(30, 10, $data['credits'], 1, 0, "C", true);
    $pdf->Cell(30, 10, $data['grade'], 1, 0, "C", true);
    
    // Color code result (red for fail, green for pass)
    if ($data['result'] == "FAIL") {
        $pdf->SetTextColor(255, 0, 0);
    } else {
        $pdf->SetTextColor(0, 128, 0);
    }
    $pdf->Cell(55, 10, $data['result'], 1, 1, "C", true);
    $pdf->SetTextColor(0, 0, 0); // Reset color
}

// Result Summary Section
$pdf->Ln(10);
$pdf->SetFont("Arial", "B", 14);
$pdf->Cell(0, 10, "Result Summary", 0, 1, "L");
$pdf->SetFont("Arial", "", 12);

// Summary box
$pdf->SetFillColor(240, 240, 240);
$pdf->SetDrawColor(180, 180, 180);
$pdf->SetLineWidth(0.3);

$summary_width = 150;
$summary_height = $has_fail ? 35 : 35; // Extra space for arrears notice
$summary_x = ($pdf->GetPageWidth() - $summary_width) / 2;

$pdf->Rect($summary_x, $pdf->GetY(), $summary_width, $summary_height, 'DF');

// Semester Result
$pdf->SetXY($summary_x + 5, $pdf->GetY() + 5);
$pdf->Cell(80, 8, "Semester Result: ", 0, 0, "L");
$pdf->SetFont("Arial", "B", 12);
$pdf->SetTextColor($overall_result == "PASS" ? 0 : 255, $overall_result == "PASS" ? 128 : 0, 0);
$pdf->Cell(40, 8, $overall_result, 0, 1, "L");
$pdf->SetTextColor(0, 0, 0);

// GPA
$pdf->SetFont("Arial", "", 12);
$pdf->SetXY($summary_x + 5, $pdf->GetY() + 2);
$pdf->Cell(80, 8, "GPA (This Semester): ", 0, 0, "L");
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(40, 8, $current_semester_fail ? "-" :round($semester_gpa, 2), 0, 1, "L");

// CGPA
$pdf->SetFont("Arial", "", 12);
$pdf->SetXY($summary_x + 5, $pdf->GetY() + 2);
$pdf->Cell(80, 8, "CGPA (Cumulative): ", 0, 0, "L");
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(40, 8, $current_semester_fail ? "-" : round($cgpa, 2), 0, 1, "L");

// Arrears Notice if applicable
// if ($has_fail) {
//     $pdf->SetXY($summary_x + 5, $pdf->GetY() + 2);
//     $pdf->SetFont("Arial", "I", 10);
//     $pdf->SetTextColor(255, 0, 0);
//     $pdf->Cell(0, 8, "Note: Student has pending arrears from previous semesters", 0, 1, "L");
//     $pdf->SetTextColor(0, 0, 0);
// }

// Force PDF Download
$filename = "Result_" . $student['reg_no'] . "_Sem" . $sem . ".pdf";
header("Content-Type: application/pdf");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Cache-Control: private, max-age=0, must-revalidate");
header("Pragma: public");

ob_end_clean();
$pdf->Output();
exit;