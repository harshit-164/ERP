<?php 
include("con.php");

// Fetch regulations, departments, and years
$regulations = mysqli_query($conn, "SELECT * FROM regulation");
$departments = mysqli_query($conn, "SELECT * FROM dept");
$years = mysqli_query($conn, "SELECT * FROM year");


 
// In your PHP code where you fetch subjects:
$subjectsQuery = "SELECT id, subject_code, subject_name, year, semester, regulation, branch,L,T,P, credit_points FROM subject_module";
$result = mysqli_query($conn, $subjectsQuery);
while ($row = mysqli_fetch_assoc($result)) {
    $allSubjects[] =
    ['id' => $row['id'],
    'subject_code' => $row['subject_code'],
    'subject_name' => $row['subject_name'],
    'year' => $row['year'],
    'semester' => $row['semester'],
    'regulation' => $row['regulation'],
    'branch' => $row['branch'],
    'L' => $row['L'], // Include L
    'T' => $row['T'], // Include T
    'P' => $row['P'], // Include P
    'credit_points' => $row['credit_points'], ] ; 
}

// Default values for dropdown selections
$selectedRegulation = $_POST["regulation"] ?? "";
$selectedDept = $_POST["dept"] ?? "";
$selectedYear = $_POST["year"] ?? "";
$selectedSemester = $_POST["semester"] ?? "";
$selectedSubject = $_POST["subject"] ?? "";
$selectedSession = $_POST["session"] ?? "";
$selectedSessionYear = $_POST["sessionyear"] ?? "";
$selectedType = $_POST["type"] ?? "";

// Fetch students when the form is submitted
$students = [];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    if (!empty($selectedYear) && !empty($selectedSemester) && !empty($selectedDept) && !empty($selectedRegulation) && !empty($selectedSession) && !empty($selectedSessionYear)) {
        $studentsQuery = "SELECT id, name, reg_no FROM students
                          WHERE year = '$selectedYear' AND semester = '$selectedSemester' 
                          AND branch = '$selectedDept' AND regulation = '$selectedRegulation'";
        $students = mysqli_query($conn, $studentsQuery);
    }
}

function getGrade($mark) {
    if ($mark >= 91) return 'O';
    elseif ($mark >= 81) return 'A+';
    elseif ($mark >= 71) return 'A';
    elseif ($mark >= 61) return 'B+';
    elseif ($mark >= 57) return 'B';
    elseif ($mark >= 50) return 'C';
    else return 'U';
}
?>
<!DOCTYPE html>
<html lang="en">
    <?php include("head.php") ?>
    <body>
        <?php include("nav.php") ?>
         
        <div class="frame_body">
            <?php include("sidenav.php"); ?>
            <div class="cnt_frame_main">
                <div class="cnt_frame_inner">
                    <div class="breadcrumb_main text-right">
                        <a href="" class="hpc_low">Home / </a>
                        <span>Add fdfs</span>
                    </div>
                    <div class="cnt_sec">
                        <div class="card_wht">
                            <div class="head_main">
                                <h4 class="heading">External</h4>
                            </div>
                            <div class="card_cnt">
                                <div class="container">
                                    <style>
                                        .ip label {
                                            width: 100%;
                                            display: block;
                                        }
                                        .ip select, .ip input {
                                            width: 100%;
                                            height: 49px;
                                            border: 1px solid #89B0E7;
                                            border-radius: 4px;
                                            margin-top: 10px;
                                        }
                                        .ip select:focus, .ip input:focus,input:focus {
                                            border: 1px solid navy !important;
                                            outline: none !important;
                                            box-shadow: none !important;
                                        }
                                        
                                        .display {
                                            padding: 15px 25px;
                                            border-radius: 30px;
                                            background-color: #89B0E7;
                                            color: white;
                                            border: none;
                                        }

                                        input[type="number"]::-webkit-outer-spin-button,
                                        input[type="number"]::-webkit-inner-spin-button {
                                            -webkit-appearance: none;
                                            margin: 0;
                                        }
                                        input[type="number"] {
                                            -moz-appearance: textfield;
                                        }
                                    </style>

                                <form method="post">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="ip">
                                                <label for="regulation">Select the Regulation</label>
                                                <select name="regulation" id="regulation" onchange="updateSubjects();">
                                                    <option value="">Select Regulation</option>
                                                    <?php while ($row = mysqli_fetch_assoc($regulations)) { ?>
                                                        <option value="<?= $row['id'] ?>" <?= ($row['id'] == $selectedRegulation) ? 'selected' : '' ?>>
                                                            <?= $row['regulation'] ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip">
                                                <label for="dept">Select the Department</label>
                                                <select name="dept" id="dept" onchange="updateSubjects();">
                                                    <option value="">Select Department</option>
                                                    <?php while ($row = mysqli_fetch_assoc($departments)) { ?>
                                                        <option value="<?= $row['dept_id'] ?>" <?= ($row['dept_id'] == $selectedDept) ? 'selected' : '' ?>>
                                                            <?= $row['branch'] ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip">
                                                <label for="year">Select the Year</label>
                                                <select name="year" id="year" onchange="updateSemesters(); updateSubjects();">
                                                    <option value="">Select Year</option>
                                                    <?php while ($row = mysqli_fetch_assoc($years)) { ?>
                                                        <option value="<?= $row['id'] ?>" <?= ($row['id'] == $selectedYear) ? 'selected' : '' ?>>
                                                            <?= $row['name'] ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:20px;">
                                        <div class="col-md-4">
                                            <div class="ip">
                                                <label for="semester">Select the Semester</label>
                                                <select name="semester" id="semester" onchange="updateSubjects();">
                                                    <option value="">Select Semester</option>
                                                    <?php for ($i = 1; $i <= 8; $i++) { ?>
                                                        <option value="<?= $i ?>" <?= ($i == $selectedSemester) ? 'selected' : '' ?>><?= $i ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip">
                                                <label for="subject">Select the Subject</label>
                                                <select name="subject" id="subject" onchange="updateTypeSelection();">
                                                    <option value="">Select Subject</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4" id="typeContainer" style="display:none;">
                                            <div class="ip">
                                                <label for="type">Select the Type</label>
                                                <select name="type" id="type">
                                                    <option value="theory" <?= ($selectedType == 'theory') ? 'selected' : '' ?>>Theory</option>
                                                    <option value="lab" <?= ($selectedType == 'lab') ? 'selected' : '' ?>>Lab</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:20px;">
                                        <div class="col-md-4">
                                            <div class="ip">
                                                <label for="session">Select the Session</label>
                                                <select name="session" id="session">
                                                    <option value="">Select Session</option>
                                                    <option value="aprl-may" <?= ($selectedSession == 'aprl-may') ? 'selected' : '' ?>>Apr-May</option>
                                                    <option value="nov-dec" <?= ($selectedSession == 'nov-dec') ? 'selected' : '' ?>>Nov-Dec</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip">
                                                <label for="sessionyear">Enter Year</label>
                                                <input type="number" name="sessionyear" id="sessionyear" value="<?= htmlspecialchars($selectedSessionYear) ?>" placeholder="Enter Year" min="2000" max="2100" required>
                                            </div>
                                        </div>
                                    </div>
                                                                          
                                        <!-- <div class="col-md-4" id="typeContainer" style="display:none;">
                                            <div class="ip">
                                                <label for="type">Select the Type</label>
                                                <select name="type" id="type">
                                                    <option value="theory" <?= ($selectedType == 'theory') ? 'selected' : '' ?>>Theory</option>
                                                    <option value="lab" <?= ($selectedType == 'lab') ? 'selected' : '' ?>>Lab</option>
                                                </select>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="container">
                                        <div class="row" style="margin-top:20px;">
                                            <div class="col-md-4">
                                                <button type="submit" name="submit" class="display">STUDENT LIST</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <?php if (!empty($students)) { ?>
                                    <form method="post">
                                        <div class="card_wht mt-4">
                                            <div class="head_main">
                                                <h4 class="heading">Student List</h4>
                                            </div>
                                            <div class="card_cnt">
                                                <table class="table externalmark_table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">SI.NO</th>
                                                            <th scope="col">Name</th>
                                                            <th scope="col">Roll No</th>
                                                            <th scope="col">Enter Mark</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="externalmark_table">
                                                        <?php $count = 1; while ($row = mysqli_fetch_assoc($students)) { ?>
                                                            <tr>
                                                                <td><?= $count++ ?></td>
                                                                <td><?= $row['name'] ?></td>
                                                                <td><?= $row['reg_no'] ?></td>
                                                                <td>
                                                                <input type="hidden" name="reg_nos[]" value="<?= $row['reg_no'] ?>"> <!-- Changed to reg_no -->

                                                                    <!-- <input type="hidden" name="student_ids[]" value="<?= $row['id'] ?>"> -->
                                                                    <input type="number" name="marks[]" min="0" max="100" style="border:2px solid #89B0E7;border-radius:3px;width:190px;height:35px;" required>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                <input type="hidden" name="regulation" value="<?= $selectedRegulation ?>">
                                                <input type="hidden" name="dept" value="<?= $selectedDept ?>">
                                                <input type="hidden" name="year" value="<?= $selectedYear ?>">
                                                <input type="hidden" name="semester" value="<?= $selectedSemester ?>">
                                                <input type="hidden" name="subject" value="<?= $selectedSubject ?>">
                                                <input type="hidden" name="session" value="<?= $selectedSession ?>">
                                                <input type="hidden" name="sessionyear" value="<?= $selectedSessionYear ?>">
                                                <input type="hidden" name="type" value="<?= $selectedType ?>">
                                            </div>
                                            <div class="container">
                                                <div class="row" style="margin-top:20px;">
                                                    <div class="col-md-4">
                                                        <button type="submit" name="save_marks" class="display">SUBMIT</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>   
                                <?php } ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save_marks"])) {
    $selectedSubject = $_POST["subject"];
    $selectedType = $_POST["type"];
    $regNos = $_POST["reg_nos"];
    $marks = $_POST["marks"];
    $selectedSession = $_POST["session"] ?? "";
    $selectedSessionYear = $_POST["sessionyear"] ?? "";
    $combinedSession = $selectedSession . "-" . $selectedSessionYear;
    
    if (!empty($selectedSubject) && !empty($regNos) && !empty($marks)) {
        $errors = [];
        
        // Fetch course details
        $query = "SELECT course_type, L,T,P, credit_points FROM subject_module WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $selectedSubject);
        $stmt->execute();
        $stmt->bind_result($course_type, $L,$T,$P, $credit_points);
        $stmt->fetch();
        $stmt->close();
       // console.log(L,T,P);
        if (!$course_type) {
            echo "<script>alert('Invalid subject selection.');</script>";
            exit;
        }
        $L = (int)$L;
        $T = (int)$T;
        $P = (int)$P;
       // $credit_points = (float)$credit_points;
        
echo "<script>alert('Credit Points: " . $credit_points . "');</script>";
        foreach ($regNos as $index => $reg_no) {
            $mark = $marks[$index];
            
            // First get the student's registration number
            $regNoQuery = "SELECT id FROM students WHERE reg_no = ?";
            $stmt = $conn->prepare($regNoQuery);
            $stmt->bind_param("s", $reg_no);
            $stmt->execute();
            $stmt->bind_result($studentId);
            $stmt->fetch();
            $stmt->close();
            
            if (!$reg_no) {
                $errors[] = "Student ID $reg_no not found";
                continue;
            }
            
            // Check if record exists in external table
            $checkQuery = "SELECT id, theory_mark, lab_mark FROM external WHERE reg_no = ? AND subject_id = ?";
            $stmt = $conn->prepare($checkQuery);
            $stmt->bind_param("ii", $reg_no, $selectedSubject);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();
            
            // Handle external table update/insert
            if ($row) {
                // Record exists - update it
                //if ($ltp == '302' && $credits == '4') {
                    // For subjects with both theory and lab (update based on selected type)
                    if (($L == 3 && $T == 0 && $P == 2 && $credit_points == 4.0) || 
                    ($L == 2 && $T == 0 && $P == 2 && $credit_points == 3.00))  { 
                        if ($selectedType == 'theory') {
                            echo "<script>alert('L = $L, T = $T, P = $P, Credit Points = $credit_points, selectedType =$selectedType');</script>";
                                 echo "<script>alert('UPDATE external SET theory_mark = $mark, session = $combinedSession, student_id = $studentId WHERE reg_no = $reg_no AND subject_id = $selectedSubject')</script>";
                            $query = "UPDATE external SET theory_mark = ?, session = ?, student_id = ? 
                                 WHERE reg_no = ? AND subject_id = ?";
                    } else { // lab
                        $query = "UPDATE external SET lab_mark = ?, session = ?, student_id = ? 
                                 WHERE reg_no = ? AND subject_id = ?";
                    }
                    $stmt = $conn->prepare($query);
                    // print_r("stmt:".$stmt);
                    $stmt->bind_param("isiii", $mark, $combinedSession, $studentId, $reg_no, $selectedSubject);
                    // print_r( '<script>alert("stmt: '.$stmt.'")</script>');
                } else {
                    // For subjects with only one component (update based on course_type)
                    if ($course_type == 'Theory') {
                        $query = "UPDATE external SET theory_mark = ?, session = ?, student_id = ? 
                                 WHERE reg_no = ? AND subject_id = ?";
                        
                    } else { // lab
                        $query = "UPDATE external SET lab_mark = ?, session = ?, student_id = ? 
                                 WHERE reg_no = ? AND subject_id = ?";
                    }
            //         $stmt = $conn->prepare($query);
            // $stmt->bind_param("isiii", $mark, $combinedSession, $studentId, $reg_no, $selectedSubject);

                }
            
                // Execute the query
              $stmt = $conn->prepare($query);
            //    // $stmt->bind_param("issii", $mark, $combinedSession, $reg_no, $studentId, $selectedSubject);
         $stmt->bind_param("isiii", $mark, $combinedSession, $studentId, $reg_no, $selectedSubject);
                $stmt->execute();
                $stmt->close();
            } else {
                // Record doesn't exist - insert new
               // if ($ltp == '302' && $credits == '4') {
                if( ($L == 3 && $T == 0 && $P == 2 && $credit_points == 4.0)
                || 
    ($L == 2 && $T == 0 && $P == 2 && $credit_points == 3.0)) 
     { 
               // For subjects with both theory and lab components
                    $query = "INSERT INTO external (student_id, subject_id, reg_no, theory_mark, lab_mark, session) 
                             VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($query);
                   // $stmt->bind_param("iisiis", $studentId, $selectedSubject, $reg_no, $mark, $combinedSession);
                    if ($selectedType == 'theory') {

                        $lab_mark=0;
                       // $stmt->bind_param("iisiss", $studentId, $selectedSubject, $reg_no, $mark, 0, $combinedSession);
                       $stmt->bind_param("iisiis", $studentId, $selectedSubject, $reg_no, $mark,$lab_mark, $combinedSession);
                    } else {
                        $theory_mark=0;
                       // $stmt->bind_param("iisiss", $studentId, $selectedSubject, $reg_no, 0, $mark, $combinedSession);
                       $stmt->bind_param("iisiis", $studentId, $selectedSubject, $reg_no,$theory_mark, $mark, $combinedSession);
                    }
                } else {
                    // For subjects with only one component
                    if ($course_type == 'Theory') {
                        $query = "INSERT INTO external (student_id, subject_id, reg_no, theory_mark, session) 
                                 VALUES (?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($query);
                       // $stmt->bind_param("iiss", $studentId, $selectedSubject, $reg_no, $mark, $combinedSession);
                       $stmt->bind_param("iiiss", $studentId, $selectedSubject, $reg_no, $mark, $combinedSession);
                    } elseif ($course_type == 'Practical') {
                        $query = "INSERT INTO external (student_id, subject_id, reg_no, lab_mark, session) 
                                 VALUES (?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($query);
                        //$stmt->bind_param("iisss", $studentId, $selectedSubject, $reg_no, $mark, $combinedSession);
                        $stmt->bind_param("iiiss", $studentId, $selectedSubject, $reg_no, $mark, $combinedSession);
                    }
                }
                $stmt->execute();
                $stmt->close();
            }
            // Fetch internal marks based on course type and subject
            $internalQuery = ($course_type === 'Theory') ? 
                "SELECT total_iae AS internal_mark FROM internal WHERE reg_no = '$reg_no' AND subject_id = '$selectedSubject'" :
                "SELECT Lab AS internal_mark FROM internal WHERE reg_no = '$reg_no' AND subject_id = '$selectedSubject'";
            $internalResult = mysqli_query($conn, $internalQuery);
            $internalMark = ($internalResult && mysqli_num_rows($internalResult) > 0) ? mysqli_fetch_assoc($internalResult)['internal_mark'] : 0;

            // Calculate total marks, grade, and result based on ltp and credits
            // if (($ltp === '104' && $credits === 3.0) || ($ltp === '102' && $credits === 2.0)) {
            if ((($L == 1 && $T == 0 && $P ==4) && $credit_points == 3.0) || (($L == 1 && $T==0 && $P==2) && $credit_points == 2.0)) {
                $internalQuery = "SELECT total_iae, Lab FROM internal WHERE reg_no = '$reg_no' AND subject_id = '$selectedSubject'";
                $internalResult = mysqli_query($conn, $internalQuery);
                $internalData = mysqli_fetch_assoc($internalResult);
                $total_iae = isset($internalData['total_iae']) ? $internalData['total_iae'] : 0;
                $labMark = isset($internalData['Lab']) ? $internalData['Lab'] : 0;
                $connvertedInternal = ($total_iae * 0.25) + ($labMark * 0.25);
                $externalQuery = "SELECT lab_mark FROM external WHERE reg_no = '$reg_no' AND subject_id = '$selectedSubject'";
                $externalResult = mysqli_query($conn, $externalQuery);
                $externalMark = ($externalResult && mysqli_num_rows($externalResult) > 0) ? mysqli_fetch_assoc($externalResult)['lab_mark'] : 0;
                $connvertedExternal = $externalMark * 0.50;
            } elseif (($L == 2 && $T==0 && $P==2) && $credit_points == 3.0) {
                $internalQuery = "SELECT total_iae, Lab FROM internal WHERE reg_no = '$reg_no' AND subject_id = '$selectedSubject'";
                $internalResult = mysqli_query($conn, $internalQuery);
                $internalData = mysqli_fetch_assoc($internalResult);
                $total_iae = isset($internalData['total_iae']) ? $internalData['total_iae'] : 0;
                $labMark = isset($internalData['Lab']) ? $internalData['Lab'] : 0;
                $connvertedInternal = ($total_iae * 0.25) + ($labMark * 0.25);
                $externalQuery = "SELECT theory_mark, lab_mark FROM external WHERE reg_no = '$reg_no' AND subject_id = '$selectedSubject'";
                $externalResult = mysqli_query($conn, $externalQuery);
                $externalData = mysqli_fetch_assoc($externalResult);
                $theoryMark = isset($externalData['theory_mark']) ? $externalData['theory_mark'] : 0;
                $labMarkExternal = isset($externalData['lab_mark']) ? $externalData['lab_mark'] : 0;
                $connvertedExternal = ($theoryMark * 0.25) + ($labMarkExternal * 0.25);
            } elseif (($L == 3 && $T==0 && $P==2) && $credit_points == 4.0) { 
                $internalQuery = "SELECT total_iae, Lab FROM internal WHERE reg_no = '$reg_no' AND subject_id = '$selectedSubject'";
                $internalResult = mysqli_query($conn, $internalQuery);
                $internalData = mysqli_fetch_assoc($internalResult);
                $total_iae = isset($internalData['total_iae']) ? $internalData['total_iae'] : 0;
                $labMark = isset($internalData['Lab']) ? $internalData['Lab'] : 0;
                $connvertedInternal = ($total_iae * 0.25) + ($labMark * 0.25);
                $externalQuery = "SELECT theory_mark, lab_mark FROM external WHERE reg_no = '$reg_no' AND subject_id = '$selectedSubject'";
                $externalResult = mysqli_query($conn, $externalQuery);
                $externalData = mysqli_fetch_assoc($externalResult);
                $theoryMark = isset($externalData['theory_mark']) ? $externalData['theory_mark'] : 0;
                $labMarkExternal = isset($externalData['lab_mark']) ? $externalData['lab_mark'] : 0;
                $connvertedExternal = ($theoryMark * 0.35) + ($labMarkExternal * 0.15);
            } elseif (($L == 2 && $T==0 && $P==4) && $credit_points == 4.0) { 
                $internalQuery = "SELECT total_iae FROM internal WHERE reg_no = '$reg_no' AND subject_id = '$selectedSubject'";
                $internalResult = mysqli_query($conn, $internalQuery);
                $internalData = mysqli_fetch_assoc($internalResult);
                $total_iae = isset($internalData['total_iae']) ? $internalData['total_iae'] : 0;
                $connvertedInternal = $total_iae * 0.40;
                $externalQuery = "SELECT theory_mark FROM external WHERE reg_no = '$reg_no' AND subject_id = '$selectedSubject'";
                $externalResult = mysqli_query($conn, $externalQuery);
                $externalData = mysqli_fetch_assoc($externalResult);
                $theoryMark = isset($externalData['theory_mark']) ? $externalData['theory_mark'] : 0;
                $connvertedExternal = $theoryMark * 0.60;
            // } elseif (($ltp === '300' && $credits === 3.0) || ($ltp === '200' && $credits === 2.0) || ($ltp === '310' && $credits === 4.0) || ($ltp === '100' && $credits === 1.0)) {
            } elseif (
                ($L == 3 && $T== 0 && $P == 0 && $credit_points == 3.0) ||
                
                ($L == 2 && $T == 0 && $P == 0 && $credit_points == 2.0) ||
                
                ($L == 3 && $T == 1 && $P == 0 && $credit_points == 4.0) ||
                ($L == 4 && $T == 0 && $P == 0 && $credit_points == 4.0) ||
                
                ($L == 1 && $T == 0 && $P == 0 && $credit_points == 1.0)
            ) {
            
                $internalQuery = "SELECT total_iae FROM internal WHERE reg_no = '$reg_no' AND subject_id = '$selectedSubject'";
                $internalResult = mysqli_query($conn, $internalQuery);
                $internalData = mysqli_fetch_assoc($internalResult);
                $total_iae = isset($internalData['total_iae']) ? $internalData['total_iae'] : 0;
                $connvertedInternal = $total_iae * 0.40;
                $externalQuery = "SELECT theory_mark FROM external WHERE reg_no = '$reg_no' AND subject_id = '$selectedSubject'";
                $externalResult = mysqli_query($conn, $externalQuery);
                $externalData = mysqli_fetch_assoc($externalResult);
                $theoryMark = isset($externalData['theory_mark']) ? $externalData['theory_mark'] : 0;
                $connvertedExternal = $theoryMark * 0.60;
         //   } elseif (($ltp === '003' && $credits === 2.0) || ($ltp === '003' && $credits === 1.5) || ($ltp === '004' && $credits === 2.0) || ($ltp === '002' && $credits === 1.0)) {
        } elseif (
            ($L == 0 && $T == 0 && $P == 3 && $credit_points == 2.0) ||
                        ($L == 0 && $T == 0 && $P == 3 && $credit_points == 1.5) ||
                        ($L == 0 && $T == 0 && $P == 4 && $credit_points == 2.0) ||
                        ($L == 0 && $T == 0 && $P == 2 && $credit_points == 1.0) ||
                        ($L == 0 && $T == 0 && $P == 3 && $credit_points == 1.0) ||

                        ($L == 0 && $T == 0 && $P == 6 && $credit_points == 3.0)
        ) {
             
         $internalQuery = "SELECT Lab FROM internal WHERE reg_no = '$reg_no' AND subject_id = '$selectedSubject'";
                $internalResult = mysqli_query($conn, $internalQuery);
                $internalData = mysqli_fetch_assoc($internalResult);
                $Lab = isset($internalData['Lab']) ? $internalData['Lab'] : 0;
                $connvertedInternal = $Lab * 0.60;
                $externalQuery = "SELECT lab_mark FROM external WHERE reg_no = '$reg_no' AND subject_id = '$selectedSubject'";
                $externalResult = mysqli_query($conn, $externalQuery);
                $externalData = mysqli_fetch_assoc($externalResult);
                $labMark = isset($externalData['lab_mark']) ? $externalData['lab_mark'] : 0;
                $connvertedExternal = $labMark * 0.40;
            } else {
                // Default case if none of the conditions match
                $connvertedInternal = $internalMark;
                $connvertedExternal = $mark;
            }
            
            // Calculate total marks, grade, and result
            // Calculate total marks, grade, and result
$totalMarks = $connvertedInternal + $connvertedExternal;

// First try to update existing record
$updateQuery = "UPDATE result SET 
                internal_mark = '$connvertedInternal', 
                external_mark = '$connvertedExternal',
                mark = '$totalMarks', 
                session = '$combinedSession', 
                semester = '$selectedSemester', 
                regulation_id = '$selectedRegulation', 
                year = '$selectedYear', 
                dept_id = '$selectedDept',
                reg_no = '$reg_no'
                WHERE reg_no = '$reg_no' AND subject = '$selectedSubject' AND session = '$combinedSession'";

$updateResult = mysqli_query($conn, $updateQuery);

// If no rows were affected (record didn't exist), insert new
if (mysqli_affected_rows($conn) == 0) {
    $insertQuery = "INSERT INTO result (subject, reg_no, student, internal_mark, external_mark, mark, session, semester, regulation_id, year, dept_id)
                   VALUES ('$selectedSubject', '$reg_no', '$studentId', '$connvertedInternal', '$connvertedExternal', '$totalMarks', '$combinedSession', '$selectedSemester', '$selectedRegulation', '$selectedYear', '$selectedDept')";
    mysqli_query($conn, $insertQuery);
}
        //     $totalMarks = $connvertedInternal + $connvertedExternal;
        //     // For the result table, make sure to include reg_no in your query:
        //     $resultQuery = "INSERT INTO result ( subject, reg_no,student, internal_mark, external_mark, mark, session, semester, regulation_id, year, dept_id)
        //                    VALUES ( '$selectedSubject', '$reg_no','$studentId', '$connvertedInternal', '$connvertedExternal', '$totalMarks', '$combinedSession', '$selectedSemester', '$selectedRegulation', '$selectedYear', '$selectedDept')
        //                    ON DUPLICATE KEY UPDATE 
        //                    internal_mark = VALUES(internal_mark), 
        //                    external_mark = VALUES(external_mark),
        //                    mark = VALUES(mark), 
        //                    session = VALUES(session), 
        //                    semester = VALUES(semester), 
        //                    regulation_id = VALUES(regulation_id), 
        //                    year = VALUES(year), 
        //                    dept_id = VALUES(dept_id),
        //                    reg_no = VALUES(reg_no)";
        //     mysqli_query($conn, $resultQuery);
         }
        
        if (!empty($errors)) {
            echo "<script>alert('" . implode("\\n", $errors) . "');</script>";
        } else {
            //echo "<script>alert('Marks saved successfully!'); window.location.href = window.location.pathname;</script>";
        }
    } else {
        echo "<script>alert('Please enter all required details.');</script>";
    }
}

?>
<script>
//if (window.history.replaceState) {
  //  window.history.replaceState(null, null, window.location.href);
//}

document.addEventListener("DOMContentLoaded", function () {
    const subjects = <?= json_encode($allSubjects); ?>;
    const subjectDropdown = document.getElementById("subject");
    const regulationDropdown = document.getElementById("regulation");
    const deptDropdown = document.getElementById("dept");
    const yearDropdown = document.getElementById("year");
    const semesterDropdown = document.getElementById("semester");
    const typeContainer = document.getElementById("typeContainer");
    
    // Initialize with previously selected values if they exist
    const selectedSubject = "<?= $selectedSubject ?>";
    const selectedType = "<?= $selectedType ?>";

    // function updateSubjects() {
    //     const regulation = document.getElementById("regulation").value;
    //     const dept = document.getElementById("dept").value;
    //     const year = document.getElementById("year").value;
    //     const semester = document.getElementById("semester").value;
        
    //     subjectDropdown.innerHTML = '<option value="">Select Subject</option>';
        
    //     if (regulation && dept && year && semester) {
    //         const filteredSubjects = subjects.filter(sub => 
    //             sub.regulation_id == regulation && 
    //             sub.dept_id == dept && 
    //             sub.year == year && 
    //             sub.semester == semester
    //         );
            
    //         if (filteredSubjects.length > 0) {
    //             subjectDropdown.disabled = false;
    //             filteredSubjects.forEach(sub => {
    //                 let option = document.createElement("option");
    //                 option.value = sub.id;
    //                 option.textContent = ${sub.subject_code} - ${sub.name};
    //                 // Preselect if this was the previously selected subject
    //                 if (sub.id == selectedSubject) {
    //                     option.selected = true;
    //                 }
    //                 subjectDropdown.appendChild(option);
    //             });
    //             updateTypeSelection();
    //         } else {
    //             subjectDropdown.disabled = true;
    //         }
    //     } else {
    //         subjectDropdown.disabled = true;
    //     }
        
    //     // If we have a selected subject from POST data, ensure it's selected
    //     if (selectedSubject) {
    //         subjectDropdown.value = selectedSubject;
    //         updateTypeSelection();
    //     }
    // }
    function updateSubjects() {
    const regulation = document.getElementById("regulation").value;
    const dept = document.getElementById("dept").value;
    const year = document.getElementById("year").value;
    const semester = document.getElementById("semester").value;
    
    const subjectDropdown = document.getElementById("subject");
    subjectDropdown.innerHTML = '<option value="">Select Subject</option>';
    
    if (regulation && dept && semester) { // Year is optional if you want
        // Filter subjects based on all criteria
        const filteredSubjects = subjects.filter(sub => 
            sub.regulation == regulation && 
            sub.branch == dept && 
            sub.semester == semester // This is the key filter for semester
        );
        
        if (filteredSubjects.length > 0) {
            filteredSubjects.forEach(sub => {
                let option = document.createElement("option");
                option.value = sub.id;
                option.textContent = `${sub.subject_code} - ${sub.subject_name}`;
                // Preselect if this was the previously selected subject
                if (sub.id == "<?= $selectedSubject ?>") {
                    option.selected = true;
                }
                subjectDropdown.appendChild(option);
            });
            
            // Update type selection based on selected subject
            //updateTypeSelection();
        } else {
            subjectDropdown.innerHTML = '<option value="">No subjects found for this semester</option>';
        }
        subjectDropdown.disabled = false;
    } else {
        subjectDropdown.innerHTML = '<option value="">Select filters first</option>';
        subjectDropdown.disabled = true;
    }
}
    regulationDropdown.addEventListener("change", updateSubjects);
    deptDropdown.addEventListener("change", updateSubjects);
    //yearDropdown.addEventListener("change", updateSubjects);
    yearDropdown.addEventListener("change", function() {
    updateSemesters();
    updateSubjects(); // Keep this if you need it
});
    semesterDropdown.addEventListener("change", updateSubjects);
    
//     // Initialize the form
//     updateSemesters();
//     updateSubjects();
    
//     // If we have a selected type from POST data, ensure it's selected
//     if (selectedType) {
//         document.getElementById("type").value = selectedType;
//     }
// });
// Initialize the form
if (document.getElementById("year").value) {
        updateSemesters();
    }
    
    // If we have a selected subject from POST data, ensure it's selected
    if ("<?= $selectedSubject ?>") {
        document.getElementById("subject").value = "<?= $selectedSubject ?>";
        updateTypeSelection();
    }
});

// function updateSemesters() {
//     var year = document.getElementById("year").value;
//     var semesterSelect = document.getElementById("semester");
//     semesterSelect.innerHTML = '<option value="">Select Semester</option>'; 
    
//     var semesterOptions = {
//         "1": ["1", "2"],
//         "2": ["3", "4"],
//         "3": ["5", "6"],
//         "4": ["7", "8"]
//     };
    
//     if (year && semesterOptions[year]) {
//         semesterOptions[year].forEach(sem => {
//             var option = document.createElement("option");
//             option.value = sem;
//             option.textContent = sem;
//             // Preselect if this was the previously selected semester
//             if (sem == "<?= $selectedSemester ?>") {
//                 option.selected = true;
//             }
//             semesterSelect.appendChild(option);
//         });
//     }
// }
function updateSemesters() {
    var year = document.getElementById("year").value;
    var semesterSelect = document.getElementById("semester");
    
    // Clear existing options
    semesterSelect.innerHTML = '<option value="">Select Semester</option>';
    
    if (year) {
        // Define which semesters belong to which year
        const yearSemesterMap = {
            "1": [1, 2],   // Year 1 has semesters 1 and 2
            "2": [3, 4],   // Year 2 has semesters 3 and 4
            "3": [5, 6],   // Year 3 has semesters 5 and 6
            "4": [7, 8]    // Year 4 has semesters 7 and 8
        };
        
        // Get semesters for selected year
        const semesters = yearSemesterMap[year] || [];
        
        // Add semester options
        semesters.forEach(sem => {
            var option = document.createElement("option");
            option.value = sem;
            option.textContent = `Semester ${sem}`;
            // Preselect if this was the previously selected semester
            if (sem == "<?= $selectedSemester ?>") {
                option.selected = true;
            }
            semesterSelect.appendChild(option);
        });
        
        // Automatically update subjects when year changes
        updateSubjects();
    }
}

function updateTypeSelection() {
    const subjects = <?= json_encode($allSubjects); ?>;
    const subjectDropdown = document.getElementById("subject");
    const selectedSubjectId = subjectDropdown.value;
    const typeContainer = document.getElementById("typeContainer");
    const selectedType = "<?= $selectedType ?>";
    //console.log("Selected Subject ID:", selectedSubjectId);
    if (selectedSubjectId) 
   // console.log("Selected Subject ID:", selectedSubjectId);

    {
        const selectedSubject = subjects.find(sub => sub.id == selectedSubjectId);
        console.log("Selected Subject :", selectedSubject); 

        if ((selectedSubject && selectedSubject.L == 3 && selectedSubject.T == 0 && selectedSubject.P == 2 && selectedSubject.credit_points== '4.00') || 
        (selectedSubject && selectedSubject.L == 2 && selectedSubject.T == 0 && selectedSubject.P == 2 && selectedSubject.credit_points == '3.00')) {
              // console.log("Selected Subject ID:", selectedSubjectId);

            typeContainer.style.display = 'block';
            // Preselect the type if it was previously selected
            if (selectedType) {
                document.getElementById("type").value = selectedType;
            }
        } else {
            
            typeContainer.style.display = 'none';
        }
    } else {
        typeContainer.style.display = 'none';
    }
}
</script>
</body>
</html>