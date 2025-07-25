<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('fpdf.php');
require('con.php');

// Validate URL Parameters
if (!isset($_GET['regulation']) || !isset($_GET['dept']) || !isset($_GET['year']) || !isset($_GET['semester'])) {
    die("Error: Missing required parameters.");
}
$degree = $_GET['degree'];
$regulation = $_GET['regulation'];
$dept = $_GET['dept'];
$year = $_GET['year'];
$semester = $_GET['semester'];

// $regulation = $_GET['regulation'];
// $dept = $_GET['dept'];
// $year = $_GET['year'];
// $semester = $_GET['semester'];
// $degree = isset($_GET['degree']) ? $_GET['degree'] : '';

// Fetch Department Name
$deptQuery = "SELECT branch FROM dept WHERE dept_id = ?";
$stmt = $conn->prepare($deptQuery);
$stmt->bind_param("i", $dept);
$stmt->execute();
$deptResult = $stmt->get_result();
if ($deptResult->num_rows == 0) die("Error: No department found.");
$deptName = $deptResult->fetch_assoc()['branch'];

// Fetch Student Details
$sql = "SELECT s.id, s.reg_no, s.name FROM students s
        WHERE s.degree = ? AND s.regulation = ? AND s.branch = ? AND s.year = ? AND s.semester = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("siiii", $degree, $regulation, $dept, $year, $semester);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) die("Error: No students found.");

$students = [];
while ($row = $result->fetch_assoc()) $students[] = $row;

// Fetch Subject Details
$subjectList = [];
$subjectsQuery = "SELECT id, subject_name, subject_code, L, T, P, credit_points, course_type
                  FROM subject_module
                  WHERE degree = ? AND regulation = ? AND branch = ? AND year = ? AND semester = ?";
$stmt = $conn->prepare($subjectsQuery);
$stmt->bind_param("siiii", $degree, $regulation, $dept, $year, $semester);
$stmt->execute();
$subjectsResult = $stmt->get_result();

while ($subjectRow = $subjectsResult->fetch_assoc()) {
    $subjectList[] = $subjectRow;
}

// Fetch Marks from EXTERNAL Table (using theory_mark and lab_mark columns)
$studentData = [];
foreach ($students as $student) {
    $regNo = $student['reg_no'];
    $marksQuery = "SELECT subject_id, theory_mark, lab_mark FROM external WHERE reg_no = ?";
    $stmt = $conn->prepare($marksQuery);
    $stmt->bind_param("s", $regNo);
    $stmt->execute();
    $marksResult = $stmt->get_result();

    $studentData[$regNo] = [
        'reg_no' => $student['reg_no'],
        'name' => $student['name'],
        'marks' => array_fill_keys(array_column($subjectList, 'id'), ['theory_mark' => '-', 'lab_mark' => '-'])
    ];

    while ($marksRow = $marksResult->fetch_assoc()) {
        $subjectId = $marksRow['subject_id'];
        if (isset($studentData[$regNo]['marks'][$subjectId])) {
            // Handle different subject types
            $subjectInfo = null;
            foreach ($subjectList as $sub) {
                if ($sub['id'] == $subjectId) {
                    $subjectInfo = $sub;
                    break;
                }
            }
            
            if ($subjectInfo) {
                if ($subjectInfo['L'] == 3 && 
                    $subjectInfo['T'] == 0 && 
                    $subjectInfo['P'] == 2 && 
                    $subjectInfo['credit_points'] == 4.0) {
                    // Combined theory+lab subject
                    $studentData[$regNo]['marks'][$subjectId] = [
                        'theory_mark' => $marksRow['theory_mark'],
                        'lab_mark' => $marksRow['lab_mark']
                    ];
                } elseif (isset($subjectInfo['course_type']) && $subjectInfo['course_type'] == 'Practical') {
                    // Lab only subject
                    $studentData[$regNo]['marks'][$subjectId] = [
                        'theory_mark' => '-',
                        'lab_mark' => $marksRow['lab_mark']
                    ];
                } else {
                    // Theory only subject
                    $studentData[$regNo]['marks'][$subjectId] = [
                        'theory_mark' => $marksRow['theory_mark'],
                        'lab_mark' => '-'
                    ];
                }
            }
        }
    }
}

// Start PDF (Landscape orientation like internaldownload.php)
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont("Arial", "B", 14);

// Header (same design as internaldownload.php)
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

// Title (changed to EXTERNAL MARK)
$pdf->SetFont("Arial", "", 14);
$pdf->Cell(0, 7, "EXTERNAL MARK", 0, 1, "L");
$pdf->Ln(3);

// Department Info
$pdf->SetFont("Arial", "", 12);
$pdf->Cell(0, 10, "Department: $deptName  Year: $year  Semester: $semester", 0, 1, "L");
$pdf->Ln(7);

// Column widths (same as internaldownload.php)
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
    $subjectCode = $subject['subject_code'];

    if ($subject['L'] == 3 && $subject['T'] == 0 && $subject['P'] == 2 && $subject['credit_points'] == 4.0) {
        $pdf->Cell($markWidth, 10, $subjectCode . " Theory", 1, 0, "C", true);
        $pdf->Cell($markWidth, 10, $subjectCode . " Lab", 1, 0, "C", true);
    } elseif (isset($subject['course_type']) && $subject['course_type'] == 'Practical') {
        $pdf->Cell($markWidth, 10, $subjectCode, 1, 0, "C", true);
    } else {
        $pdf->Cell($markWidth, 10, $subjectCode, 1, 0, "C", true);
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
            $subjectCode = $subject['subject_code'];
            if ($subject['L'] == 3 && $subject['T'] == 0 && $subject['P'] == 2 && $subject['credit_points'] == 4.0) {
                $pdf->Cell($markWidth, 10, $subjectCode . " Theory", 1, 0, "C", true);
                $pdf->Cell($markWidth, 10, $subjectCode . " Lab", 1, 0, "C", true);
            } elseif (isset($subject['course_type']) && $subject['course_type'] == 'Practical') {
                $pdf->Cell($markWidth, 10, $subjectCode . " Lab", 1, 0, "C", true);
            } else {
                $pdf->Cell($markWidth, 10, $subjectCode . " Theory", 1, 0, "C", true);
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
            $pdf->Cell($markWidth, 10, $marks['theory_mark'], 1, 0, "C");
            $pdf->Cell($markWidth, 10, $marks['lab_mark'], 1, 0, "C");
        } elseif (isset($subject['course_type']) && $subject['course_type'] == 'Practical') {
            $pdf->Cell($markWidth, 10, $marks['lab_mark'], 1, 0, "C");
        } else {
            $pdf->Cell($markWidth, 10, $marks['theory_mark'], 1, 0, "C");
        }
    }
    $pdf->Ln();
    $si_no++;
}

// Output PDF
$filename = "External_Marks_Semester_" . $semester . ".pdf";
header("Content-Type: application/pdf");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Cache-Control: private, max-age=0, must-revalidate");
header("Pragma: public");

ob_end_clean();
$pdf->Output();
exit;