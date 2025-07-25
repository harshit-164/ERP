<?php
require('fpdf/fpdf.php');

// Include the database connection file
include('con.php');

function generateHallTicket($enrollmentNumber) {
    global $conn;

    // Fetch student data
    $sql = "SELECT * FROM students WHERE enrollmentnumber = '$enrollmentNumber'";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Error fetching student data: " . $conn->error);
    }

    if ($result->num_rows == 0) {
        die("Student data not found for Enrollment Number: $enrollmentNumber");
    }
    $studentData = $result->fetch_assoc();

    // Fetch subjects
    $subjectsQuery = "SELECT subject_code, subject_name FROM subject_module 
                    WHERE degree = '" . $studentData['degree'] . "' 
                    AND branch = '" . $studentData['department'] . "' 
                    AND semester = " . $studentData['semester'];

    $subjectsResult = $conn->query($subjectsQuery);
    if ($subjectsResult === false) {
        die("Error fetching subjects: " . $conn->error);
    }

    $subjects = [];
    if ($subjectsResult->num_rows > 0) {
        while ($subjectRow = $subjectsResult->fetch_assoc()) {
            $subjects[] = $subjectRow;
        }
    }
    $studentData['subjects'] = $subjects;

    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AddPage();

    // Header Section
    $pdf->Image('anna_university_logo.png', 10, 5, 30);
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'ANNA UNIVERSITY', 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 4, 'CHENNAI - 600 025', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'UNIVERSITY EXAMINATIONS - April/May Examination, 2024', 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'HALL TICKET', 0, 1, 'C');

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(45, 10, 'Register Number: ', 1, 0);
    $pdf->Cell(40, 10, $studentData['regno'], 1, 0);
    $pdf->Cell(40, 10, 'Current Semester:', 1, 0);
    $pdf->Cell(35, 10,  $studentData['semester'], 1, 0);
    $pdf->Cell(30, 40, '', 1, 0);

    //  Image Handling - Display Default Icon for All Students
    $defaultImagePath = 'student_photo.png';    // Path to default icon
    $pdf->Image($defaultImagePath, 178, 55, 15); // Display default icon

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(40, 10, '', 0, 0);
    $pdf->Cell(60, 10, '', 0, 1);
    
    $pdf->Cell(45, 10, 'Name:', 1, 0);
    $pdf->Cell(115, 10, $studentData['name']  . '                    D.O.B:      ' . $studentData['dateofbirth'], 1, 1);
    $pdf->Cell(45, 10, 'Degree & Branch:', 1, 0);
    $pdf->Cell(115, 10, $studentData['degree'] . ' ' . $studentData['department'], 1, 1);
    $pdf->Cell(45, 10, 'Center:', 1, 0);
    $pdf->Cell(115, 10, 'Center info needs to be added', 1, 0);
    $pdf->Cell(40, 10, '', 0, 0);
    $pdf->Cell(60, 10, '', 0, 1);
    $pdf->Cell(40, 10, '', 0, 0);
    $pdf->Cell(60, 10, '', 0, 1);

    // Subject Details Section
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'SUBJECT DETAILS', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);

    $pdf->Cell(20, 10, 'S.No.', 1, 0);
    $pdf->Cell(30, 10, 'Sem', 1, 0);
    $pdf->Cell(30, 10, 'Subject Code', 1, 0);
    $pdf->Cell(80, 10, 'Subject Title', 1, 0);
    $pdf->Cell(30, 10, 'Exam Date', 1, 1);

    $i = 1;
    foreach ($studentData['subjects'] as $subject) {
        $pdf->Cell(20, 10, $i++, 1, 0);
        $pdf->Cell(30, 10, $studentData['semester'], 1, 0);
        $pdf->Cell(30, 10, $subject['subject_code'], 1, 0);
        $pdf->Cell(80, 10, $subject['subject_name'], 1, 0);
        $pdf->Cell(30, 10, '', 1, 1);  // Exam Date (You'll need to add this)
    }

    // Signature Section
     $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 10, 'No. of Subjects Registered: ' . count($studentData['subjects']), 1, 0);

      $pdf->Cell(40, 10, '', 0, 0);
      $pdf->Cell(60, 10, '', 0, 1);
    

    // Footer Section
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 10, 'Important Note: If any candidate appears for the examination without any approval, the examination written by the candidate will be invalidated', 0, 1);
    $pdf->Cell(40, 10, '', 0, 0);
    $pdf->Cell(60, 10, '', 0, 1);
    $pdf->Cell(40, 10, '', 0, 0);
    $pdf->Cell(60, 10, '', 0, 1);
    $pdf->Cell(40, 10, '', 0, 0);
    $pdf->Cell(60, 10, '', 0, 1);
    $pdf->Cell(40, 10, '', 0, 0);
    $pdf->Cell(60, 10, '', 0, 1);

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(70, 35, 'Signature of the Candidate', 1, 0, 'C');
    $pdf->Cell(65, 35, 'Signature of the Principal with the seal', 1, 0, 'C');
    $pdf->Cell(55, 35, 'Controller of Examinations', 1, 0, 'C');
    $pdf->Cell(40, 10, '', 0, 0);
    $pdf->Cell(60, 10, '', 0, 1);
    $pdf->Cell(40, 10, '', 0, 0);
    $pdf->Cell(60, 10, '', 0, 1);
    $pdf->Cell(40, 10, '', 0, 0);
    $pdf->Cell(60, 10, '', 0, 1);

    $pdf->Cell(0, 19, 'Generated on: ' . date('d-m-Y'), 0, 1, 'C');
    $pdf->Output('hall_ticket.pdf', 'I');
}

// Get the enrollment number
if (isset($_GET['enrollmentnumber'])) {
    $enrollmentNumber = $_GET['enrollmentnumber'];
    generateHallTicket($enrollmentNumber);
} else {
    echo "Enrollment Number is required to generate the Hall Ticket.";
}
?>