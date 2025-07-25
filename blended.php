<?php 
include("con.php");

// Fetch regulations, departments, and years                     
$regulations = mysqli_query($conn, "SELECT * FROM regulation");
$departments = mysqli_query($conn, "SELECT * FROM dept");
$years = mysqli_query($conn, "SELECT * FROM year");

// Fetch all subjects and store them in an array
$allSubjects = [];
$subjectsQuery = "SELECT id, subject_code, subject_name, year, semester, regulation, branch FROM subject_module";
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

// Fetch students when the form is submitted
$students = [];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    if (!empty($selectedYear) && !empty($selectedSemester) && !empty($selectedDept) && !empty($selectedRegulation)) {
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
                                <h4 class="heading">Blended</h4>
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
                                                <select name="regulation" id="regulation" onchange="checkAllFields()">
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
                                                <select name="dept" id="dept" onchange="checkAllFields()">
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
                                                <select name="year" id="year" onchange="updateSemesters(); checkAllFields()">
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
                                                <select name="semester" id="semester" onchange="checkAllFields()">
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
                                                <select name="subject" id="subject"  onchange="checkAllFields()" disabled>
                                                <option value="">Select Subject</option>
                                                <?php foreach ($allSubjects as $sub) { ?>
                <option value="<?= $sub['id'] ?>" <?= ($sub['id'] == $selectedSubject) ? 'selected' : '' ?>>
                    <?= $sub['subject_code'] ?> - <?= $sub['subject_name'] ?>
                </option>
            <?php } ?>
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
                            <th scope="col">Reg No</th>
                            <th scope="col">Internal</th>
                            <th scope="col">External</th>
                            <th scope="col">Total</th>
                            <th scope="col">Grade</th>
                            <th scope="col">Result</th>
                        </tr>
                    </thead>
                    <tbody id="externalmark_table">
                        <?php 
                        $count = 1; 
                        
                        while ($row = mysqli_fetch_assoc($students)) {
                            $reg_no = $row['reg_no'];
                            $studentId = $row['id'];
                           
                            // Fetch marks directly from result table
                            $resultQuery = "SELECT internal_mark, external_mark, mark FROM result 
                                           WHERE reg_no = '$reg_no' AND subject = '$selectedSubject'";
                            $resultData = mysqli_query($conn, $resultQuery);
                            $marks = mysqli_fetch_assoc($resultData);
                            
                            $internalMark = isset($marks['internal_mark']) ? $marks['internal_mark'] : 0;
                            $externalMark = isset($marks['external_mark']) ? $marks['external_mark'] : 0;
                            $total = isset($marks['mark']) ? $marks['mark'] : 0;
                            
                            $grade = getGrade($total);
                            $result = ($total < 50) ? 'Fail' : 'Pass';
                        ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['reg_no'] ?></td>
                            <td><?= round($internalMark, 2) ?></td>
                            <td><?= round($externalMark, 2) ?></td>
                            <td><?= round($total, 2) ?></td>
                            <td><?= $grade ?></td>
                            <td><?= $result ?></td>
                            <td>
                                <input type="hidden" name="student_ids[]" value="<?= $row['id'] ?>">
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
<?php } ?>
       
       </div>
       <script>
        if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    document.addEventListener("DOMContentLoaded", function () {
        const subjects = <?= json_encode($allSubjects); ?>;
        const subjectDropdown = document.getElementById("subject");
        const regulationDropdown = document.getElementById("regulation");
        const deptDropdown = document.getElementById("dept");
        const yearDropdown = document.getElementById("year");
        const semesterDropdown = document.getElementById("semester");

        function updateSubjects() {
            const regulation = Number(regulationDropdown.value);
            const dept  = Number(deptDropdown.value);
            const year = Number(yearDropdown.value);
            const semester = Number(semesterDropdown.value);

            subjectDropdown.innerHTML = '<option value="">Select Subject</option>'; // Reset dropdown

            if (regulation && dept && year && semester) {
                const filteredSubjects = subjects.filter(sub => 
                    Number(sub.regulation) === regulation && 
                    Number(sub.branch) === dept && 
                    Number(sub.year) === year && 
                    Number(sub.semester) === semester
                );

                if (filteredSubjects.length > 0) {
                    subjectDropdown.disabled = false; // Enable dropdown when subjects are found
                    filteredSubjects.forEach(sub => {
                        let option = document.createElement("option");
                        option.value = sub.id;
                        option.textContent = `${sub.subject_code} - ${sub.subject_name}`;
                        if (option.value === "<?= $selectedSubject ?>") {
                            option.selected = true;
                        }
                        subjectDropdown.appendChild(option);
                    });
                } else {
                    subjectDropdown.disabled = true; // Disable dropdown if no subjects found
                }
            } else {
                subjectDropdown.disabled = true; // Keep disabled if conditions are not met
            }
        }

        regulationDropdown.addEventListener("change", updateSubjects);
        deptDropdown.addEventListener("change", updateSubjects);
        yearDropdown.addEventListener("change", updateSubjects);
        semesterDropdown.addEventListener("change", updateSubjects);

        // Restore the subject dropdown on page load
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
        var regulation = document.getElementById("regulation").value;
        var department = document.getElementById("dept").value;
        var year = document.getElementById("year").value;
        var semester = document.getElementById("semester").value;
        var subject = document.getElementById("subject").value;
        var button = document.getElementById("studentListBtn");

        if (regulation && department && year && semester && subject) {
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
            // You can add form submission logic here
        }
    }
    </script>
    </body>
</html>