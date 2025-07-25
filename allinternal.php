<?php 
include("con.php");

// Fetch regulations, departments, and years                     
$regulations = mysqli_query($conn, "SELECT * FROM regulation");
$departments = mysqli_query($conn, "SELECT * FROM dept");
$years = mysqli_query($conn, "SELECT * FROM year");

// Default values for dropdown selections
$selectedDegree = $_POST["degree"] ?? "";
$selectedRegulation = $_POST["regulation"] ?? "";
$selectedDept = $_POST["dept"] ?? "";
$selectedYear = $_POST["year"] ?? "";
$selectedSemester = $_POST["semester"] ?? "";
$selectedSubject = $_POST["subject"] ?? "";

// Fetch students and their marks when the form is submitted
$students = [];
$subjectList = [];
$studentData = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    if (!empty($selectedDegree) && !empty($selectedRegulation) && !empty($selectedDept) && !empty($selectedYear) && !empty($selectedSemester)) {
        
        // Fetch all unique subjects for the selected filters
        $subjectsQuery = "SELECT id, subject_name, subject_code, L,T,P, credit_points, course_type
                          FROM subject_module
                          WHERE degree = '$selectedDegree'
                            AND regulation = '$selectedRegulation'
                            AND branch = '$selectedDept'
                            AND year = '$selectedYear'
                            AND semester = '$selectedSemester'";
        $subjects = mysqli_query($conn, $subjectsQuery);

        while ($subRow = mysqli_fetch_assoc($subjects)) {
            $subjectList[$subRow['id']] = [
                'subject_name' => $subRow['subject_name'],
                'subject_code' => $subRow['subject_code'],
                'L' => $subRow['L'],
                'T' => $subRow['T'],
                'P' => $subRow['P'],
                'credit_points' => $subRow['credit_points'],
                'course_type' => isset($subRow['course_type']) ? $subRow['course_type'] : 'Theory'
            ];
        }

        // Fetch students based on selected filters
        $studentsQuery = "SELECT id, reg_no, name
                          FROM students
                          WHERE degree = '$selectedDegree'
                            AND regulation = '$selectedRegulation'
                            AND branch = '$selectedDept'
                            AND year = '$selectedYear'
                            AND semester = '$selectedSemester'";
        $students = mysqli_query($conn, $studentsQuery);

        // Fetch marks for each student and subject
        while ($studentRow = mysqli_fetch_assoc($students)) {
           // $studentId = $studentRow['id'];
            $regNo = $studentRow['reg_no'];
            $name = $studentRow['name'];

            $studentData[$regNo] = [
                'reg_no' => $regNo,
                'name' => $name,
                'marks' => array_fill_keys(array_keys($subjectList), ['total_iae' => '-', 'Lab' => '-'])
            ];

            // Fetch marks for each subject for the current student
            $marksQuery = "SELECT subject_id, total_iae, Lab
                           FROM internal
                           WHERE reg_no = '$regNo'";
            $marksResult = mysqli_query($conn, $marksQuery);

            while ($marksRow = mysqli_fetch_assoc($marksResult)) {
                $subjectId = $marksRow['subject_id'];
                $totalIae = $marksRow['total_iae'];
                $lab = $marksRow['Lab'];

                if (isset($studentData[$regNo]['marks'][$subjectId])) {
                    $studentData[$regNo]['marks'][$subjectId] = ['total_iae' => $totalIae, 'Lab' => $lab];
                }
            }
        }
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
                        <span>Add fdfs</span>
                    </div>
                    <div class="cnt_sec">
                        <div class="card_wht">
                            <div class="head_main">
                                <h4 class="heading">ALL SUBJECT INTERNAL MARK</h4>
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
                                            margin-top: 20px;
                                        }
                                        input[type="number"]::-webkit-outer-spin-button,
                                        input[type="number"]::-webkit-inner-spin-button {
                                            -webkit-appearance: none;
                                            margin: 0;
                                        }
                                        input[type="number"] {
                                            -moz-appearance: textfield; 
                                        }
                                        
                                        .table-container {
                                            border: 1px solid #ddd;
                                            border-radius: 8px;
                                            padding: 15px;
                                            margin-top: 20px;
                                            background-color: #f9f9f9;
                                            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                                            overflow-x: auto;
                                        }
                                        .table-container h4 {
                                            margin-bottom: 15px;
                                        }
                                        .table {
                                            width: 100%;
                                            border-collapse: collapse;
                                            table-layout: auto;
                                        }
                                        .table th, .table td {
                                            padding: 10px;
                                            text-align: center;
                                            border: 1px solid #ddd;
                                        }
                                        .table th {
                                            background-color: #f2f2f2;
                                        }
                                    </style>

                                <form method="post">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="ip">
                                                <label for="degree">Select Degree</label>
                                                <select name="degree" id="degree" onchange="checkAllFields()">
                                                    <option value="">Select Degree</option>
                                                    <option value="B.E" <?= ($selectedDegree == 'B.E') ? 'selected' : '' ?>>B.E</option>
                                                    <option value="B.TECH" <?= ($selectedDegree == 'B.TECH') ? 'selected' : '' ?>>B.TECH</option>
                                                    <option value="M.E" <?= ($selectedDegree == 'M.E') ? 'selected' : '' ?>>M.E</option>
                                                    <option value="M.TECH" <?= ($selectedDegree == 'M.TECH') ? 'selected' : '' ?>>M.TECH</option>
                                                    <option value="MBA" <?= ($selectedDegree == 'MBA') ? 'selected' : '' ?>>MBA</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip">
                                                <label for="regulation">Select the Regulation</label>
                                                <select name="regulation" id="regulation" onchange="checkAllFields()">
                                                    <option value="">Select Regulation</option>
                                                    <?php 
                                                    mysqli_data_seek($regulations, 0); // Reset pointer
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
                                                <select name="dept" id="dept" onchange="checkAllFields()">
                                                    <option value="">Select Department</option>
                                                    <?php 
                                                    mysqli_data_seek($departments, 0); // Reset pointer
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
                                                <select name="year" id="year" onchange="updateSemesters(); checkAllFields()">
                                                    <option value="">Select Year</option>
                                                    <?php 
                                                    mysqli_data_seek($years, 0); // Reset pointer
                                                    while ($row = mysqli_fetch_assoc($years)) { ?>
                                                        <option value="<?= $row['id'] ?>" <?= ($row['id'] == $selectedYear) ? 'selected' : '' ?>>
                                                            <?= $row['name'] ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="ip">
                                                <label for="semester">Select the Semester</label>
                                                <select name="semester" id="semester" onchange="checkAllFields()">
                                                    <option value="">Select Semester</option>
                                                    <?php for ($i = 1; $i <= 8; $i++) { ?>
                                                        <option value="<?= $i ?>" <?= ($i == $selectedSemester) ? 'selected' : '' ?>><?= $i ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    
                                    </div>
                                    <!-- <div class="row" style="margin-top:20px;">
                                        <div class="col-md-4">
                                            <div class="ip">
                                                <label for="semester">Select the Semester</label>
                                                <select name="semester" id="semester" onchange="checkAllFields()">
                                                    <option value="">Select Semester</option>
                                                    <?php for ($i = 1; $i <= 8; $i++) { ?>
                                                        <option value="<?= $i ?>" <?= ($i == $selectedSemester) ? 'selected' : '' ?>><?= $i ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="container">
                                        <div class="row" style="margin-top:20px;">
                                            <div class="col-md-4">
                                                <button type="submit" name="submit" class="display">STUDENT LIST</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <?php
                                if (!empty($studentData)) {
                                ?>
                                <form method="post">
                                    <div class="card_wht mt-4 table-container">
                                        <div class="head_main">
                                            <h4 class="heading">Student List</h4>
                                        </div>
                                        <div class="card_cnt">
<table class="table externalmark_table">
    <thead>
        <tr>
            <th scope="col">SI.NO</th>
            <th scope="col">Reg No</th>
            <?php foreach ($subjectList as $subjectId => $subject) { 
                if ($subject['L'] == 3 && $subject['T'] == 0 && $subject['P'] == 2 && $subject['credit_points'] == 4.0) {
                    echo "<th scope='col'>{$subject['subject_code']} IAE</th>";
                    echo "<th scope='col'>{$subject['subject_code']} Lab</th>";
                } 
                elseif (isset($subject['course_type']) && $subject['course_type'] == 'Practical') {
                    echo "<th scope='col'>{$subject['subject_code']} Lab</th>";
                } 
                else {
                    echo "<th scope='col'>{$subject['subject_code']} IAE</th>";
                }
            } ?>
        </tr>
    </thead>
    <tbody id="blended_table">
        <?php
        $count = 1;
        foreach ($studentData as $studentId => $student) {
            echo "<tr>";
            echo "<td>{$count}</td>";
            echo "<td>{$student['reg_no']}</td>";
            
            foreach ($student['marks'] as $subjectId => $marks) {
                $subjectInfo = $subjectList[$subjectId];
                
                if ($subjectInfo['L'] == 3 && $subjectInfo['T'] == 0 && $subjectInfo['P'] == 2 && $subjectInfo['credit_points'] == 4.0) {
                    echo "<td>{$marks['total_iae']}</td>";
                    echo "<td>{$marks['Lab']}</td>";
                } 
                elseif (isset($subjectInfo['course_type']) && $subjectInfo['course_type'] == 'Practical') {
                    echo "<td>{$marks['Lab']}</td>";
                } 
                else {
                    echo "<td>{$marks['total_iae']}</td>";
                }
            }
            echo "</tr>";
            $count++;
        }
        ?>
    </tbody>
</table>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                                <button type="button" class="display" onclick="downloadPDF()">Download PDF</button>
                                            </div>
                                    
                                </form>
                                <?php } ?>
                                                                   </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }

            document.addEventListener("DOMContentLoaded", function () {
                const subjects = <?= json_encode($subjectList); ?>;
                const subjectDropdown = document.getElementById("subject");
                const degreeDropdown = document.getElementById("degree");
                const regulationDropdown = document.getElementById("regulation");
                const deptDropdown = document.getElementById("dept");
                const yearDropdown = document.getElementById("year");
                const semesterDropdown = document.getElementById("semester");

                function updateSubjects() {
                    const degree = degreeDropdown.value;
                    const regulation = Number(regulationDropdown.value);
                    const dept = Number(deptDropdown.value);
                    const year = Number(yearDropdown.value);
                    const semester = Number(semesterDropdown.value);

                    subjectDropdown.innerHTML = '<option value="">Select Subject</option>';

                    if (degree && regulation && dept && year && semester) {
                        const filteredSubjects = subjects.filter(sub => 
                            sub.degree === degree &&
                            Number(sub.regulation_id) === regulation && 
                            Number(sub.dept_id) === dept && 
                            Number(sub.year) === year && 
                            Number(sub.semester) === semester
                        );

                        if (filteredSubjects.length > 0) {
                            subjectDropdown.disabled = false;
                            filteredSubjects.forEach(sub => {
                                let option = document.createElement("option");
                                option.value = sub.id;
                                option.textContent = `${sub.subject_code} - ${sub.name}`;
                                if (option.value === "<?= $selectedSubject ?>") {
                                    option.selected = true;
                                }
                                subjectDropdown.appendChild(option);
                            });
                        } else {
                            subjectDropdown.disabled = true;
                        }
                    } else {
                        subjectDropdown.disabled = true;
                    }
                }

                degreeDropdown.addEventListener("change", updateSubjects);
                regulationDropdown.addEventListener("change", updateSubjects);
                deptDropdown.addEventListener("change", updateSubjects);
                yearDropdown.addEventListener("change", updateSubjects);
                semesterDropdown.addEventListener("change", updateSubjects);

                updateSubjects();
            });

            function updateSemesters() {
                var year = document.getElementById("year").value;
                var semesterSelect = document.getElementById("semester");
                semesterSelect.innerHTML = '<option value="">Select</option>'; 

                var semesterOptions = {
                    "1": ["1", "2"],
                    "2": ["3", "4"],
                    "3": ["5", "6"],
                    "4": ["7", "8"]
                };

                if (year) {
                    semesterOptions[year].forEach(sem => {
                        var option = document.createElement("option");
                        option.value = sem;
                        option.textContent = sem;
                        semesterSelect.appendChild(option);
                    });
                }
            }

            function checkAllFields() {
                var degree = document.getElementById("degree").value;
                var regulation = document.getElementById("regulation").value;
                var department = document.getElementById("dept").value;
                var year = document.getElementById("year").value;
                var semester = document.getElementById("semester").value;
                var subject = document.getElementById("subject").value;
                var button = document.getElementById("studentListBtn");

                if (degree && regulation && department && year && semester && subject) {
                    button.disabled = false;
                } else {
                    button.disabled = true;
                }
            }

            function validateAndSubmit() {
                var inputs = document.querySelectorAll(".marks");
                var allFilled = true;

                inputs.forEach(input => {
                    if (input.value.trim() === "") {
                        allFilled = false;
                    }
                });

                if (!allFilled) {
                    alert("Please enter marks for all students before submitting!");
                } else {
                    alert("Submitted successfully!");
                }
            }

            function downloadPDF() {
                const degree = document.getElementById("degree").value;
                const regulation = document.getElementById("regulation").value;
                const dept = document.getElementById("dept").value;
                const year = document.getElementById("year").value;
                const semester = document.getElementById("semester").value;
                
                if (degree && regulation && dept && year && semester) {
                    window.open(`internaldownload.php?degree=${degree}&regulation=${regulation}&dept=${dept}&year=${year}&semester=${semester}`, '_blank');
                } else {
                    alert("Please select all filters before downloading.");
                }
            }
        </script>
    </body>
</html>