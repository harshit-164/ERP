<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('fpdf.php');
require('con.php');

// Validate URL Parameters
if (!isset($_GET['degree']) || !isset($_GET['regulation']) || !isset($_GET['dept']) || !isset($_GET['year']) || !isset($_GET['semester'])) {
    die("Error: Missing required parameters.");
}

$degree = $_GET['degree'];
$regulation = $_GET['regulation'];
$dept = $_GET['dept'];
$year = $_GET['year'];
$semester = $_GET['semester'];

// Fetch Department Name
$deptQuery = "SELECT branch FROM dept WHERE dept_id = ?";
$stmt = $conn->prepare($deptQuery);
$stmt->bind_param("i", $dept);
$stmt->execute();
$deptResult = $stmt->get_result();
if ($deptResult->num_rows == 0) die("Error: No department found.");
$deptName = $deptResult->fetch_assoc()['branch'];

// Fetch Regulation Name
$regQuery = "SELECT regulation FROM regulation WHERE id = ?";
$stmt = $conn->prepare($regQuery);
$stmt->bind_param("i", $regulation);
$stmt->execute();
$regResult = $stmt->get_result();
if ($regResult->num_rows == 0) die("Error: No regulation found.");
$regName = $regResult->fetch_assoc()['regulation'];

// Fetch Student Details
$sql = "SELECT id, reg_no, name FROM students
        WHERE degree = ? AND regulation = ? AND branch = ? AND year = ? AND semester = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("siiii", $degree, $regulation, $dept, $year, $semester);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) die("Error: No students found.");

$students = [];
while ($row = $result->fetch_assoc()) $students[] = $row;

// Fetch Subject Details
$subjectList = [];
$subjectsQuery = "SELECT id,  subject_name, subject_code, L, T, P, credit_points, course_type
                  FROM subject_module
                  WHERE degree = ? AND regulation = ? AND branch = ? AND year = ? AND semester = ?";
$stmt = $conn->prepare($subjectsQuery);
$stmt->bind_param("siiii", $degree, $regulation, $dept, $year, $semester);
$stmt->execute();
$subjectsResult = $stmt->get_result();

while ($subjectRow = $subjectsResult->fetch_assoc()) {
    $subjectList[] = $subjectRow;
}

// Fetch Marks from Internal Table
$studentData = [];
foreach ($students as $student) {
    $regNo = $student['reg_no'];
    $marksQuery = "SELECT subject_id, total_iae, Lab FROM internal WHERE reg_no = ?";
    $stmt = $conn->prepare($marksQuery);
    $stmt->bind_param("s", $regNo);
    $stmt->execute();
    $marksResult = $stmt->get_result();

    $studentData[$regNo] = [
        'reg_no' => $regNo,
        'name' => $student['name'],
        'marks' => array_fill_keys(array_column($subjectList, 'id'), ['total_iae' => '-', 'Lab' => '-'])
    ];

    while ($marksRow = $marksResult->fetch_assoc()) {
        $subjectId = $marksRow['subject_id'];
        if (isset($studentData[$regNo]['marks'][$subjectId])) {
            $studentData[$regNo]['marks'][$subjectId] = [
                'total_iae' => $marksRow['total_iae'],
                'Lab' => $marksRow['Lab']
            ];
        }
    }
}

// Start PDF
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont("Arial", "B", 14);

// Header
$pdf->Image("spcet_logo.png", 10, 10, 30, 30);
$pdf->Cell(0, 10, "St. Peter's College of Engineering and Technology", 0, 1, "C");
$pdf->SetFont("Arial", "I", 10);
$pdf->Cell(0, 7, "(An Autonomous Institution)", 0, 1, "C");
$pdf->Cell(0, 7, "Affiliated to Anna University | Approved by AICTE", 0, 1, "C");
$pdf->Cell(0, 7, "Avadi, Chennai-600054", 0, 1, "C");
$pdf->Ln(10);
$pdf->SetDrawColor(128, 128, 128);
$pdf->SetLineWidth(0.5);
$pdf->Line(10, $pdf->GetY(), 280, $pdf->GetY());
$pdf->Ln(3);

// Title
$pdf->SetFont("Arial", "", 14);
$pdf->Cell(0, 7, "ALL SUBJECT INTERNAL MARK", 0, 1, "L");
$pdf->Ln(3);

// Department Info
$pdf->SetFont("Arial", "", 12);
$pdf->Cell(0, 10, "Degree: $degree  Regulation: $regName  Department: $deptName  Year: $year  Semester: $semester", 0, 1, "L");
$pdf->Ln(7);

// Column widths
$siNoWidth = 10;
$regNoWidth = 25;
$nameWidth = 40;
$pageWidth = 280;
$availableWidth = $pageWidth - ($siNoWidth + $regNoWidth + $nameWidth);

// Count total subject columns
$totalSubjectCols = 0;
foreach ($subjectList as $subject) {
    if ($subject['L'] == 3 && $subject['T'] == 0 && $subject['P'] == 2 && $subject['credit_points'] == 4.0) {
        $totalSubjectCols += 2;
    } elseif (isset($subject['course_type']) && $subject['course_type'] == 'Practical') {
        $totalSubjectCols += 1;
    } else {
        $totalSubjectCols += 1;
    }
}

$markWidth = $totalSubjectCols > 0 ? floor($availableWidth / $totalSubjectCols) : 15;

// Table Header
$pdf->SetFont("Arial", "B", 10);
$pdf->SetFillColor(137, 176, 231);
$pdf->Cell($siNoWidth, 10, "SI.NO", 1, 0, "C", true);
$pdf->Cell($regNoWidth, 10, "Reg No", 1, 0, "C", true);
$pdf->Cell($nameWidth, 10, "Name", 1, 0, "C", true);

foreach ($subjectList as $subject) {
    $subjectName = $subject['subject_code'];

    if ($subject['L'] == 3 && $subject['T'] == 0 && $subject['P'] == 2 && $subject['credit_points'] == 4.0) {
        $pdf->Cell($markWidth, 10, $subjectName . " IAE", 1, 0, "C", true);
        $pdf->Cell($markWidth, 10, $subjectName . " Lab", 1, 0, "C", true);
    } elseif (isset($subject['course_type']) && $subject['course_type'] == 'Practical') {
        $pdf->Cell($markWidth, 10, $subjectName, 1, 0, "C", true);
    } else {
        $pdf->Cell($markWidth, 10, $subjectName, 1, 0, "C", true);
    }
}
$pdf->Ln();

// Table Data
$pdf->SetFont("Arial", "", 10);
$si_no = 1;
foreach ($studentData as $student) {
    if ($pdf->GetY() > 180) {
        $pdf->AddPage('L');
        $pdf->SetFont("Arial", "B", 10);
        $pdf->SetFillColor(137, 176, 231);
        $pdf->Cell($siNoWidth, 10, "SI.NO", 1, 0, "C", true);
        $pdf->Cell($regNoWidth, 10, "Reg No", 1, 0, "C", true);
        $pdf->Cell($nameWidth, 10, "Name", 1, 0, "C", true);

        foreach ($subjectList as $subject) {
            $subjectName = $subject['subject_name'];
            if ($subject['L'] == 3 && $subject['T'] == 0 && $subject['P'] == 2 && $subject['credit_points'] == 4.0) {
                $pdf->Cell($markWidth, 10, $subjectName . " IAE", 1, 0, "C", true);
                $pdf->Cell($markWidth, 10, $subjectName . " Lab", 1, 0, "C", true);
            } elseif (isset($subject['course_type']) && $subject['course_type'] == 'Practical') {
                $pdf->Cell($markWidth, 10, $subjectName . " Lab", 1, 0, "C", true);
            } else {
                $pdf->Cell($markWidth, 10, $subjectName . " IAE", 1, 0, "C", true);
            }
        }
        $pdf->Ln();
        $pdf->SetFont("Arial", "", 10);
    }

    $pdf->Cell($siNoWidth, 10, $si_no, 1, 0, "C");
    $pdf->Cell($regNoWidth, 10, $student['reg_no'], 1, 0, "C");
    $pdf->Cell($nameWidth, 10, $student['name'], 1, 0, "L");

    foreach ($subjectList as $subject) {
        $subjectId = $subject['id'];
        $marks = $student['marks'][$subjectId];

        if ($subject['L'] == 3 && $subject['T'] == 0 && $subject['P'] == 2 && $subject['credit_points'] == 4.0) {
            $pdf->Cell($markWidth, 10, $marks['total_iae'], 1, 0, "C");
            $pdf->Cell($markWidth, 10, $marks['Lab'], 1, 0, "C");
        } elseif (isset($subject['course_type']) && $subject['course_type'] == 'Practical') {
            $pdf->Cell($markWidth, 10, $marks['Lab'], 1, 0, "C");
        } else {
            $pdf->Cell($markWidth, 10, $marks['total_iae'], 1, 0, "C");
        }
    }
    $pdf->Ln();
    $si_no++;
}

// Output PDF
$filename = "All_Internal_Marks_".$degree."_".$regName."_".$deptName."_Year_".$year."_Semester_".$semester.".pdf";
header("Content-Type: application/pdf");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Cache-Control: private, max-age=0, must-revalidate");
header("Pragma: public");

ob_end_clean();
$pdf->Output();
exit;
?>