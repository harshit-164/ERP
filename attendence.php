<!DOCTYPE html>
<html lang="en">
    <?php include("head.php");
    include("con.php");
    ?>
    <body>
        <?php include("nav.php")?>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f9;
            }
            .card_wht {
                background: white;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                margin: 20px;
            }
            .head_main {
                border-bottom: 2px solid #ddd;
                margin-bottom: 20px;
            }
            .form-row {
                display: flex;
                justify-content: space-between;
                gap: 15px;
                margin-bottom: 20px;
            }
            .form-row div {
                flex: 1;
            }
            select, input[type="date"] {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
            button {
                background-color: #1b06ff;
                color: white;
                border: none;
                padding: 10px 20px;
                cursor: pointer;
                border-radius: 5px;
            }
            button:hover {
                background-color: #74b9ff;
            }
        </style>

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
                                <h4 class="heading">Attendance Entry</h4>
                            </div>  
                            <div class="card_cnt">
                                <div class="form-row">
                                    <div>
                                        <label for="batch">Batch:</label>
                                        <select id="batch">
                                        <option value="">Select batch</option>
                                        </select>
                                        
                                    </div>
                                    <div>
                                                <script>
                                                    var db_did=[];
                                                    var db_dbra=[];
                                                    var db_ddeg=[];
                                                </script>
                                        <label for="Degree">Degree:</label>
                                        <select id="Degree" onchange="cng_deg(this)">
                                            <option value="">Select Degree</option>
                                            <option value="B.Tech">B.Tech</option>
                                            <option value="B.E">B.E</option>
                                            <option value="MBA">MBA</option>
                                            <option value="M.E">M.E</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="Dept">Dept:</label>
                                        <select id="Dept">
                                        <option value="">Select Dept</option>

                                            <?php
                                            $sql_d="SELECT * FROM `dept`";
                                            $result_d=$conn->query($sql_d);
                                            while($row_d=$result_d->fetch_assoc()){
                                                ?>
                                                                <script>
                                                                    db_did.push("<?php echo $row_d['dept_id']?>");
                                                                    db_dbra.push("<?php echo $row_d['branch']?>");
                                                                    db_ddeg.push("<?php echo $row_d['degree']?>");

                                                                </script>
                                              
                                            <option class="deg_sel <?php echo "deg_".$row_d['dept_id']; ?>" value="<?php echo $row_d["dept_id"]?>"><?php echo $row_d["branch"]?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <script>
                                            function cng_deg(ele){
                                                var deg_sel=document.getElementsByClassName("deg_sel");
                                                for(i=0; i<deg_sel.length; i++){
                                                    deg_sel[i].style.display="none";
                                                }
                                                for(i=0; i<db_did.length; i++){
                                                    if(ele.value==db_ddeg[i]){
                                                        document.getElementsByClassName("deg_"+db_did[i])[0].style.display="block";
                                                    }
                                                }
                                            }
                                        </script>
                                <div class="form-row">
                                    <div>
                                        <label for="year">Year:</label>
                                        <select id="year" onchange="filterSemesters()">
                                        <option value="">Select Year</option>

                                            <option value="1">I</option>
                                            <option value="2">II</option>
                                            <option value="3">III</option>
                                            <option value="4">IV</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="semester">Semester:</label>
                                        <select id="semester">
                                        <option value="">Select semester</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="fromDate">Date:</label>
                                        <input type="date" id="fromDate">
                                    </div>
                                </div>
                                <button id="fetchData">GO</button>
                                <button style="margin-left: 560px "><a href="back.php" >NEXT</a></button>
                                <div id="attendanceData"></div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                populateBatches();
                filterDepartments();
                filterSemesters();
            });

            function populateBatches() {
                const batchSelect = document.getElementById("batch");
                for (let i = 2021; i <= 2030; i++) {
                    let option = document.createElement("option");
                    option.value = i;   
                    option.textContent = `${i}-${i + 4}`;
                    batchSelect.appendChild(option);
                }
            }

            

            function filterSemesters() {
                const year = document.getElementById("year").value;
                const semSelect = document.getElementById("semester");
                semSelect.innerHTML = "";
                const semOptions = {
                    "1": ["1", "2"],
                    "2": ["3", "4"],
                    "3": ["5", "6"],
                    "4": ["7", "8"]
                };
                semOptions[year].forEach(sem => {
                    let option = document.createElement("option");
                    option.value = sem;
                    option.textContent = sem;
                    semSelect.appendChild(option);
                });
            }

            document.getElementById("fetchData").addEventListener("click", function () {
    let batch = document.getElementById("batch").value.trim();
    let dept = document.getElementById("Dept").value.trim();
    let year = document.getElementById("year").value.trim();
    let dateInput = document.getElementById("fromDate");
    let date = dateInput ? dateInput.value.trim() : "";

    if (!batch || !dept || !year || !date) {
        alert("⚠ Please fill all required fields: Batch, Department, Year, and Date.");
        return;
    }

    let formData = new URLSearchParams({ batch, dept, year, date }).toString();

    fetch("fetch_attendance.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById("attendanceData").innerHTML = data;
        let selectedDate = document.getElementById("fromDate").value;
        
    })
    .catch(error => {
        console.error("❌ Error fetching data:", error);
    });
});

            document.addEventListener("click", function (event) {
    if (event.target.id === "submitAttendance") {
        event.preventDefault();
        
        let attendanceForm = document.getElementById("attendanceForm");
        if (!attendanceForm) {
            console.error("⚠ Form not found! Check ID: 'attendanceForm'");
            return;
        }

        let formData = new FormData(attendanceForm);
      

        // Ensure department is included
        let department = document.getElementById("Dept").value;
        formData.append("department", department);

        fetch("save_attendance.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
     .then(data => {
    console.log("🔄 Server Response:", data);
   
    if (data.status === "success") {
        alert(data.message);
                setTimeout(() => {
                    window.location.href = "back.php";
                }, 1000);
        
    }

        })
        .catch(error => {
            console.error("❌ Error submitting attendance:", error);
           
        });
    }
});





        </script>
    </body>
</html>
