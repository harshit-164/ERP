<?php
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

function getGradePoint($grade) {
    switch ($grade) {
        case 'O': return 10;
        case 'A+': return 9;
        case 'A': return 8;
        case 'B+': return 7;
        case 'B': return 6;
        case 'C': return 5;
        default: return 0; // Fail has 0 grade point
    }
}

// Validate and sanitize input parameters
$reg_no = isset($_GET["reg_no"]) ? trim($_GET["reg_no"]) : '';
$session = isset($_GET["session"]) ? trim($_GET["session"]) : '';
$sem = isset($_GET["sem"]) ? trim($_GET["sem"]) : '';

if (empty($reg_no) || empty($session) || empty($sem)) {
    die("Error: Required parameters (reg_no, session, sem) are missing.");
}

?>

<!DOCTYPE html>
<html lang="en">
    <?php include("head.php"); ?>
    
    <body>
        <?php include("nav.php") ?>
        
        <div class="frame_body">
            <?php include("sidenav.php"); ?>
            <div class="cnt_frame_main">
                <div class="cnt_frame_inner">
                    <div class="breadcrumb_main text-right">
                        <a href="" class="hpc_low">Home / </a>
                        <span>Add Students</span>
                    </div>
                    <div class="cnt_sec">
                        <div class="card_wht">
                            <div class="head_main">
                                <h4 class="heading">Result</h4>
                            </div>
                            <div class="card_cnt">
                                <div class="container">
                                    <div class="row">
                                        <?php
                                        // Get student details using reg_no
                                        $sql_student = "SELECT s.*, d.branch FROM students s 
                                                        LEFT JOIN dept d ON s.branch = d.dept_id 
                                                        WHERE s.reg_no = '$reg_no'";
                                        $result_student = $conn->query($sql_student);
                                        
                                        if ($result_student->num_rows === 0) {
                                            die("Error: Student with registration number $reg_no not found.");
                                        }
                                        
                                        $student_row = $result_student->fetch_assoc();
                                        ?>
                                        <div class="col-md-4">
                                            <p>Name: <?php echo htmlspecialchars($student_row["name"] ?? ''); ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <p>Register Number: <?php echo htmlspecialchars($student_row["reg_no"] ?? ''); ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <p>Branch: <?php echo htmlspecialchars($student_row["branch"] ?? ''); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        // Fetch result based on reg_no, semester, and session
                        $sql = "SELECT r.*, s.subject_code, s.credit_points 
                        FROM result r 
                        JOIN subject_module s 
                        ON r.subject = s.id
                        WHERE r.reg_no = ? AND r.semester=? AND r.session = ?"; // semster removed
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sis", $reg_no,$sem, $session);
                $stmt->execute();
                $result = $stmt->get_result();
                        if ($result->num_rows === 0) {
                            die("Error: No results found for the given register number, session, and semester.");
                        }

                        $point_arr = [];
                        $credits_arr = [];
                        $sem_arr = [];
                        $overall_result = "Pass";
                        $arrears = false;

                        while ($row_r = $result->fetch_assoc()) {
                            $t_g1 = convertToGrade($row_r["mark"]);
                            $t_p1 = getGradePoint($t_g1);
                            array_push($point_arr, $t_p1);
                            array_push($sem_arr, $row_r["semester"]);
                            array_push($credits_arr, $row_r["credit_points"]);
                        
                            if ($t_p1 == 0) {
                                $arrears = true;
                                $overall_result = "Fail";
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

                        // Debugging: Output semester GPA calculation details
                        echo "Debug: Semester Credits: $semester_credits, Weighted Grade Points: $semester_weighted_grade_points<br>";

                        // Fixed CGPA Calculation
                        $sql_semesters = "SELECT DISTINCT semester FROM result WHERE reg_no = '$reg_no' AND semester <= '$sem' ORDER BY semester";
                        $result_semesters = $conn->query($sql_semesters);

                        $total_weighted_gpa = 0;
                        $total_credits = 0;

                        while($sem_row = $result_semesters->fetch_assoc()) {
                            $current_sem = $sem_row['semester'];
                            
                            $sql_sem_gpa = "SELECT r.*, s.credit_points
                                           FROM result r
                                           JOIN subject_module s ON r.subject = s.id
                                           WHERE r.reg_no = '$reg_no' AND r.semester = '$current_sem'  AND r.mark >= 50";
                            $result_sem_gpa = $conn->query($sql_sem_gpa);
                            
                            $sem_weighted_grade_points = 0;
                            $sem_credits = 0;
                            
                            while($row_sem = $result_sem_gpa->fetch_assoc()) {
                                $grade = convertToGrade($row_sem["mark"]);
                            
                               // $grade_point = ($grade == 'U') ? 0 : getGradePoint($grade); // F = 0 GPA
                                
                                
                                if ($grade == 'U') {
                                    continue; // Do not add credits for failed subjects
                                }
                            
                               $grade_point = getGradePoint($grade);
                                $credits = $row_sem["credit_points"];
                                
                                $sem_credits += $credits;
                                $sem_weighted_grade_points += $grade_point * $credits;
                            }
                            
                            $sem_gpa = ($sem_credits > 0) ? $sem_weighted_grade_points / $sem_credits : 0;
                            $total_weighted_gpa += $sem_gpa * $sem_credits;
                            $total_credits += $sem_credits;
                            echo "Semester $current_sem Credits: " . $sem_credits . "<br>";
                        }

                        $cgpa = ($total_credits > 0) ? $total_weighted_gpa / $total_credits : 0;

                        // Debugging: Output CGPA calculation details
                        echo "Debug: Total Credits: $total_credits, Weighted GPA: $total_weighted_gpa<br>";
                        ?>
                                                ?>
                        <div class="card_wht mt-5 result_table_main">
                            <div class="head_main">
                                <h4 class="heading">
                                     <span id="overall_result">Result: <?php echo $overall_result; ?></span>
                                </h4>
                                <h4 class="heading" id="gpa_section">
                                    GPA: <span id="gpa"><?php echo $arrears ? '-' : ($semester_gpa); ?></span>
                                </h4>
                                <h4 class="heading" id="cgpa_section">
                                    CGPA: <span id="cgpa"><?php echo $arrears ? '-' : ($cgpa); ?></span>
                                </h4>
                            </div>
                            <div class="card_cnt">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Semester</th>
                                            <th scope="col">Subject Code</th>
                                            <th scope="col">Grade</th>
                                            <th scope="col">Result</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Display results
                                        $sql_display = "SELECT r.*, s.subject_code 
                                                      FROM result r
                                                      JOIN subject_module s ON r.subject = s.id
                                                      WHERE r.reg_no = ? 
                                                    
                                                      AND r.session = ?
                                                      ORDER BY r.semester";
                                                      $stmt_display = $conn->prepare($sql_display);
                                                      $stmt_display->bind_param("ss", $reg_no, $session);
                                                      $stmt_display->execute();
                                                      $result_display = $stmt_display->get_result();
                                        //$result_display = $conn->query($sql_display);
                                        
                                        while ($row = $result_display->fetch_assoc()) {
                                            $grade = convertToGrade($row['mark']);
                                            $grade_point = getGradePoint($grade);
                                            $res = ($grade_point > 0) ? "PASS" : "FAIL";
                                        ?>
                                        <tr>
                                            <td scope="row"><?php echo htmlspecialchars($row["semester"]); ?></td>
                                            <td><?php echo htmlspecialchars($row["subject_code"]); ?></td>
                                            <td><?php echo $grade; ?></td>
                                            <td class="res_final"><?php echo $res; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>                 
                            </div>
                        </div>
                        <div>
                            <?php
                            $download_url = "gen.php?reg_no=" . urlencode($reg_no) . "&session=" . urlencode($session) . "&sem=" . urlencode($sem);
                            ?>
                            <div>
                                <button 
                                    style="border-radius:5px;background-color: skyblue; width: 150px; height: 50px; border: none; color: white; border-radius: 5px; font-size: 16px; cursor: pointer;" 
                                    onclick="window.location.href='<?php echo $download_url; ?>'">
                                    Download
                                </button>
                            </div>
                        </div>
                        <script>
                            let overallResult = "<?php echo $overall_result; ?>";
                            let cgpa = <?php echo round($cgpa, 2); ?>;

                            if (overallResult == "Fail") {
                              // alert("Warning: The student has arrears. CGPA may not be accurate.");
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>   
    </body>
</html>