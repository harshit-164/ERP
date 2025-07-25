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
?>

<!DOCTYPE html>
<html lang="en">
<?php include("head.php") ?>

<body>
<?php include("nav.php") ?>
<style>
    .ip label {
        width: 100%;
        display: block;
    }

    .ip select,
    .ip input {
        width: 100%;
        height: 49px;
        border: 1px solid #89B0E7;
        border-radius: 4px;
        margin-top: 10px;
    }

    .ip select:focus,
    .ip input:focus,
    input:focus {
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
        -moz-appearance: textfield;
        /* Firefox */
    }

    table {
        margin-top: 20px;
        margin-left: 25px;
        width: 0%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .pass {
        color: green;
        font-weight: bold;
    }

    .fail {
        color: red;
        font-weight: bold;
    }
</style>
<div class="frame_body">
    <?php include("sidenav.php"); ?>
    <div class="cnt_frame_main">
        <div class="cnt_frame_inner">
            <div class="breadcrumb_main text-right">
                <a href="" class="hpc_low">Home / </a>
                <span>Internal Marks</span>
            </div>
            <div class="cnt_sec">
                <div class="card_wht">
                    <div class="head_main">
                        <h4 class="heading">
                            Internal Marks
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
                                <h3>Register No: <?php echo $row['reg_no']; ?></h3>
                            </div>
                        </div>
                        <form action="" method="POST">
                            <div class="row" style="margin-left:10px;">
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
                                </div>
                                <div class="col-lg-4">
                                    <div class="ip">
                                        <label for="iae">IAE</label>
                                        <select name="iae" id="iae">
                                            <option value="">Select the IAE</option>
                                            <option value="iae-1">IAE-1</option>
                                            <option value="iae-2">IAE-2</option>
                                            <option value="iae-3">IAE-3</option>
                                            <option value="iae-4">IAE-4</option>
                                            <option value="iae-5">IAE-5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
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
                        $semester = $_POST['semester'];
                        $iae_type_selected = $_POST['iae'];
                    
                        if (!empty($semester) && !empty($iae_type_selected)) {
                            // First, get the reg_no of the student based on the enrollmentnumber
                            $sql_student_regno = "SELECT reg_no FROM students WHERE enrollmentnumber = '$enrollmentnumber'";
                            $result_student_regno = $conn->query($sql_student_regno);
                    
                            if ($result_student_regno->num_rows == 1) {
                                $row_student_regno = $result_student_regno->fetch_assoc();
                                $reg_no = $row_student_regno['reg_no'];
                    
                                // Now, use the reg_no to query the internal marks table
                                $sql_internal = "SELECT
                                                    i.subject_id,
                                                    i.`" . mysqli_real_escape_string($conn, strtolower($iae_type_selected)) . "` AS iae_marks
                                                FROM
                                                    internal i
                                                WHERE
                                                    i.reg_no = '$reg_no'
                                                    AND i.semester = '$semester'";
                    
                                $result_internal = $conn->query($sql_internal);
                    
                                if ($result_internal->num_rows > 0) {
                                    echo "<table class='table' style='margin-top: 20px; margin-left: 25px; width: 80%;'>";
                                    echo "<tr><th>S.No</th><th>Subject ID</th><th>IAE Marks</th><th>Result</th></tr>";
                                    $sno = 1;
                                    while ($row_internal = $result_internal->fetch_assoc()) {
                                        $marks = $row_internal['iae_marks'];
                                        $result_status = ($marks >= 30) ? '<span class="pass">Pass</span>' : '<span class=\"fail\">Fail</span>';
                                        echo "<tr>";
                                        echo "<td>" . $sno . "</td>";
                                        echo "<td>" . $row_internal['subject_id'] . "</td>";
                                        echo "<td>" . $marks . "</td>";
                                        echo "<td>" . $result_status . "</td>";
                                        echo "</tr>";
                                        $sno++;
                                    }
                                    echo "</table>";
                                } else {
                                    echo "<p style='margin-top: 20px;'>No internal marks found for the selected semester and IAE.</p>";
                                }
                            } else {
                                echo "<p style='margin-top: 20px;'>Error: Could not find student with the provided enrollment number.</p>";
                            }
                        } else {
                            echo "<p style='margin-top: 20px;'>Please select both Semester and IAE.</p>";
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