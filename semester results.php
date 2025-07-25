<?php
include("con.php");

$enrollmentnumber = $_GET["enrollmentnumber"];

$sql = "SELECT * FROM students WHERE enrollmentnumber ='$enrollmentnumber'";

$sql = "SELECT s.*, d.branch AS branch_name, y.name AS year_name 
        FROM students s
        LEFT JOIN dept d ON s.branch = d.dept_id
        LEFT JOIN year y ON s.year = y.id
        WHERE s.enrollmentnumber = '$enrollmentnumber'";


$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Get the student's registration number
$reg_no = $row['reg_no'];

// Function to convert marks to grade
function convertToGrade($marks) {
    if ($marks >= 90) {
        return 'O';
    } elseif ($marks >= 80) {
        return 'A+';
    } elseif ($marks >= 70) {
        return 'A';
    } elseif ($marks >= 60) {
        return 'B+';
    } elseif ($marks > 50) {
        return 'B';
    } elseif ($marks == 50) {
        return 'C';
    } else {
        return 'U';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <?php include("head.php")?>
    <body>
        <?php include("nav.php")?>
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

            /* Remove increment/decrement arrows in number input */
            input[type="number"]::-webkit-outer-spin-button,
            input[type="number"]::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
            input[type="number"] {
                -moz-appearance: textfield; /* Firefox */
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                margin-left: 25px;
            }
            th, td {
                /* border: 1px solid #ddd; */
                padding: 8px;
                text-align: left;
            }
            /* th {
                background-color: #f2f2f2;
            }
            tr:nth-child(even) {
                background-color: #f9f9f9;
            } */
            .grade-O { color: black; font-weight: bold; }
            .grade-Aplus { color: black; font-weight: bold; }
            .grade-A { color: black; font-weight: bold; }
            .grade-Bplus { color: black; font-weight: bold; }
            .grade-B { color: black; font-weight: bold; }
            .grade-C { color: black; font-weight: bold; }
            .grade-U { color: black; font-weight: bold; }
        </style>

        <div class="frame_body">
            <?php include("sidenav.php"); ?>
            <div class="cnt_frame_main">
                <div class="cnt_frame_inner">
                    <div class="breadcrumb_main text-right">
                        <a href="" class="hpc_low">Home / </a>
                        <span>Semester Results</span>
                    </div>
                    <div class="cnt_sec">
                        <!-- white card section -->
                        <div class="card_wht">
                            <div class="head_main">
                                <h4 class="heading">
                                    Semester Results
                                </h4>
                            </div>
                            
                            <div class="card_cnt">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <h3>Name: <?php echo $row['name']; ?></h3>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <h3>Degree: <?php echo $row['degree']; ?></h3>
                                    </div>                                    
                                    
                                    <div class="col-lg-4">
                                        <h3>Department: <?php echo $row['branch_name']; ?></h3>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <h3>Year: <?php echo $row['year_name']; ?></h3>
                                    </div>

                                    <div class="col-lg-4">
                                        <h3>Register No: <?php echo $row['reg_no']; ?> </h3>
                                    </div>
                                </div> <!-- end of row -->

                                <form action="" method="POST">
                                    <div class="row" style="margin-left:10px;">
                                        <div class="col-lg-4">
                                            <div class="ip">
                                                <label for="regulation">Regulation</label>
                                                <select name="regulation" id="regulation">
                                                    <option value="">Select Regulation</option>
                                                    <?php
                                                    // Fetch regulations from database
                                                    $reg_query = "SELECT * FROM regulation";
                                                    $reg_result = $conn->query($reg_query);
                                                    while($reg_row = $reg_result->fetch_assoc()) {
                                                        echo "<option value='".$reg_row['id']."'>".$reg_row['regulation']."</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div> <!-- end of col-lg-4 -->

                                        <div class="col-lg-4">
                                            <div class="ip">
                                                <label for="semester">Semester</label>
                                                <select name="semester" id="semester">
                                                    <option value="">Select Semester</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                </select>
                                            </div>
                                        </div> <!-- end of col-lg-4 -->
                                    </div> <!-- end of row -->

                                    <div class="container">
                                        <div class="row" style="margin-top:20px;">
                                            <div class="col-md-4">
                                                <button type="submit" name="submit" class="display">SUBMIT</button>
                                            </div>    
                                        </div>
                                    </div>
                                </form>

                                <?php
                                if (isset($_POST['submit'])) {
                                    $regulation = $_POST['regulation'];
                                    $semester = $_POST['semester'];
                                    
                                    // Fetch results for the selected regulation and semester
                                    $result_query = "SELECT * FROM result 
                                                    WHERE reg_no = '$reg_no' 
                                                    AND regulation_id = '$regulation' 
                                                    AND semester = '$semester'";
                                    $result_data = $conn->query($result_query);
                                    
                                    if ($result_data->num_rows > 0) {
                                        echo "<table class='table'>";
                                        echo "<tr>
                                                <th>S.No</th>
                                                <th>Semester</th>
                                                <th>Subject Code</th>
                                                <th>Grade</th>
                                              </tr>";
                                        
                                        $sno = 1;
                                        while($result_row = $result_data->fetch_assoc()) {
                                            // Calculate total marks by adding internal and external marks
                                            $total_marks = $result_row['internal_mark'] + $result_row['external_mark'];
                                            $grade = convertToGrade($total_marks);
                                            $grade_class = 'grade-' . str_replace('+', 'plus', $grade);
                                            
                                            echo "<tr>";
                                            echo "<td>" . $sno . "</td>";
                                            echo "<td>" . $result_row['semester'] . "</td>";
                                            echo "<td>" . $result_row['subject'] . "</td>";
                                            echo "<td class='$grade_class'>" . $grade . "</td>";
                                            echo "</tr>";
                                            $sno++;
                                        }
                                        echo "</table>";
                                    } else {
                                        echo "<p style='margin-top: 20px;'>No results found for the selected regulation and semester.</p>";
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>