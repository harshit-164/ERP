<?php 
include("con.php");
// Fetch regulations, departments, and years
$regulations = mysqli_query($conn, "SELECT * FROM regulation");
$departments = mysqli_query($conn, "SELECT * FROM dept");
$years = mysqli_query($conn, "SELECT * FROM year");

// Fetch all subjects
$allSubjects = [];
$subjectsQuery = "SELECT id, subject_code, subject_name, L,T,P, credit_POINTS, regulation, BRANCH, year, semester FROM subject_module";
$result = mysqli_query($conn, $subjectsQuery);
while ($row = mysqli_fetch_assoc($result)) {
    $allSubjects[] = $row;
}

// Default values for dropdown selections
$selectedRegulation = $_POST["regulation"] ?? "";
$selectedDept = $_POST["dept"] ?? "";
$selectedYear = $_POST["year"] ?? "";
$selectedSemester = $_POST["semester"] ?? "";
$selectedSubject = $_POST["subject"] ?? "";
$selectedIAE = $_POST["IAE"] ?? "";

// Fetch students when the form is submitted
$studentData = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    if (!empty($selectedYear) && !empty($selectedSemester) && !empty($selectedDept) && !empty($selectedRegulation)) {
        
        $studentsQuery = "SELECT id, name, reg_no FROM students
                         WHERE year = '$selectedYear' 
                         AND semester = '$selectedSemester' 
                         AND branch = '$selectedDept' 
                         AND regulation = '$selectedRegulation'";
        
        $students = mysqli_query($conn, $studentsQuery);
        
        if (!$students) {
            die("Query failed: " . mysqli_error($conn));
        }
        
        while ($row = mysqli_fetch_assoc($students)) {
            $studentData[] = $row;
        }
    }
}

// Handle mark submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save_marks"])) {
    mysqli_begin_transaction($conn);
    
    try {
        $selectedIAE = $_POST["IAE"];
        $selectedSubject = $_POST["subject"];
        $selectedSemester = $_POST["semester"];
        $studentIds = $_POST["student_ids"];
        $marks = $_POST["marks"];
        $regNos = $_POST["reg_nos"] ?? [];
    
        $validIAEColumns = ["iae-1", "iae-2", "iae-3", "iae-4", "iae-5", "Lab"];
    
        if (!in_array($selectedIAE, $validIAEColumns)) {
            throw new Exception("Invalid IAE column selected.");
        }
    
        if (!empty($selectedSubject) && !empty($studentIds) && !empty($marks)) {
            foreach ($studentIds as $index => $studentId) {
                $mark = $marks[$index];
                $regNo = $regNos[$index] ?? '';
                
                if (empty($regNo)) {
                    throw new Exception("Registration number missing for student at index $index");
                }
    
                // Check if record exists
                $checkQuery = "SELECT id, `iae-1`, `iae-2`, `iae-3`, `iae-4`, `iae-5` FROM internal 
                               WHERE student_id = ? AND subject_id = ?";
                $checkStmt = $conn->prepare($checkQuery);
                $checkStmt->bind_param("ii", $studentId, $selectedSubject);
                $checkStmt->execute();
                $checkResult = $checkStmt->get_result();
                $checkStmt->close();
				
                if ($checkResult->num_rows > 0) {
                    // Record exists - UPDATE
                    if ($selectedIAE === "Lab") {
                        $stmt = $conn->prepare("UPDATE internal SET Lab = ?, reg_no = ?, semester = ?
                                               WHERE student_id = ? AND subject_id = ?");
                        $stmt->bind_param("isiii", $mark, $regNo, $selectedSemester, $studentId, $selectedSubject);
                    } else {
                        $stmt = $conn->prepare("UPDATE internal SET `$selectedIAE` = ?, reg_no = ?, semester = ?
                                               WHERE student_id = ? AND subject_id = ?");
                        $stmt->bind_param("isiii", $mark, $regNo, $selectedSemester, $studentId, $selectedSubject);
                    }
                    
                    if (!$stmt->execute()) {
                        throw new Exception("Error updating marks: " . $stmt->error);
                    }
                    $stmt->close();
    
                    // For IAE marks, calculate total_iae
                    if ($selectedIAE !== "Lab") {
                        $row = $checkResult->fetch_assoc();
                        $iaeMarks = [
                            $row['iae-1'] ?? 0, 
                            $row['iae-2'] ?? 0, 
                            $row['iae-3'] ?? 0, 
                            $row['iae-4'] ?? 0, 
                            $row['iae-5'] ?? 0
                        ];
                        $iaeIndex = array_search($selectedIAE, ["iae-1", "iae-2", "iae-3", "iae-4", "iae-5"]);
                        $iaeMarks[$iaeIndex] = $mark;
                        
                        $validMarks = array_filter($iaeMarks, function($m) { 
                            return $m !== null && $m !== "" && $m > 0; 
                        });
                        $totalIAE = !empty($validMarks) ? array_sum($validMarks) / count($validMarks) : 0;
    
                        $updateStmt = $conn->prepare("UPDATE internal SET total_iae = ? 
                                                    WHERE student_id = ? AND subject_id = ?");
                        $updateStmt->bind_param("dii", $totalIAE, $studentId, $selectedSubject);
                        if (!$updateStmt->execute()) {
                            throw new Exception("Error updating total IAE: " . $updateStmt->error);
                        }
                        $updateStmt->close();
                    }
                } else {
                    // New record - INSERT
                    if ($selectedIAE === "Lab") {
                        $stmt = $conn->prepare("INSERT INTO internal 
                            (student_id, subject_id, Lab, reg_no, semester) 
                            VALUES (?, ?, ?, ?, ?)");
                        $stmt->bind_param("iiisi", $studentId, $selectedSubject, $mark, $regNo, $selectedSemester);
                    } else {
                        $stmt = $conn->prepare("INSERT INTO internal 
                            (student_id, subject_id, `$selectedIAE`, total_iae, reg_no, semester) 
                            VALUES (?, ?, ?, ?, ?, ?)");
                        $totalIAE = $mark;
                        $stmt->bind_param("iiidsi", $studentId, $selectedSubject, $mark, $totalIAE, $regNo, $selectedSemester);
                    }
                    
                    if (!$stmt->execute()) {
                        throw new Exception("Error inserting marks: " . $stmt->error);
                    }
                    $stmt->close();
                }
            }
            
            mysqli_commit($conn);
            echo "<script>
                alert('All marks entered successfully!');
                window.location.href = window.location.pathname + '?success=1';
            </script>";
            exit();
        } else {
            throw new Exception("Please enter all required details.");
        }
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <?php include("head.php")?>
    <body>
        <?php include("nav.php")?>
         
        <div class="frame_body">
            <?php include("sidenav.php"); ?>
            <div class="cnt_frame_main">
                <div class="cnt_frame_inner">
                    <div class="breadcrumb_main text-right">
                        <a href="" class="hpc_low">Home / </a>
                        <span>Add Internal Marks</span>
                    </div>
                    <div class="cnt_sec">
                         
                        
                        <div class="card_wht">
                            <div class="head_main">
                                <h4 class="heading">Internal</h4>
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

                                <form method="post" onsubmit="return validateForm();">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="ip">
                                                <label for="regulation">Select the Regulation</label>
                                                <select name="regulation" id="regulation" onchange="updateSubjects();">
                                                    <option value="">Select Regulation</option>
                                                    <?php 
                                                    mysqli_data_seek($regulations, 0);
                                                    while ($row = mysqli_fetch_assoc($regulations)) { ?>
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
                                                    <?php 
                                                    mysqli_data_seek($departments, 0);
                                                    while ($row = mysqli_fetch_assoc($departments)) { ?>
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
                                                    <?php 
                                                    mysqli_data_seek($years, 0);
                                                    while ($row = mysqli_fetch_assoc($years)) { ?>
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
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip">
                                                <label for="subject">Select the Subject</label>
                                                <select name="subject" id="subject_module" onchange="updateIAEOptions();" disabled>
                                                    <option value="">Select Subject</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip">
                                                <label for="IAE">Select the IAE</label>
                                                <select name="IAE" id="IAE">
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container">
                                        <div class="row" style="margin-top:20px;">
                                            <div class="col-md-4">
                                                <button type="submit" name="submit" class="display">STUDENT LIST</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <?php if (!empty($studentData)) { ?>
                                    <form method="post" onsubmit="return validateMarksForm();">
                                        <div class="card_wht mt-4">
                                            <div class="head_main">
                                                <h4 class="heading">Student List</h4>
                                            </div>
                                            <div class="card_cnt">
                                                <table class="table internalmark_table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">SI.NO</th>
                                                            <th scope="col">Name</th>
                                                            <th scope="col">Register No</th>
                                                            <th scope="col">Enter Mark</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="internalmark_table">
                                                        <?php $count = 1; foreach ($studentData as $row) { ?>
                                                            <tr>
                                                                <td><?= $count++ ?></td>
                                                                <td><?= htmlspecialchars($row['name']) ?></td>
                                                                <td>
                                                                    <?= htmlspecialchars($row['reg_no']) ?>
                                                                    <input type="hidden" name="reg_nos[]" value="<?= $row['reg_no'] ?>">
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" name="student_ids[]" value="<?= $row['id'] ?>">
                                                                    <input type="number" name="marks[]" min="0" max="100" 
                                                                           style="border:2px solid #89B0E7;border-radius:3px;width:190px;height:35px;" required>
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
                                                <input type="hidden" name="IAE" value="<?= $selectedIAE ?>">
                                                
                                                <div class="container">
                                                    <div class="row" style="margin-top:20px;">
                                                        <div class="col-md-4">
                                                            <button type="submit" name="save_marks" class="display">SUBMIT MARKS</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>  
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            const semesterDropdown = document.getElementById("semester");
            const subjectDropdown = document.getElementById("subject_module");
            const iaeDropdown = document.getElementById("IAE");

            // Function to Update Semesters Based on Selected Year
            function updateSemesters() {
                const year = document.getElementById("year").value;
                semesterDropdown.innerHTML = '<option value="">Select Semester</option>';
                
                const semesterOptions = {
                    "1": ["1", "2"],
                    "2": ["3", "4"],
                    "3": ["5", "6"],
                    "4": ["7", "8"]
                };

                if (year && semesterOptions[year]) {
                    semesterOptions[year].forEach(sem => {
                        let option = document.createElement("option");
                        option.value = sem;
                        option.textContent = `Semester ${sem}`;
                        if (sem == "<?= $selectedSemester ?>") {
                            option.selected = true;
                        }
                        semesterDropdown.appendChild(option);
                    });
                    semesterDropdown.disabled = false;
                } else {
                    semesterDropdown.disabled = true;
                    subjectDropdown.disabled = true;
                }
                
                subjectDropdown.innerHTML = '<option value="">Select Subject</option>';
                subjectDropdown.disabled = true;
                iaeDropdown.innerHTML = '<option value="">Select IAE</option>';
            }

            // Function to Fetch Subjects Based on Selected Inputs
            function updateSubjects() {
                const regulation = document.getElementById("regulation").value;
                const dept = document.getElementById("dept").value;
                const year = document.getElementById("year").value;
                const semester = document.getElementById("semester").value;

                subjectDropdown.innerHTML = '<option value="">Select Subject</option>';
                subjectDropdown.disabled = true;
                iaeDropdown.innerHTML = '<option value="">Select IAE</option>';

                const filteredSubjects = <?= json_encode($allSubjects); ?>.filter(sub => 
                    sub.regulation == regulation && 
                    sub.BRANCH == dept && 
                    sub.year == year && 
                    sub.semester == semester
                );

                if (filteredSubjects.length > 0) {
                    subjectDropdown.disabled = false;
                    filteredSubjects.forEach(sub => {
                        let option = document.createElement("option");
                        option.value = sub.id;
                        option.textContent = `${sub.subject_code} - ${sub.subject_name}`;
                        option.setAttribute("data-ltp", `${sub.L}-${sub.T}-${sub.P}`);
                        option.setAttribute("data-credits", sub.credit_POINTS);
                        if (sub.id == "<?= $selectedSubject ?>") {
                            option.selected = true;
                        }
                        subjectDropdown.appendChild(option);
                    });
                }
            }

            // Function to Update IAE Dropdown Based on Selected Subject
            function updateIAEOptions() {
                iaeDropdown.innerHTML = '<option value="">Select IAE</option>';
                const selectedOption = subjectDropdown.options[subjectDropdown.selectedIndex];
                
                if (!selectedOption || selectedOption.value === "") return;
                
                const LTP = selectedOption.getAttribute("data-ltp") || "";
                const credits = parseFloat(selectedOption.getAttribute("data-credits")) || 0;

                if ((LTP === "0-0-3" && credits === 2) || 
                    (LTP === "0-0-4" && credits === 2) || 
                    (LTP === "0-0-3" && credits === 1.5) || 
                    (LTP === "0-0-6" && credits === 3) ||
                    (LTP === "0-0-2" && credits === 1) ||
                     (LTP === "0-0-3" && credits === 1)) {
                    iaeDropdown.innerHTML += `<option value="Lab">Lab</option>`;
                } 
                else if ((LTP === "3-0-0" && credits === 3) || 
                         (LTP === "2-0-0" && credits === 2) || 
                         (LTP === "2-0-4" && credits === 4) || 
                         (LTP === "3-1-0" && credits === 4) ||
                         (LTP === "1-0-0" && credits === 1) ||
                         (LTP === "4-0-0" && credits === 4)) {
                    iaeDropdown.innerHTML += `
                        <option value="iae-1">IAE-1</option>
                        <option value="iae-2">IAE-2</option>
                        <option value="iae-3">IAE-3</option>
                        <option value="iae-4">IAE-4</option>
                        <option value="iae-5">IAE-5</option>`;
                } 
                else if ((LTP === "3-0-2" && credits === 4) ||
                        (LTP === "2-1-0" && credits === 3) ||
                        (LTP === "1-0-4" && credits === 3) ||
                        (LTP === "1-0-2" && credits === 2) ||
                        (LTP === "2-0-2" && credits === 3) ||
                        (LTP === "3-0-2" && credits === 4)) {
                    iaeDropdown.innerHTML += `
                        <option value="iae-1">IAE-1</option>
                        <option value="iae-2">IAE-2</option>
                        <option value="iae-3">IAE-3</option>
                        <option value="iae-4">IAE-4</option>
                        <option value="iae-5">IAE-5</option>
                        <option value="Lab">Lab</option>`;
                }
                
                // Set selected IAE if exists
                if ("<?= $selectedIAE ?>") {
                    iaeDropdown.value = "<?= $selectedIAE ?>";
                }
            }

            function validateForm() {
                const regulation = document.getElementById("regulation").value;
                const dept = document.getElementById("dept").value;
                const year = document.getElementById("year").value;
                const semester = document.getElementById("semester").value;

                if (!regulation || !dept || !year || !semester) {
                    alert("Please select Regulation, Department, Year and Semester");
                    return false;
                }
                return true;
            }
            
            function validateMarksForm() {
                const marks = document.querySelectorAll('input[name="marks[]"]');
                let isValid = true;
                
                marks.forEach(mark => {
                    if (mark.value === "" || mark.value < 0 || mark.value > 100) {
                        alert("Please enter valid marks (0-100) for all students");
                        isValid = false;
                        return false;
                    }
                });
                
                return isValid;
            }

            // Initialize form
            if (document.getElementById("year").value) {
                updateSemesters();
            }
            if (document.getElementById("semester").value) {
                updateSubjects();
            }
            if (document.getElementById("subject_module").value) {
                updateIAEOptions();
            }

            // Event listeners
            document.getElementById("year").addEventListener("change", updateSemesters);
            document.getElementById("semester").addEventListener("change", updateSubjects);
            document.getElementById("subject_module").addEventListener("change", updateIAEOptions);
        });
        </script>
    </body>
</html>