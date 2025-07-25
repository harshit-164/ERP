<?php

include("con.php");

$enum=$_GET["enum"];

$sql="SELECT * FROM  `students` WHERE `enrollmentnumber` ='$enum'";
$result=$conn->query($sql);
$row=$result->fetch_assoc();


$fname=explode("/",$row["certifications"]);
$fname=explode("/",$row["community"]);
$fname=explode("/",$row["fatherincome"]);
$fname=explode("/",$row["motherincome"]);
$fname=explode("/",$row["tenthmark"]);
$fname=explode("/",$row["twelfthmark"]);
$fname=explode("/",$row["tcno"]);
$fname=explode("/",$row["accountnumber"]);
$fname=explode("/",$row["aadharno"]);
$fname=explode("/",$row["pancardno"]);
$fname=explode("/",$row["firstgraduate"]);
$fname=explode("/",$row["name"]);
$fname=explode("/",$row["abccreditnumber"]);


?>


<!DOCTYPE html>
<html lang="en">
    <?php include("head.php")?>
    <body>
        <?php include("nav.php")?>
        <style>
            .card_cnt {
                position: relative;
                padding-bottom: 80px; /* Adjust this for spacing if needed */
                margin-left: 15px;
            }
           .btn-container {
                position: absolute;
                bottom: 0;
                right: 0; /* Changed this to 0 to move the button further right */
            }
            .btn-container{
                
                /* margin-right: -110px; */
                
            }

            .btn-container button {
                border: 1px solid skyblue;
                width: 134px;
                height: 49px;
                color: white;
                background: skyblue;
                border-radius: 30px;
            }
            
            input:focus,  text:focus input:active input:focus-visible {
                border:2px solid navy !important;
                outline: none !important; /* Remove default black outline */
                box-shadow:none !important;
            }
           
            select:focus{
                border:2px solid navy !important;
                outline: none !important; /* Remove default black outline */
                box-shadow:none !important;

            }
           
            input:invalid {
                border-color: red;
            }
            .ip_main input, .ip_main select, .ip_main textarea{
                padding :15px;
                width: 100%;
                border:1px solid #89B0E7;
                border-radius:4px;
            }


            .ip_main input:focus, .ip_main input:active, .ip_main input:focus-visible, .ip_main select:focus, .ip_main select:active, .ip_main select:focus-visible{
                border:2px solid #3667ac !important;
                outline: none !important;
                box-shadow: none !important;

            }
            .ip_main textarea:focus, .ip_main textarea:active, .ip_main textarea:focus-visible{
                border:2px solid #3667ac !important;
                outline: none !important;
                box-shadow: none !important;

            }

            .row{
                display:space-between;
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
                        <!-- white card section -->
                        <div class="card_wht">
                            <div class="head_main">
                                <h4 class="heading">EDIT THE STUDENT INFORMATIONS</h4>
                         </div>
                         <div class="card_cnt">
                             <div class="container">     
                                  <form id="studentForm" action="test_update.php" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
                                     <div class="row" style="row-gap:15px;">
                                        <div class="col-md-12">

                                            <h1 style="color: var(--secondary_hex);font-size: 24px;padding: 15px 0;font-weight: 600;">GENERAL DETAILS:</h1>
                                        </div>
                                          <div class="col-md-4">
                                                  <div class="ip_main">
                                                      <label>Name :</label>
                                                      <input type="text" name="name" placeholder="Name of the Student" style=""  oninput="this.value = this.value.replace(/[^A-Z. ]/g, '').toUpperCase()" value="<?php echo $row['name']; ?>">
                                                      <div style="display: flex; align-items: center; gap: 10px;">
                                                          <label for="ip_nm" name="namedocument" style="cursor: pointer; display: flex; align-items: center;">
                                                         
                                                               <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                          
                                                               <input type="file" id="ip_nm" name="ip_nm" style="height:0; width:0; padding:0;">
                                                          </label>
                                                         <span>
                                                             <?php
                                                                 if (!empty($row['namedocument'])) { // Replace 'file_path' with the actual database column for the file
                                                                       $fileUrl = htmlspecialchars($row['namedocument']); // Prevent XSS attacks
                                                                       $fname=explode("/", $fileUrl);
                                                                       $fileName = end($fname);
                                                                       echo "<a href='$fileUrl' target='_blank'>$fileName</a>";
                                                                 } else {
                                                                      echo "No file uploaded.";
                                                                   }
                                                              ?>
                                                         </span>
                                                     </div>
                                                 </div>
                                              </div>
                                              <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label> Enrollment or Application Number:</label>
                                                      <input type="text" name="enrollmentnumber" placeholder="Enrollment Number" style="" value="<?php echo $row['enrollmentnumber']; ?>"> 
                                                 </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Admission Number:</label>
                                                      <input type="text" name="admissionnumber" placeholder="Admission Numbers" style=""  value="<?php echo $row['admissionnumber']; ?>"> 
                                                  </div>
                                              </div>
                                             <div class="col-md-4">
                                                  <div class="ip_main">
                                                       <label>Degree:</label>
                                                       <select name="degree" id="degree">
                                                           <option value="B.E" <?php echo ($row['degree'] == 'B.E') ? 'selected' : ''; ?>>B.E</option>
                                                           <option value="B.TECH" <?php echo ($row['degree'] == 'B.TECH') ? 'selected' : ''; ?>>B.TECH</option>
                                                           <option value="M.E" <?php echo ($row['degree'] == 'M.E') ? 'selected' : ''; ?>>M.E</option>
                                                           <option value="M.TECH" <?php echo ($row['degree'] == 'M.TECH') ? 'selected' : ''; ?>>M.TECH</option>
                                                           <option value="MBA" <?php echo ($row['degree'] == 'MBA') ? 'selected' : ''; ?>>MBA</option>

                                                       </select>
                                                 </div>
                                             </div>
                                              
                                              <div class="col-md-4">
                                                  <div class="ip_main">
                                                       <label>Branch:</label>
                                                       <select name="branch" id="branch">
                                                           <?php
                                                            $sql_d = "SELECT * FROM dept WHERE 1";
                                                            $result_d = $conn->query($sql_d);
                                                            while($row_d = $result_d->fetch_assoc()) {
                                                                // Compare the current student's branch with each option
                                                                $selected = ($row['branch'] == $row_d['dept_id']) ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo $row_d['dept_id']; ?>" <?php echo $selected; ?>>
                                                                    <?php echo $row_d['branch']; ?>
                                                                </option>
                                                            <?php } ?>
                                                      </select>
                                                        
                                                      
                                                 </div>
                                             </div>
                                             <div class="col-md-4">
                                                  <div class="ip_main">
                                                      <label>Year:</label>
                                                      <select name="year" id="year">
                                                         <?php
                                                            $sql_y = "SELECT * FROM year WHERE 1";
                                                            $result_y = $conn->query($sql_y);
                                                            while($row_y = $result_y->fetch_assoc()) {
                                                                // Compare the current student's year with each option
                                                                $selected = ($row['year'] == $row_y['id']) ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo $row_y['id']; ?>" <?php echo $selected; ?>>
                                                                    <?php echo $row_y['name']; ?>
                                                                </option>
                                                            <?php } ?>

                                                     </select>
                                                 </div>
                                              </div>
                                              <div class="col-md-4">
                                                  <div class="ip_main">
                                                      <label>Semester:</label>
                                                      <select name="semester" id="semester">
                                                         <?php
                                                            $sql_s = "SELECT * FROM semester WHERE 1";
                                                            $result_s = $conn->query($sql_s);
                                                            while($row_s = $result_s->fetch_assoc()) {
                                                                // Compare the current student's year with each option
                                                                $selected = ($row['semester'] == $row_s['sem']) ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo $row_s['id']; ?>" <?php echo $selected; ?>>
                                                                    <?php echo $row_s['sem']; ?>
                                                               </option>
                                                           <?php } ?>
                                                      </select>
                                                 </div>
                                              </div>
                                              <div class="col-md-4">
                                                <div class="ip_main">
                                                      <label>Batch:</label>
                                                      <input type="text"  name="batch" placeholder="Batch" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)" style="" value="<?php echo $row['batch']; ?>"> 
                                                  </div>
                                              </div>
                                              <div class="col-md-4">
                                                  <div class="ip_main">
                                                      <label>Regulation</label>
                                                      <select name="regulation" name="regulation" >
                                                      <?php
                                                            $sql_r = "SELECT * FROM regulation WHERE 1";
                                                            $result_r = $conn->query($sql_r);
                                                            while($row_r = $result_r->fetch_assoc()) {
                                                                // Compare the current student's year with each option
                                                                $selected = ($row['regulation'] == $row_r['id']) ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo $row_r['id']; ?>" <?php echo $selected; ?>>
                                                                    <?php echo $row_r['regulation']; ?>
                                                               </option>
                                                           <?php } ?>
                                                     </select>
                                                  </div>
                                              </div>
                                              <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Register No:</label>
                                                      <input type="text" name="reg_no" placeholder="Reg no" style="" value="<?php echo $row['reg_no']; ?>">
                                                 </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Date of joining:</label>
                                                      <input type="date" id ="dateofjoining" name="dateofjoining" placeholder="Date of joining" style="" value="<?php echo $row['dateofjoining']; ?>" > 
                                                  </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Date of Birth:</label>
                                                      <input type="date" id ="dateofbirth" name="dateofbirth" placeholder="Date of Birth" style="" value="<?php echo $row['dateofbirth']; ?>"> 
                                                 </div>
                                             </div>
                                             <div class="col-md-4">
                                                  <div class="ip_main">
                                                      <label>Email Id:</label>
                                                      <input type="text" name="emailid" placeholder="Email Id"  oninput="this.value = this.value.toLowerCase().replace(/[^a-z0-9@.]/g, '')" style=""  value="<?php echo $row['emailid']; ?>">
                                                  </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label> Phone Number:</label>
                                                      <input type="text" name="phoneno" placeholder="Phone no" pattern="[0-9]{10}" maxlength="10"oninput="this.value = this.value.replace(/[^0-9]/g, '')" style="" value="<?php echo $row['phoneno']; ?>"> 
                                                 </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Alternate Number:</label>
                                                      <input type="text" name="alternateno" placeholder="Alternate No" pattern="[0-9]{10}" maxlength="10"oninput="this.value = this.value.replace(/[^0-9]/g, '')" style="" value="<?php echo $row['alternateno']; ?>">
                                                   </div>
                                             </div> 
                                             <div class="col-md-4">
                                                  <div class="ip_main">
                                                      <label> Gender:</label>
                                                      <select name="gender" id="Gender">
                                                          <option value="MALE" <?php echo ($row['gender'] == 'MALLE') ? 'selected' : ''; ?>>MALE</option>
                                                          <option value="FEMALE" <?php echo ($row['gender'] == 'FEMALE') ? 'selected' : ''; ?>>FEMALE</option>
                                                          <option value="OTHERS" <?php echo ($row['gender'] == 'OTHERS') ? 'selected' : ''; ?>>OTHERS</option>
                                                      </select>
                                                 </div>
                                              </div>    
                                             <div class="col-md-4">
                                                  <div class="ip_main">
                                                      <label>Blood Group:</label>
                                                      <select name="bloodgroup" id="Blood Group">
                                                          <option value="A+ve" <?php echo ($row['bloodgroup'] == 'A+ve') ? 'selected' : ''; ?>>A+ve</option>
                                                          <option value="A-ve" <?php echo ($row['bloodgroup'] == 'A-ve') ? 'selected' : ''; ?>>A-ve</option>
                                                          <option value="B+ve" <?php echo ($row['bloodgroup'] == 'B+ve') ? 'selected' : ''; ?>>B+ve</option>
                                                          <option value="B-ve" <?php echo ($row['bloodgroup'] == 'B-ve') ? 'selected' : ''; ?>>B-ve</option>
                                                          <option value="O+ve" <?php echo ($row['bloodgroup'] == 'O+ve') ? 'selected' : ''; ?>>O+ve</option>
                                                          <option value="O-ve" <?php echo ($row['bloodgroup'] == 'O-ve') ? 'selected' : ''; ?>>O-ve</option>
                                                          <option value="A1+ve" <?php echo ($row['bloodgroup'] == 'A1+ve') ? 'selected' : ''; ?>>A1+ve</option>
                                                          <option value="AB+ve" <?php echo ($row['bloodgroup'] == 'AB+ve') ? 'selected' : ''; ?>>AB+ve</option>
                                                          <option value="AB-ve" <?php echo ($row['bloodgroup'] == 'AB-ve') ? 'selected' : ''; ?>>AB-ve</option>
                                                      </select>
                                                  </div>
                                              </div>
                                              <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Religion:</label>
                                                      <select name="religion" id="religion">
                                                          <option value="hindu" <?php echo ($row['religion'] == 'hindu') ? 'selected' : ''; ?>>HINDU</option>
                                                          <option value="christian" <?php echo ($row['religion'] == 'christian') ? 'selected' : ''; ?>>CHRISTIAN</option>
                                                          <option value="muslim" <?php echo ($row['religion'] == 'muslim') ? 'selected' : ''; ?>>MUSLIM</option>
                                                          <option value="others" <?php echo ($row['religion'] == 'others') ? 'selected' : ''; ?>>OTHERS</option>
                                                     </select>
                                                  </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Community:</label>
                                                      <select name="community" id="Community">
                                                          <option value="oc" <?php echo ($row['community'] == 'oc') ? 'selected' : ''; ?>>OC</option>
                                                          <option value="bc" <?php echo ($row['community'] == 'bc') ? 'selected' : ''; ?>>BC</option>
                                                          <option value="mbc" <?php echo ($row['community'] == 'mbc') ? 'selected' : ''; ?>>MBC</option>
                                                          <option value="sc" <?php echo ($row['community'] == 'sc') ? 'selected' : ''; ?>>SC</option>
                                                          <option value="sca" <?php echo ($row['community'] == 'sca') ? 'selected' : ''; ?>>SCA</option>
                                                          <option value="st" <?php echo ($row['community'] == 'st') ? 'selected' : ''; ?>>ST</option>
                                                          <option value="others" <?php echo ($row['community'] == 'others') ? 'selected' : ''; ?>>OTHERS</option>
                                                     </select>
                                                     
                                                     <div style="display: flex; align-items: center; gap: 10px;">
                                                          <label for="ip_community" name="communitydocument" style="cursor: pointer; display: flex; align-items: center;">
                                                             <img src="assets/image/file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                             <input type="file" id="ip_community" name="ip_community" style="height:0; width:0; padding:0;">
                                                          </label>
                                                          <span>
                                                              <?php
                                                                  if (!empty($row['communitydocument'])) { // Replace 'file_path' with the actual database column for the file
                                                                      $fileUrl = htmlspecialchars($row['communitydocument']); // Prevent XSS attacks
                                                                      $fname=explode("/", $fileUrl);
                                                                      $fileName = end($fname);
                                                                      echo "<a href='$fileUrl' target='_blank'>$fileName</a>";;
                                                                   } else {
                                                                        echo "No file uploaded.";
                                                                   }
                                                                   
                                                                ?>
                                                           </span>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Community Certificate Number:</label>
                                                      <input type="text" name="communitycertificatenumber" placeholder="Community Certificate Number" style="" value="<?php echo $row['communitycertificatenumber']; ?>" >
                                                   </div>
                                             </div> 
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Caste:</label>
                                                      <input type="text" name="caste" placeholder="Caste" style="" value="<?php echo $row['caste']; ?>">
                                                   </div>
                                             </div> 
                                             <div class="col-md-4">
                                                  <div class="ip_main">
                                                       <label>Type of Entry:</label>
                                                       <select name="typeofentry" id="Type of entry">
                                                          <option value="regular" <?php echo ($row['typeofentry'] == 'regular') ? 'selected' : ''; ?>>Regular</option>
                                                          <option value="lateral" <?php echo ($row['typeofentry'] == 'lateral') ? 'selected' : ''; ?>>Lateral</option>
                                                      </select>
                                                 </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                     <label>Are u a FirstGraduate?</label>
                                                     <select name="firstgraduate" id="firstgraduate">
                                                           <option value="Yes" <?php echo ($row['firstgraduate'] == 'Yes') ? 'selected' : ''; ?>> Yes</option>
                                                          <option value="No" <?php echo ($row['firstgraduate'] == 'No') ? 'selected' : ''; ?>> No</option>
                                                      </select>
                                                       <!-- Upload Section with Icon -->
                                                       <div style="display: flex; align-items: center; gap: 10px;">
                                                          <label for="ip_fg" name="fgdocument" style="cursor: pointer; display: flex; align-items: center;">
                                                         
                                                              <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                         
                                                              <input type="file" id="ip_fg" name="ip_fg" style="height:0; width:0; padding:0;">
                                                          </label>
                                                          <span>
                                                              <?php
                                                                   if (!empty($row['fgdocument'])) { // Replace 'file_path' with the actual database column for the file
                                                                      $fileUrl = htmlspecialchars($row['fgdocument']); // Prevent XSS attacks
                                                                      $fname=explode("/", $fileUrl);
                                                                      $fileName = end($fname);
                                                                      echo "<a href='$fileUrl' target='_blank'>$fileName</a>";
                                                                   } else {
                                                                      echo "No file uploaded.";
                                                                    }
                                                                ?>
                                                          </span>
                                                      </div>
                                                 </div>
                                              </div>
                                              <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Who referanced to  joining this college?</label>
                                                      <select name="reference" id="reference">
                                                          <option value="Student"<?php echo ($row['reference'] == 'Student') ? 'selected' : ''; ?>>Student</option>
                                                          <option value="Faculty" <?php echo ($row['reference'] == 'Faculty') ? 'selected' : ''; ?>>Faculty</option>
                                                          <option value="Alumni-student"<?php echo ($row['reference'] == 'Alumni-student') ? 'selected' : ''; ?>>Alumni-Student</option>
                                                          <option value="Counselling"<?php echo ($row['reference'] == 'Counselling') ? 'selected' : ''; ?>>Counselling</option>
                                                          <option value="Others"<?php echo ($row['reference'] == 'Others') ? 'selected' : ''; ?>>Others</option>
                                                          <option value="None"<?php echo ($row['reference'] == 'None') ? 'selected' : ''; ?>>None</option>
                                                        </select>  
                                                   </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Referance Name:</label>
                                                      <input type="text" name="referencename" placeholder="referencename" oninput="this.value = this.value.replace(/[^A-Z. ]/g, '').toUpperCase()" value="<?php echo $row['referencename']; ?>" >
                                                   </div>
                                             </div> 
                                             <div class="col-md-4">
                                                  <div class="ip_main">
                                                     <label>Student Type:</label>
                                                     <select name="dayscholarorhostel" id="dayscholarorhostel" onchange="toggleTransport()">
                                                         <option value="">-- Select Type --</option>
                                                         <option value="Day Scholar" <?php echo ($row['dayscholarorhostel'] == 'Day Scholar') ? 'selected' : ''; ?>>Day Scholar</option>
                                                         <option value="Hostel" <?php echo ($row['dayscholarorhostel'] == 'Hostel') ? 'selected' : ''; ?>>Hostel</option>
                                                     </select>  
                                                 </div> 
                                             </div>
                                             <div class="col-md-4" id="transportSection" style="display: <?php echo $row['dayscholarorhostel']; ?>">
                                                  <div class="ip_main">
                                                       <label>Mode of Transport:</label>
                                                       <select name="transportmode" id="transportMode" onchange="toggleTransportMode()">
                                                           <option value="">-- Select --</option>
                                                           <option value="Train" <?php echo ($row['transportmode'] == 'Train') ? 'selected' : ''; ?>>Train</option>
                                                           <option value="College Bus" <?php echo ($row['transportmode'] == 'College Bus') ? 'selected' : ''; ?>>College Bus</option>
                                                           <option value="MTC Bus" <?php echo ($row['transportmode'] == 'MTC Bus') ? 'selected' : ''; ?>>MTC Bus</option>
                                                           <option value="Walk" <?php echo ($row['transportmode'] == 'Walk') ? 'selected' : ''; ?>>Walk</option>
                                                           <option value="Own Vehicle" <?php echo ($row['transportmode'] == 'Own Vehicle') ? 'selected' : ''; ?>>Own Vehicle</option>
                                                      </select>  
                                                  </div> 
                                              </div>
                                             <div class="col-md-4" id="vehicleDetails" style="display: <?php echo $row['transportmode']; ?>">
                                                  <div class="ip_main">
                                                      <label>Vehicle Name:</label>
                                                       <input type="text" name="vehiclename" placeholder="Enter vehicle name"  value="<?php echo $row['vehiclename']; ?>">
                                                  </div>
                                             </div>
                                             <div class="col-md-4" id="vehicleRegno" style="display: <?php echo $row['transportmode']; ?>">
                                                   <div class="ip_main">
                               
                                                       <label>Registration Number:</label>
                                                       <input type="text" name="registrationnumber" placeholder="Enter registration number" pattern="[A-Z0-9]+" title="Only capital letters (A-Z) and numbers (0-9) allowed" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '')" value="<?php echo $row['registrationnumber']; ?>">
                                                  </div> 
                                              </div>
                                              <div class="col-md-4" id="collegeBusSection" style="display:  <?php echo $row['transportmode']; ?>">
                                                  <div class="ip_main">
                                                     <label>College Bus Number:</label>
                                                     <input type="text" name="clgbusnumber" placeholder="Enter bus number"  style="" value="<?php echo $row['clgbusnumber']; ?>">
                                                 </div> 
                                             </div>
                                              <!-- Hostel Fields -->
                                             <div class="col-md-4" id="hostelSection" style="display: <?php echo $row['dayscholarorhostel']; ?>">
                                                 <div class="ip_main">
                                                     <label>Hostel Room No:</label>
                                                     <input type="text" name="hostelroomno" placeholder="Enter hostel room number" pattern="[0-9]{10}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')" style="" value="<?php echo $row['hostelroomno']; ?>">
                                                   </div>
                                               </div>
                                               <div class="col-md-4" id="wardenNameSection" style="display: <?php echo $row['dayscholarorhostel']; ?>">
                                                  <div class="ip_main">
                                                     <label>Warden Name:</label>
                                                     <input type="text" name="hostelwardenname" placeholder="Enter warden name" oninput="this.value = this.value.replace(/[^A-Z. ]/g, '').toUpperCase()" value="<?php echo $row['hostelwardenname']; ?>">
                                                   </div>
                                              </div>
                                              <div class="col-md-4" id="guardianAddressSection" style="display: <?php echo $row['dayscholarorhostel']; ?>">
                                                  <div class="ip_main">
                                                      <label>Local Guardian Address:</label>
                                                      <input type="text" name="hostelguardianaddress" placeholder="Enter local guardian address" value="<?php echo $row['hostelguardianaddress']; ?>"></textarea>
                                                   </div>
                                                </div>
                                               <div class="col-md-4" id="guardianPhoneSection" style="display: <?php echo $row['dayscholarorhostel']; ?>">
                                                    <div class="ip_main">
                                                       <label>Guardian Phone Number:</label>
                                                       <input type="text" name="hostelguardianphoneno" placeholder="Enter guardian phone number" pattern="[0-9]{10}" maxlength="10"oninput="this.value = this.value.replace(/[^0-9]/g, '')" style="" value="<?php echo $row['hostelguardianphoneno']; ?>">
                                                   </div>
                                              </div>

                                              <script>
                                                  function toggleTransport() {
                                                      const studentType = document.getElementById('dayscholarorhostel').value;
                                                      const transportSection = document.getElementById('transportSection');
                                                      const hostelSection = document.getElementById('hostelSection');
                                                      const wardenNameSection = document.getElementById('wardenNameSection');
                                                      const guardianAddressSection = document.getElementById('guardianAddressSection');
                                                      const guardianPhoneSection = document.getElementById('guardianPhoneSection');
                                                      transportSection.style.display = studentType === 'Day Scholar' ? 'block' : 'none';
                                                      // Show/hide hostel sections based on student type
                                                      hostelSection.style.display = studentType === 'Hostel' ? 'block' : 'none';
                                                      wardenNameSection.style.display = studentType === 'Hostel' ? 'block' : 'none';
                                                      guardianAddressSection.style.display = studentType === 'Hostel' ? 'block' : 'none';
                                                      guardianPhoneSection.style.display = studentType === 'Hostel' ? 'block' : 'none';
                                                      if(studentType !== 'Day Scholar') {
                                                          document.getElementById('transportMode').value = '';
                                                          document.getElementById('vehicleDetails').style.display = 'none';
                                                          document.getElementById('vehicleRegno').style.display = 'none';
                                                          document.getElementById('collegeBusSection').style.display = 'none';
                                                          
                                                        }
                                                    }
                                                  function toggleTransportMode() {
                                                       const transportMode = document.getElementById('transportMode').value;
                                                       const vehicleDetails = document.getElementById('vehicleDetails');
                                                       const vehicleRegno = document.getElementById('vehicleRegno');
                                                       const collegeBusSection = document.getElementById('collegeBusSection');
                                                       
                                                      vehicleDetails.style.display = transportMode === 'Own Vehicle' ? 'block' : 'none';
                                                      vehicleRegno.style.display = transportMode === 'Own Vehicle' ? 'block' : 'none';
                                                      collegeBusSection.style.display = transportMode === 'College Bus' ? 'block' : 'none';
                                                        if(transportMode !== 'Own Vehicle') {
                                                            document.querySelector('input[name="vehiclename"]').value = '';
                                                            document.querySelector('input[name="registrationnumber"]').value = '';
                                                            
                                            
                                                        }
                                                        if(transportMode !== 'College Bus') {
                                                           document.querySelector('input[name="clgbusnumber"]').value = '';
                                                       }
                                                    }
                                                   
                                                   


                                                   toggleTransport();
                                                   toggleTransportMode();
                                                   
                                             </script>
   
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                     <label>Whether student belongs to TamilNadu or other place:</label>
                                                     <div class="d-flex align-items-center gap-3">
                                                          <select name="belongstoTNornot" id="belongstoTNornot" class="form-control" onchange="togglePlaceInput()">
                                                               <option value="TamilNadu" <?php echo ($row['belongstoTNornot'] == 'TamilNadu') ? 'selected' : ''; ?>>TamilNadu</option>
                                                               <option value="OtherPlace" <?php echo ($row['belongstoTNornot'] != 'TamilNadu') ? 'selected' : ''; ?>>Other Place</option>
                                                          </select>
                                                      </div>
                                                      <div id="otherPlaceInput" style="display: none; flex-grow: 1;">
                                                          <input type="text" name="otherplace" class="form-control" placeholder="Enter the Place" value="<?php echo $row['belongstoTNornot']; ?>">
                                                      </div>
                                                      <script>
                                                          function togglePlaceInput() {
                                                              const dropdown = document.getElementById('belongstoTNornot');
                                                              const inputField = document.getElementById('otherPlaceInput');
                                                              if (dropdown.value != 'TamilNadu') {
                                                                //   dropdown.style.display = 'none';
                                                                  inputField.style.display = 'block';
                                                              } else {
                                                                //   dropdown.style.display = 'block';
                                                                  inputField.style.display = 'none';
                                                               }

                                                            }
                                                            togglePlaceInput()
                                                     </script>
                                                  </div>
                                             </div> 
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Identification Mark:</label>
                                                      <input type="text" name="identificationmark" placeholder="identificationmark" style="" value="<?php echo $row['identificationmark']; ?>" >
                                                   </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Mother Tongue:</label>
                                                      <input type="text" name="mothertongue" placeholder="Enter your Mother Tongue" style=""  value="<?php echo $row['mothertongue']; ?>" >
                                                   </div>
                                             </div>  
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Nationality:</label>
                                                      <input type="text" name="nationality" placeholder="Nationality" style="" value="<?php echo $row['nationality']; ?>" >
                                                   </div>
                                             </div> 
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Medium:</label>
                                                      <select name="medium" id="medium">
                                                          <option value="Tamil"<?php echo ($row['medium'] == 'Tamil') ? 'selected' : ''; ?>>Tamil</option>
                                                          <option value="English"<?php echo ($row['medium'] == 'English') ? 'selected' : ''; ?>>English</option>
                                                        </select>  
                                                 </div> 
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Do you have any physical disabilities?</label>
                                                      <select name="physicaldisabilities" id="physicaldisabilities">
                                                          <option value="YES"<?php echo ($row['physicaldisabilities'] == 'YES') ? 'selected' : ''; ?>>YES</option>
                                                          <option value="NO"<?php echo ($row['physicaldisabilities'] == 'NO') ? 'selected' : ''; ?>>NO</option>
                                                        </select>  
                                                 </div> 
                                             </div>
                                             <div class="col-md-4">
                                                <div class="ip_main" style="position: relative;">
                                                    <label>Password:</label>
                                                   
                                                    <input type="text" id="passwordInput" name="password" placeholder="Enter the Password" style="width: 100%; padding-right: 60px;" value="<?php echo $row['password']; ?>">
                                                    
                                                    <!-- Text toggle button -->
                                                    <span id="toggleText" style="position: absolute; top: 65%; right: 10px; transform: translateY(-50%); cursor: pointer; color: #007bff; font-size: 14px;">SHOW</span>
                                                </div>
                                            </div>

                                            <script>
                                                const passwordInput = document.getElementById("passwordInput");
                                                const toggleText = document.getElementById("toggleText");

                                                toggleText.addEventListener("click", () => {
                                                    const isHidden = passwordInput.type === "password";
                                                    passwordInput.type = isHidden ? "text" : "password";
                                                    toggleText.textContent = isHidden ? "SHOW" : "HIDE";
                                                });
                                            </script>
                                            <div class="col-md-12">
                                               <div class="ip_main">
                                                   <label>Address:</label>
                                                    <!-- <input type="text" name="Address" placeholder="Address" style="" required> -->
                                                 <textarea name="address" placeholder="Address"id="" value=""><?php echo $row['address']; ?></textarea>
                                             </div>
                                         </div>
                                        <div class="col-md-12">

                                            <h1 style="color: var(--secondary_hex);font-size: 24px;padding: 15px 0;font-weight: 600;">PERSONAL DETAILS:</h1>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Father Name:</label>
                                                <input type="text" name="fathername" placeholder="Father name" style="" oninput="this.value = this.value.replace(/[^A-Z. ]/g, '').toUpperCase()"value="<?php echo $row['fathername']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Father's Occupation:</label>
                                               <input type="text" name="fatheroccupation" placeholder="Father occupation" style="" value="<?php echo isset($row['fatheroccupation']) ? $row['fatheroccupation'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Father's Income:</label>
                                                <input type="text" name="fatherincome" placeholder="Father  Income" style=""value="<?php echo isset($row['fatherincome']) ? $row['fatherincome'] :'';?>" >
                                                <div style="display: flex; align-items: center; gap: 10px;">
                                                     <label for="ip_fatherincome" name="fatherincomedocument" style="cursor: pointer; display: flex; align-items: center;">
                                                         <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                           
                                                           
                                                          <input type="file" id="ip_fatherincome" name="ip_fatherincome" style="height:0; width:0; padding:0;">
                                                     </label>
                                                             <span>
                                                                 <?php
                                                                      if (!empty($row['fatherincomedocument'])) { // Replace 'file_path' with the actual database column for the file
                                                                        $fileUrl = htmlspecialchars($row['fatherincomedocument']); // Prevent XSS attacks
                                                                        $fname=explode("/", $fileUrl);
                                                                        $fileName = end($fname);
                                                                        echo "<a href='$fileUrl' target='_blank'>$fileName</a>";
                                                                    } else {
                                                                        echo "No file uploaded.";
                                                                    }
                                                                   ?>
                                                             </span>
                                                         </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Father's Number:</label>
                                                <input type="text" name="fathersnumber" placeholder="Father's Number" style="" pattern="[0-9]{10}" maxlength="10"oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="<?php echo $row['fathernumber']; ?>" >
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Mother's Name:</label>
                                                <input type="text" name="mothername" placeholder="Mother name" style=""  oninput="this.value = this.value.replace(/[^A-Z. ]/g, '').toUpperCase()" value="<?php echo $row['mothername']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Mother's Occupation:</label>
                                                <input type="text" name="motheroccupation" placeholder="Mother occupation" style="" value="<?php echo $row['motheroccupation']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Mother's Income:</label>
                                                <input type="text" name="motherincome" placeholder="Mother's Income" style="" value="<?php echo $row['motherincome']; ?>">
                                                <div style="display: flex; align-items: center; gap: 10px;">
                                                  <label for="ip_motherincome" name="motherincomedocument"style="cursor: pointer; display: flex; align-items: center;">
                                                      <img src="assets/image/file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                     <input type="file" id="ip_motherincome" name="ip_motherincome" style="height:0; width:0; padding:0;">
                                                  </label> 
                                                   <span>
                                                        <?php
                                                            if (!empty($row['motherincomedocument'])) { // Replace 'file_path' with the actual database column for the file
                                                              $fileUrl = htmlspecialchars($row['motherincomedocument']); // Prevent XSS attacks
                                                              $fname=explode("/", $fileUrl);
                                                              $fileName = end($fname);
                                                              echo "<a href='$fileUrl' target='_blank'>$fileName</a>";
                                                          } else {
                                                              echo "No file uploaded.";
                                                            }
                                                       ?>
                                                  </span>
                                              </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Mother's Number:</label>
                                                <input type="text" name="mothernumber" placeholder="Mother's Number" style=""  pattern="[0-9]{10}" maxlength="10"oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="<?php echo $row['mothernumber']; ?>">
                                            </div>
                                     </div>
                                     <div class="col-md-4">
                                         <div class="ip_main">
                                              <label for="">Is there a Guardian?</label>
                                               <ul class="list-inline mt-2">
                                                    <li class="list-inline-item">
                                                       <input type="radio" name="guardian" value="YES" id="guardian_yes" onclick="toggleGuardianFields(true)" <?php echo ($row['guardian'] == 'YES') ? 'checked' : ''; ?>>
                                                   </li>
                                                   <li class="list-inline-item">
                                                      <label for="guardian_yes">YES</label>
                                                   </li>
                                                   <li class="list-inline-item">
                                                       <input type="radio" name="guardian" value="NO" id="guardian_no" onclick="toggleGuardianFields(false)" <?php echo ($row['guardian'] == 'NO') ? 'checked' : ''; ?>>
                                                   </li>
                                                   <li class="list-inline-item">
                                                       <label for="guardian_no">NO</label>
                                                   </li>
                                              </ul>
                                           </div>
                                       </div>
                                      <!-- Guardian Details Section -->
                                      <div class="col-md-4" id="guardian_name" style="display: <?php echo ($row['guardian'] === 'YES') ? 'block' : 'none'; ?>;">
                                         <div class="ip_main">
                                             <label>Guardian Name:</label>
                                             <input type="text" name="guardianname" placeholder="Guardian Name" class="form-control" oninput="this.value = this.value.replace(/[^A-Z. ]/g, '').toUpperCase()"  value="<?php echo isset($row['guardianname']) ? $row['guardianname'] : ''; ?>">
                                          </div>
                                     </div>
                                     <div class="col-md-4" id="guardian_contact" style="display: <?php echo ($row['guardian'] === 'YES') ? 'block' : 'none'; ?>;">
                                         <div class="ip_main">
                                              <label>Guardian Contact No:</label>
                                              <input type="text" name="guardiancontactno" placeholder="Guardian Contact No" class="form-control" pattern="[0-9]{10}" maxlength="10"oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="<?php echo isset($row['guardiancontactno']) ? $row['guardiancontactno'] : ''; ?>">
                                          </div>
                                     </div>
                                     <div class="col-md-4" id="relation_field" style="display: <?php echo ($row['guardian'] === 'YES') ? 'block' : 'none'; ?>;">
                                          <div class="ip_main">
                                              <label>Relation:</label>
                                             <input type="text" name="relation" placeholder="Relation" class="form-control" value="<?php echo isset($row['relation']) ? $row['relation'] : ''; ?>">
                                          </div>
                                      </div>
                                     <div class="col-md-12" id="guardian_address" style="display: <?php echo ($row['guardian'] === 'YES') ? 'block' : 'none'; ?>;">
                                          <div class="ip_main">
                                              <label>Guardian Address:</label>
                                              <textarea name="guardianaddress" placeholder="Guardian Address" class="form-control"><?php echo $row['guardianaddress']; ?></textarea>
                                          </div>
                                       </div>
                                      <!-- JavaScript to Handle Guardian Field Visibility -->
                                      <script>
                                          window.onload = function() {
                                              var selectedRadio = document.querySelector('input[name="guardian"]:checked');
                                              toggleGuardianFields(selectedRadio.value === 'YES');
                                           };
                                          function toggleGuardianFields(show) {
                                              document.getElementById('guardian_name').style.display = show ? 'block' : 'none';
                                              document.getElementById('guardian_contact').style.display = show ? 'block' : 'none';
                                              document.getElementById('relation_field').style.display = show ? 'block' : 'none';
                                              document.getElementById('guardian_address').style.display = show ? 'block' : 'none';
                                           }
                                     </script>


                                        
                                       
                                       
                                       
                                        <div class="col-md-12">

                                            <h1 style="color: var(--secondary_hex);font-size: 24px;padding: 15px 0;font-weight: 600;">BANK DETAILS:</h1>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Bank Name:</label>
                                                <input type="text" name="bankname" placeholder="Bank name" style="" oninput="this.value = this.value.replace(/[^A-Z. ]/g, '').toUpperCase()" value="<?php echo $row['bankname']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label> Bank Branch Name :</label>
                                                <input type="text" name="bankbranchname" placeholder="Bank Branch Name " style="" value="<?php echo $row['bankbranchname']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label> Account Holder Name:</label>
                                                <input type="text" name="accountholdername" placeholder="Account Holder Name" style="" value="<?php echo $row['accountholdername']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Account Number & Passbook Document:</label>
                                                <input type="text" name="accountnumber" placeholder="Account Number" style="" value="<?php echo $row['accountnumber']; ?>">
                                                <div style="display: flex; align-items: center; gap: 10px;">
                                                   <label for="ip_acc_passbook" name="accountnumberdocument" style="cursor: pointer; display: flex; align-items: center;">
                                                      <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                      <input type="file" id="ip_acc_passbook" name="ip_acc_passbook" style="height:0; width:0; padding:0;">
                                                 </label>
                                                    <span>
                                                        <?php
                                                            if (!empty($row['accountnumberdocument'])) { // Replace 'file_path' with the actual database column for the file
                                                              $fileUrl = htmlspecialchars($row['accountnumberdocument']); // Prevent XSS attacks
                                                              $fname=explode("/", $fileUrl);
                                                              $fileName = end($fname);
                                                              echo "<a href='$fileUrl' target='_blank'>$fileName</a>";
                                                          } else {
                                                              echo "No file uploaded.";
                                                            }
                                                       ?>
                                                  </span>
                                              </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Account Type:</label>
                                                <input type="text" name="accounttype" placeholder="Account Type" style=""value="<?php echo $row['accounttype']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label> IFSC Code:</label>
                                                <input type="text" name="ifsccode" placeholder="IFSC code" style="" value="<?php echo $row['ifsccode']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label> MICR Code:</label>
                                                <input type="text" name="micrcode" placeholder="MICR code" style=""value="<?php echo $row['micrcode']; ?>" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Branch Address:</label>
                                                <input type="text" name="bankaddress" placeholder="Bank address" style=""value="<?php echo $row['bankaddress']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Aadhar No:</label>
                                                <input type="text" name="aadharno" placeholder="Aadhar no" pattern="[0-9]{4} [0-9]{4} [0-9]{4}" maxlength="14" oninput="this.value = this.value.replace(/[^0-9 ]/g, '').replace(/(\d{4})(\d{4})(\d{4})/, '$1 $2 $3').trim()"  style=""value="<?php echo $row['aadharno']; ?>" >
                                                
                                                          <div style="display: flex; align-items: center; gap: 10px;">
                                                              <label for="ip_aadhar" name="aadhardocument" style="cursor: pointer; display: flex; align-items: center;">
                                                                  <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                                  <input type="file" id="ip_aadhar" name="ip_aadhar" style="height:0; width:0; padding:0;">
                                                             </label>
                                                             <span>
                                                                 <?php
                                                                      if (!empty($row['aadhardocument'])) { // Replace 'file_path' with the actual database column for the file
                                                                        $fileUrl = htmlspecialchars($row['aadhardocument']); // Prevent XSS attacks
                                                                        $fname=explode("/", $fileUrl);
                                                                        $fileName = end($fname);
                                                                        echo "<a href='$fileUrl' target='_blank'>$fileName</a>";
                                                                    } else {
                                                                        echo "No file uploaded.";
                                                                    }
                                                                   ?>
                                                             </span>
                                                         </div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>PAN Card No:</label>
                                                <input type="text" name="pancardno" placeholder="PAN Card No" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" maxlength="10" inputmode="uppercase" style="text-transform: uppercase"  value="<?php echo $row['pancardno']; ?>">
                                                <div style="display: flex; align-items: center; gap: 10px;">
                                                    <label for="ip_pan" name="pancarddocument" style="cursor: pointer; display: flex; align-items: center;">
                                                      <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                   
                                                       <input type="file" id="ip_pan" name="ip_pan" style="height:0; width:0; padding:0;">
                                                  </label>
                                                    <span>
                                                        <?php
                                                            if (!empty($row['pancarddocument'])) { // Replace 'file_path' with the actual database column for the file
                                                              $fileUrl = htmlspecialchars($row['pancarddocument']); // Prevent XSS attacks
                                                              $fname=explode("/", $fileUrl);
                                                              $fileName = end($fname);
                                                              echo "<a href='$fileUrl' target='_blank'>$fileName</a>";
                                                          } else {
                                                              echo "No file uploaded.";
                                                            }
                                                       ?>
                                                  </span>
                                              </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Scholarship Type:</label>
                                                      <select name="scholarshiptype" id="scholarshiptype">scholarshiptype
                                                          <option value="BC/MBC Scholarship" <?php echo ($row['scholarshiptype'] == 'BC/MBC Scholarship') ? 'selected' : ''; ?>>BC/MBC Scholarship</option>
                                                          <option value="SC/ST Scholarship" <?php echo ($row['scholarshiptype'] == 'SC/ST Scholarship"') ? 'selected' : ''; ?>>SC/ST Scholarship</option>
                                                          <option value="PMSS Scholarship" <?php echo ($row['scholarshiptype'] == 'PMSS Scholarship"') ? 'selected' : ''; ?>>PSMM Scholarship</option>
                                                          <option value="None" <?php echo ($row['scholarshiptype'] == 'None') ? 'selected' : ''; ?>>None</option>
                                                     </select>
                                                  </div>
                                             </div>
                                        <div class="col-md-12">

                                            <h1 style="color: var(--secondary_hex);font-size: 24px;padding: 15px 0;font-weight: 600;">EDUCATIONAL BACKGROUND DETAILS:</h1>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>EMIS Number:</label>
                                                <input type="text" name="emisnumber" placeholder="EMIS Number" style=""value="<?php echo isset($row['emisnumber']) ? $row['emisnumber'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>UMIS Number:</label>
                                                <input type="text" name="umisnumber" placeholder="UMIS Number" style=""value="<?php echo $row['umisnumber']; ?>" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>ABC Credit Number/APAAR ID::</label>
                                                <input type="text" name="abccreditnumber" placeholder="ABC Credit Number" style=""value="<?php echo $row['abccreditnumber']; ?>" >
                                                <div style="display: flex; align-items: center; gap: 10px;">
                                                   <label for="ip_abc" name="abcdocument" style="cursor: pointer; display: flex; align-items: center;">
                                                      <img src="assets/image/file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                      <input type="file" id="ip_abc" name="ip_abc" style="height:0; width:0; padding:0;">
                                                  
                                                    </label>
                                                    <span>
                                                        <?php
                                                            if (!empty($row['abcdocument'])) { // Replace 'file_path' with the actual database column for the file
                                                              $fileUrl = htmlspecialchars($row['abcdocument']); // Prevent XSS attacks
                                                              $fname=explode("/", $fileUrl);
                                                              $fileName = end($fname);
                                                              echo "<a href='$fileUrl' target='_blank'>$fileName</a>";
                                                          } else {
                                                              echo "No file uploaded.";
                                                            }
                                                       ?>
                                                  </span>
                                              </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label> 10th Mark:</label>
                                                <input type="text" name="tenthmark" placeholder="10th Mark" style=""value="<?php echo $row['tenthmark']; ?>" >
                                                <div style="display: flex; align-items: center; gap: 10px;">
                                                   <label for="ip_ten" name="tenthdocument" style="cursor: pointer; display: flex; align-items: center;">
                                                      <img src="assets/image/file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                      <input type="file" id="ip_ten" name="ip_ten" style="height:0; width:0; padding:0;">
                                                  
                                                    </label>
                                                    <span>
                                                        <?php
                                                            if (!empty($row['tenthdocument'])) { // Replace 'file_path' with the actual database column for the file
                                                              $fileUrl = htmlspecialchars($row['tenthdocument']); // Prevent XSS attacks
                                                              $fname=explode("/", $fileUrl);
                                                              $fileName = end($fname);
                                                              echo "<a href='$fileUrl' target='_blank'>$fileName</a>";
                                                          } else {
                                                              echo "No file uploaded.";
                                                            }
                                                       ?>
                                                  </span>
                                              </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>12th Mark:</label>
                                                <input type="text" name="twelfthmark" placeholder="12th Mark" style="" value="<?php echo isset($row['twelfthmark']) ? $row['twelfthmark'] : ''; ?>">
                                                <div style="display: flex; align-items: center; gap: 10px;">
                                                    <label for="ip_twelveth" name="twelvethdocument" style="cursor: pointer; display: flex; align-items: center;">
                                                   
                                                       <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                   
                                                       <input type="file" id="ip_twelveth" name="ip_twelveth" style="height:0; width:0; padding:0;">
                                                  </label>
                                                    <span>
                                                        <?php
                                                            if (!empty($row['twelvethdocument'])) { // Replace 'file_path' with the actual database column for the file
                                                              $fileUrl = htmlspecialchars($row['twelvethdocument']); // Prevent XSS attacks
                                                              $fname=explode("/", $fileUrl);
                                                              $fileName = end($fname);
                                                              echo "<a href='$fileUrl' target='_blank'>$fileName</a>";
                                                          } else {
                                                              echo "No file uploaded.";
                                                            }
                                                       ?>
                                                  </span>
                                              </div>
                                            </div>
                                      </div>
                                      <div class="col-md-4">
                                            <div class="">
                                                <label for="">Are you a Diploma Student?:</label>
                                                <ul class="list-inline mt-2"> <!-- YES Radio Button -->
                                                    <li class="list-inline-item">
                                                         <input type="radio" name="diploma" value="YES" id="diploma_yes" onclick="toggleDiplomaFields(true)" <?php echo ($row['diploma'] == 'YES') ? 'checked' : ''; ?>>
                                                  </li>
                                                      <li class="list-inline-item">
                                                           <label for="diploma_yes">YES</label>
                                                      </li><!-- NO Radio Button -->
                                                      <li class="list-inline-item">
                                                           <input type="radio" name="diploma" value="NO" id="diploma_no" onclick="toggleDiplomaFields(false)" <?php echo ($row['diploma'] == 'NO') ? 'checked' : ''; ?>>
                                                      </li>
                                                      <li class="list-inline-item">
                                                           <label for="diploma_no">NO</label>
                                                      </li>
                                                  </ul>
                                             </div>
                                          </div> <!-- Guardian Details Section -->
                                          <div class="col-md-12" id="diploma_college" style="display: <?php echo ($row['diploma'] === 'YES') ? 'block' : 'none'; ?>;">
                                              <div class="ip_main">
                                                  <label>Where did you studied diploma college?:</label>
                                                  <input type="text" name="diplomacollege" placeholder="Enter the College Name" style="" class="form-control" value="<?php echo isset($row['diplomacollege']) ? $row['diplomacollege'] : ''; ?>">

                                             </div>
                                          </div>
                                          <div class="col-md-4"  id="diploma_course" style="display: <?php echo ($row['diploma'] === 'YES') ? 'block' : 'none'; ?>;">
                                              <div class="ip_main">
                                                   <label>Diploma Course:</label>
                                                    <input type="text" name="diplomacourse" placeholder="Diploma Course" style="" class="form-control" value="<?php echo isset($row['diplomacourse']) ? $row['diplomacourse'] : ''; ?>">
                                             </div>
                                         </div>
                                     
                                           <div class="col-md-4"  id="diploma_percentage" style="display: <?php echo ($row['diploma'] === 'YES') ? 'block' : 'none'; ?>;">
                                              <div class="ip_main">
                                                   <label>Diploma Percentage:</label>
                                                    <input type="text" name="diplomapercentage" placeholder="Diploma Percetage" style="" class="form-control" value="<?php echo isset($row['diplomapercentage']) ? $row['diplomapercentage'] : ''; ?>">
                                             </div>
                                         </div>
                                      
                                      
                                           <div class="col-md-4" id="diploma_marksheets" style="display: <?php echo ($row['diploma'] === 'YES') ? 'block' : 'none'; ?>;">
                                              <div class="ip_main">
                                                  <label> Upload the Diploma Marksheets:</label>
                                                  <label for="ip_diplomamarksheets" name="diplomamarksheetsdocument" style="cursor: pointer; display: flex; align-items: center;">
                                                   <!-- SVG Icon -->
                                                   <div style="display: flex; align-items: center; gap: 10px;">
                                                       <label for="ip_diplomamarksheets" name="diplomamarksheetsdocument" style="cursor: pointer; display: flex; align-items: center;">
                                                 
                                                          <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                   
                                                          <input type="file" id="ip_diplomamarksheets" name="ip_diplomamarksheets" style="height:0; width:0; padding:0;">
                                                      </label>
                                                    <span>
                                                        <?php
                                                            if (!empty($row['diplomamarksheetsdocument'])) { // Replace 'file_path' with the actual database column for the file
                                                              $fileUrl = htmlspecialchars($row['diplomamarksheetsdocument']); // Prevent XSS attacks
                                                              $fname=explode("/", $fileUrl);
                                                              $fileName = end($fname);
                                                              echo "<a href='$fileUrl' target='_blank'>$fileName</a>";
                                                          } else {
                                                              echo "No file uploaded.";
                                                            }
                                                       ?>
                                                  </span>
                                              </div>
                                              </div>
                                         </div>
                                      
                                      
                                          <div class="col-md-4" id="diploma_degree_certificate" style="display: <?php echo ($row['diploma'] === 'YES') ? 'block' : 'none'; ?>;">
                                              <div class="ip_main">
                                                  <label>Diploma Degree Certificate:</label>
                                                 <label for="ip_diplomadegreecertificate" name="diplomadegreecertificatedocument" style="cursor: pointer; display: flex; align-items: center;">
                                                 <div style="display: flex; align-items: center; gap: 10px;">
                                                      <label for="ip_diplomadegreecertificate" name="diplomadegreecertificatedocument" style="cursor: pointer; display: flex; align-items: center;">
                                                  
                                                          <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                  
                                                          <input type="file" id="ip_diplomadegreecertificate" name="ip_diplomadegreecertificate" style="height:0; width:0; padding:0;">
                                                     </label>
                                                      <span>
                                                          <?php
                                                              if (!empty($row['diplomadegreecertificatedocument'])) { // Replace 'file_path' with the actual database column for the file
                                                                 $fileUrl = htmlspecialchars($row['diplomadegreecertificatedocument']); // Prevent XSS attacks
                                                                 $fname=explode("/", $fileUrl);
                                                                 $fileName = end($fname);
                                                                 echo "<a href='$fileUrl' target='_blank'>$fileName</a>";
                                                              } else {
                                                                  echo "No file uploaded.";
                                                               }
                                                          ?>
                                                     </span>
                                                 </div>
                                             </div>
                                          </div>

                                                                             
                                     <script>
                                           window.onload = function() {
                                                var selectedRadio = document.querySelector('input[name="diploma"]:checked');
                                                toggleDiplomaFields(selectedRadio.value === 'YES');
                                            };
                                            function toggleDiplomaFields(show) {
                                              document.getElementById('diploma_college').style.display = show ? 'block' : 'none';
                                              document.getElementById('diploma_course').style.display = show ? 'block' : 'none';
                                              document.getElementById('diploma_percentage').style.display = show ? 'block' : 'none';
                                             document.getElementById('diploma_marksheets').style.display = show ? 'block' : 'none';
                                             document.getElementById('diploma_degree_certificate').style.display = show ? 'block' : 'none';

                                           }
                                     </script>

                                     <div class="col-md-4">
                                            <div class="">
                                              <label for="">Are you completed UG(Under Graduation)?:</label>
                                              <ul class="list-inline mt-2"> <!-- YES Radio Button -->
                                                  <li class="list-inline-item">
                                                      <input type="radio" name="ug" value="YES" id="ug_yes" onclick="toggleUgFields(true)" <?php echo ($row['ug'] == 'YES') ? 'checked' : ''; ?>>
                                                 </li>
                                                 <li class="list-inline-item">
                                                     <label for="ug_yes">YES</label>
                                                  </li><!-- NO Radio Button -->
                                                  <li class="list-inline-item">
                                                     <input type="radio" name="ug" value="NO" id="ug_no" onclick="toggleUgFields(false)" <?php echo ($row['ug'] == 'NO') ? 'checked' : ''; ?>>
                                                 </li>
                                                 <li class="list-inline-item">
                                                     <label for="ug_no">NO</label>
                                                 </li>
                                             </ul>
                                         </div>
                                     </div> <!-- Guardian Details Section -->
                                     <div class="col-md-12" id="ug_college" style="display:<?php echo ($row['ug'] === 'YES') ? 'block' : 'none'; ?>;">
                                         <div class="ip_main">
                                              <label>Where did you studied (college name)?:</label>
                                             <input type="text" name="ugcollegename" placeholder="Enter the College Name" style="" class="form-control" value="<?php echo isset($row['ugcollegename']) ? $row['ugcollegename'] : ''; ?>">
                                          </div>
                                     </div>

                                     <div class="col-md-4"  id="ug_degree" style="display:<?php echo ($row['ug'] === 'YES') ? 'block' : 'none'; ?>;">
                                         <div class="ip_main">
                                                <label>UG Degree:</label>
                                                <select name="ugdegree" id="ugdegree">
                                                  
                                                
                                                   <option value="B.E" <?php echo ($row['ugdegree'] == 'B.E') ? 'selected' : ''; ?>>B.E</option>
                                                   <option value="B.TECH" <?php echo ($row['ugdegree'] == 'B.TECH') ? 'selected' : ''; ?>>B.TECH</option>
                                                   <option value="B.ARCH" <?php echo ($row['ugdegree'] == 'B.ARCH') ? 'selected' : ''; ?>>B.ARCH</option>
                                                   <option value="B.A" <?php echo ($row['ugdegree'] == 'B.A') ? 'selected' : ''; ?>>B.A</option>
                                                   <option value="B.B.A" <?php echo ($row['ugdegree'] == 'B.B.A') ? 'selected' : ''; ?>>B.A</option>
                                                   <option value="B.SC" <?php echo ($row['ugdegree'] == 'B.SC') ? 'selected' : ''; ?>>B.SC</option>
                                                   <option value="B.COM" <?php echo ($row['ugdegree'] == 'B.COM') ? 'selected' : ''; ?>>B.COM</option>
                                              </select>
                                          </div>
                                     </div>
                                     <div class="col-md-4"  id="ug_course" style="display:<?php echo ($row['ug'] === 'YES') ? 'block' : 'none'; ?>;">
                                         <div class="ip_main">
                                                <label>UG Course Name:</label>
                                                <input type="text" name="ugcourse" placeholder="UG Course" style="" class="form-control" value="<?php echo isset($row['ugcourse']) ? $row['ugcourse'] : ''; ?>">
                                          </div>
                                     </div>
                                     
                                     <div class="col-md-4"  id="ug_percentage" style="display:<?php echo ($row['ug'] === 'YES') ? 'block' : 'none'; ?>;">
                                            <div class="ip_main">
                                                <label>UG Percentage:</label>
                                                <input type="text" name="ugpercentage" placeholder="UG Percetage" style="" class="form-control" value="<?php echo isset($row['ugpercentage']) ? $row['ugpercentage'] : ''; ?>">
                                           </div>
                                      </div>
                                      <div class="col-md-4" id="ug_marksheets" style="display:<?php echo ($row['ug'] === 'YES') ? 'block' : 'none'; ?>;">
                                            <div class="ip_main">
                                                <label> Upload the UG Marksheets:</label>
                                                <label for="ip_ugmarksheets" name="ugmarksheetsdocument" style="cursor: pointer; display: flex; align-items: center;">
                                                   <!-- SVG Icon -->
                                                <div style="display: flex; align-items: center; gap: 10px;">
                                                    <label for="ip_ugmarksheets" name="ugmarksheetsdocument" style="cursor: pointer; display: flex; align-items: center;">
                                                 
                                                     <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                   
                                                      <input type="file" id="ip_ugmarksheets" name="ip_ugmarksheets" style="height:0; width:0; padding:0;">
                                                 </label>
                                                    <span>
                                                        <?php
                                                            if (!empty($row['ugmarksheetsdocument'])) { // Replace 'file_path' with the actual database column for the file
                                                              $fileUrl = htmlspecialchars($row['ugmarksheetsdocument']); // Prevent XSS attacks
                                                              $fname=explode("/", $fileUrl);
                                                              $fileName = end($fname);
                                                              echo "<a href='$fileUrl' target='_blank'>$fileName</a>";
                                                          } else {
                                                              echo "No file uploaded.";
                                                            }
                                                       ?>
                                                  </span>
                                              </div>
                                          </div>
                                     </div>
                                     <div class="col-md-4" id="ug_degree_certificate" style="display:<?php echo ($row['ug'] === 'YES') ? 'block' : 'none'; ?>;">
                                            <div class="ip_main">
                                                <label>Upload the UG Certificate:</label>
                                                <label for="ip_ugdegreecertificate" name="ugdegreecertificatedocument" style="cursor: pointer; display: flex; align-items: center;">
                                                <div style="display: flex; align-items: center; gap: 10px;">
                                                    <label for="ip_ugdegreecertificate" name="ugdegreecertificatedocument" style="cursor: pointer; display: flex; align-items: center;">
                                                  
                                                          <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                  
                                                          <input type="file" id="ip_ugdegreecertificate" name="ip_ugdegreecertificate" style="height:0; width:0; padding:0;">
                                                  </label>
                                                   <span>
                                                       <?php
                                                            if (!empty($row['ugdegreecertificatedocument'])) { // Replace 'file_path' with the actual database column for the file
                                                               $fileUrl = htmlspecialchars($row['ugdegreecertificatedocument']); // Prevent XSS attacks
                                                               $fname=explode("/", $fileUrl);
                                                               $fileName = end($fname);
                                                               echo "<a href='$fileUrl' target='_blank'>$fileName</a>";
                                                           } else {
                                                                echo "No file uploaded.";
                                                           }
                                                         ?>
                                                   </span>
                                               </div>
                                           </div>
                                      </div>

                                                                             
                                     <script>
                                            window.onload = function() {
                                              var selectedRadio = document.querySelector('input[name="ug"]:checked');
                                              toggleUgFields(selectedRadio.value === 'YES');
                                            };
                                            function toggleUgFields(show) {
                                              document.getElementById('ug_college').style.display = show ? 'block' : 'none';
                                              document.getElementById('ug_degree').style.display = show ? 'block' : 'none';
                                              document.getElementById('ug_course').style.display = show ? 'block' : 'none';
                                              document.getElementById('ug_percentage').style.display = show ? 'block' : 'none';
                                              document.getElementById('ug_marksheets').style.display = show ? 'block' : 'none';
                                              document.getElementById('ug_degree_certificate').style.display = show ? 'block' : 'none';
                                            }
                                     </script>
                                     <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>TC No:</label>
                                                <input type="text" name="tcno" placeholder="TC No" style=""value="<?php echo $row['tcno']; ?>">
                                                <div style="display: flex; align-items: center; gap: 10px;">
                                                    <label for="ip_tc" name="tcnodocument" style="cursor: pointer; display: flex; align-items: center;">
                                        
                                                       <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                   
                                                       <input type="file" id="ip_tc" name="ip_tc" style="height:0; width:0; padding:0;">
                                                  </label>
                                                    <span>
                                                        <?php
                                                            if (!empty($row['tcnodocument'])) { // Replace 'file_path' with the actual database column for the file
                                                              $fileUrl = htmlspecialchars($row['tcnodocument']); // Prevent XSS attacks
                                                              $fname=explode("/", $fileUrl);
                                                              $fileName = end($fname);
                                                              echo "<a href='$fileUrl' target='_blank'>$fileName</a>";
                                                          } else {
                                                              echo "No file uploaded.";
                                                            }
                                                       ?>
                                                  </span>
                                              </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label> 10th Percentage:</label>
                                                <input type="text" name="tenthpercentage" placeholder="10th Percentage" style=""value="<?php echo $row['tenthpercentage']; ?>" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>12th Percentage:</label>
                                                <input type="text" name="twelfthpercentage" placeholder="12th Percentage" style="" value="<?php echo isset($row['twelfthpercentage']) ? $row['twelfthpercentage'] : ''; ?>">
                                            </div>
                                        </div>
                            

                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>DOTE/MANAGEMENT:</label>
                                                <select name="dotemanagement" id="dotemanagement" onchange="toggleDoteManagement()">
                                                    <option value="">-- Select Type --</option>
                                                    <option value="DOTE"<?php echo ($row['dotemanagement'] == 'DOTE') ? 'selected' : ''; ?>>DOTE</option>
                                                    <option value="MANAGEMENT"<?php echo ($row['dotemanagement'] == 'MANAGEMENT') ? 'selected' : ''; ?>>MANAGEMENT</option>
                                                </select>  
                                            </div> 
                                        </div>

                                        <!-- Quota selection (hidden by default) -->
                                        <div class="col-md-4" id="quotaSelection" style="display:<?php echo ($row['dotemanagement'] == 'DOTE') ? 'selected' : ''; ?>">
                                            <div class="ip_main">
                                                <label>Select the Quota:</label>
                                                <select name="quota" id="quota" onchange="toggleQuotaFields()">
                                                    <option value="">-- Select Quota --</option>
                                                    <option value="7.5 quota" <?php echo ($row['quota'] == '7.5 quota') ? 'selected' : ''; ?>>7.5 quota</option>
                                                    <option value="Sport quota" <?php echo ($row['quota'] == 'Sport quota') ? 'selected' : ''; ?> >Sport quota</option>
                                                    <option value="Ex-Service Man quota" <?php echo ($row['quota'] == 'Ex-Service Man quota') ? 'selected' : ''; ?> >Ex-Service Man quota</option>
                                                    <option value="General quota" <?php echo ($row['quota'] == 'General quota') ? 'selected' : ''; ?>>General quota</option>
                                                </select>  
                                            </div> 
                                        </div>

                                        <!-- TNEARankingNumber (hidden by default) -->
                                        <div class="col-md-4" id="additionalFields" style="display:<?php echo $row['quota']; ?>">
                                            <div class="ip_main">
                                                <label>TNEARankingNumber:</label>
                                                <input type="text" name="tnearankingnumber" id="tnearankingnumber" placeholder="Enter the TNEARankingNumber" value="<?php echo $row['tnearankingnumber']; ?>">
                                          </div>
                                        </div>

                                        <!-- CommunityRankingNumber (hidden by default) -->
                                        <div class="col-md-4" id="communityRankingField" style="display:<?php echo $row['quota']; ?>">
                                            <div class="ip_main">
                                                <label>CommunityRankingNumber:</label>
                                                <input type="text" name="communityrankingnumber" id="communityrankingnumber" placeholder="Enter the CommunityRankingNumber"  value="<?php echo $row['communityrankingnumber']; ?>"> 
                                            </div>
                                        </div>

                                        <script>
                                            function toggleDoteManagement() {
                                                var doteManagement = document.getElementById("dotemanagement").value;
                                                var quotaSelection = document.getElementById("quotaSelection");
                                                
                                                if (doteManagement === "DOTE") {
                                                    quotaSelection.style.display = "block";
                                                } else {
                                                    quotaSelection.style.display = "none";
                                                    // Reset and hide all related fields
                                                    document.getElementById("quota").selectedIndex = 0;
                                                    document.getElementById("additionalFields").style.display = "none";
                                                    document.getElementById("communityRankingField").style.display = "none";
                                                    document.getElementById("tnearankingnumber").value = "";
                                                    document.getElementById("communityrankingnumber").value = "";
                                                }
                                            }

                                            function toggleQuotaFields() {
                                                var quota = document.getElementById("quota").value;
                                                var additionalFields = document.getElementById("additionalFields");
                                                var communityRankingField = document.getElementById("communityRankingField");
                                                
                                                if (quota) {
                                                    // Show both fields for ANY selected quota
                                                    additionalFields.style.display = "block";
                                                    communityRankingField.style.display = "block";
                                                } else {
                                                    // Hide and clear fields if no quota is selected
                                                    additionalFields.style.display = "none";
                                                    communityRankingField.style.display = "none";
                                                    document.getElementById("tnearankingnumber").value = "";
                                                    document.getElementById("communityrankingnumber").value = "";
                                                }
                                            }
                                       </script>
                                      <div class="col-md-4">
                                          <div class="ip_main">
                                                <label>Cutoff:</label>
                                                <input type="text" name="cutoff" placeholder="cutoff" style="" value="<?php echo $row['cutoff']; ?>" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>10th School Name:</label>
                                                <input type="text" name="tenthschoolname" placeholder="Enter the School Name" style="" value="<?php echo $row['tenthschoolname']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>12th School Name:</label>
                                                <input type="text" name="twelvethschoolname" placeholder="Enter the School Name" style="" value="<?php echo $row['twelvethschoolname']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-12">

                                            <h1 style="color: var(--secondary_hex);font-size: 24px;padding: 15px 0;font-weight: 600;">EXTRA CURRICULAR DETAILS:</h1>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Name of the Sport:</label>
                                                <input type="text" name="sportname" placeholder="Name of the Sport" style=""value="<?php echo isset($row['sportname']) ? $row['sportname'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Sports Level:</label>
                                                <select name="sportslevel" id="Sports Level">
                                                  <option value="Beginner" <?php echo ($row['sportslevel'] == 'Beginner') ? 'selected' : ''; ?>>Beginner</option>
                                                  <option value="Intermediate" <?php echo ($row['sportslevel'] == 'Intermediate') ? 'selected' : ''; ?>>Intermediate</option>
                                                  <option value="Advance" <?php echo ($row['sportslevel'] == 'Advance') ? 'selected' : ''; ?>>Advance</option>
                                                  <option value="None" <?php echo ($row['achievements'] == 'None') ? 'selected' : ''; ?>>None</option>
                                              </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                              <label>Achievements:</label>
                                              <select name="achievements" id="Achievements">
                                                  <option value="Winner" <?php echo ($row['achievements'] == 'Winner') ? 'selected' : ''; ?>>Winner</option>
                                                  <option value="Runner-up" <?php echo ($row['achievements'] == 'Runner-up') ? 'selected' : ''; ?>>Runner-up</option>
                                                  <option value="None" <?php echo ($row['achievements'] == 'None') ? 'selected' : ''; ?>>None</option>
                                              </select>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                           <div class="ip_main">
                                               <label>Is there a Sport Certificate? Fill & Upload:</label>
                                               <select name="certifications" id="Certifications">
                                                  <option value="Yes" <?php echo ($row['certifications'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                                                  <option value="No" <?php echo ($row['certifications'] == 'No') ? 'selected' : ''; ?>>No</option>
                                             </select>
                                             <div style="display: flex; align-items: center; gap: 10px;">
                                                   <label for="ip_sport_c" name="certificationdocument" style="cursor: pointer; display: flex; align-items: center;">
                                                       <img src="assets/image/file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                      <input type="file" id="ip_sport_c" name="ip_sport_c" style="height:0; width:0; padding:0;">
                                                  </label>
                                                    <span>
                                                        <?php
                                                            if (!empty($row['certificationdocument'])) { // Replace 'file_path' with the actual database column for the file
                                                              $fileUrl = htmlspecialchars($row['certificationdocument']); // Prevent XSS attacks
                                                              $fname=explode("/", $fileUrl);
                                                              $fileName = end($fname);
                                                              echo "<a href='$fileUrl' target='_blank'>$fileName</a>";
                                                          } else {
                                                              echo "No file uploaded.";
                                                            }
                                                       ?>
                                                  </span>
                                              </div>
                                         </div>
                                      </div>
                                      <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Sports Quota Percentage:</label>
                                                <input type="text" name="sportsquotapercentage" placeholder="Sports Quota Percentage" style=""value="<?php echo $row['sportsquotapercentage']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-12">

                                         <h1 style="color: var(--secondary_hex);font-size: 24px;padding: 15px 0;font-weight: 600;">OTHER DETAILS:</h1>
                                       </div>
                                       <div class="col-md-4">
                                           <div class="ip_main">
                                               <label>Driving Known:</label>
                                               <select name="drivingknown" id="drivingknown" onchange="toggleLicenseFields()">
                                                   <option value="">-- Select --</option>
                                                   <option value="2 WHEELER" <?php echo ($row['drivingknown'] == '2 WHEELER') ? 'selected' : ''; ?>>2 WHEELER</option>
                                                   <option value="4 WHEELER" <?php echo ($row['drivingknown'] == '4 WHEELER') ? 'selected' : ''; ?>>4 WHEELER</option>
                                                   <option value="NONE" <?php echo ($row['drivingknown'] == 'NONE') ? 'selected' : ''; ?>>NONE</option>
                                             </select>
                                          </div>
                                      </div>
                                      <div class="col-md-4" id="licenseFields" style="display: <?php echo $row['drivingknown']; ?>">
                                           <div class="ip_main">
                                              <label>Driving License Number:</label>
                                              <input type="text" name="licensenumber" placeholder="Enter the License Number" value="<?php echo $row['licensenumber']; ?>">
                                          </div>
                                     </div>
                                     <div class="col-md-4" id="isuseOffice" style="display: <?php echo $row['drivingknown']; ?>">
                                         <div class="ip_main">
                                             <label>Office of Issue:</label>
                                              <input type="text" name="issueoffice"  placeholder="Enter the Office Issue" value="<?php echo $row['issueoffice']; ?>">
                                          </div>
                                      </div>
                                      <script>
                                          function toggleLicenseFields() {
                                               const drivingKnown = document.getElementById('drivingknown').value;
                                               const licenseFields = document.getElementById('licenseFields');
                                               const isuseOffice = document.getElementById('isuseOffice');

                                               if (drivingKnown === '2 WHEELER' || drivingKnown === '4 WHEELER') {
                                                  licenseFields.style.display = 'block';
                                                  isuseOffice.style.display = 'block';

                                              } else {
                                                   licenseFields.style.display = 'none';
                                                   isuseOffice.style.display = 'none';
                                                }
                                            }
                                     </script>

                                      <div class="col-md-4">
                                         <div class="ip_main">
                                              <label> Language Known:</label>
                                              <input type="text" name="languageknown" placeholder="Bank Branch Name " style="" value="<?php echo $row['languageknown']; ?>" >
                                         </div>
                                      </div>
                                     <div class="col-md-4">
                                         <div class="ip_main">
                                              <label> Any relatives are studing here ? </label>
                                              <select name="relativesstuding" id="relativesstuding" onchange="toggleRelativesStudingFields()" value="<?php echo $row['relativesstuding']; ?>">
                                                   <option value="">-- Select --</option>
                                                   <option value="YES" <?php echo ($row['relativesstuding'] == 'YES') ? 'selected' : ''; ?>>YES</option>
                                                   <option value="NO" <?php echo ($row['relativesstuding'] == 'NO') ? 'selected' : ''; ?>>NO</option>
                                             </select>
                                          </div>
                                      </div>
                                      <div class="col-md-4" id="StdName" style="display: <?php echo ($row['relativesstuding'] === 'YES') ? 'block' : 'none'; ?>;">
                                           <div class="ip_main">
                                              <label>Student Name:</label>
                                              <input type="text" name="stdname" placeholder="Enter the Student Name"  oninput="this.value = this.value.replace(/[^A-Z. ]/g, '').toUpperCase()"value="<?php echo $row['stdname']; ?>">
                                          </div>
                                     </div>
                                     <div class="col-md-4" id="StdDegree" style="display: <?php echo ($row['relativesstuding'] === 'YES') ? 'block' : 'none'; ?>;">
                                         <div class="ip_main">
                                             <label>Student Degree:</label>
                                              <select name="stddegree" id="stddegree">
                                                 <option value="">-- Select Degree --</option>
                                                 <option value="B.E"  <?php echo ($row['stddegree'] == 'B.E') ? 'selected' : ''; ?>>B.E</option>
                                                 <option value="B.TECH"  <?php echo ($row['stddegree'] == 'B.TECH') ? 'selected' : ''; ?>>B.TECH</option>
                                                 <option value="B.ARCH"  <?php echo ($row['stddegree'] == 'B.ARCH') ? 'selected' : ''; ?>>B.ARCH</option>
                                                 <option value="M.E"  <?php echo ($row['stddegree'] == 'M.E') ? 'selected' : ''; ?>>M.E</option>
                                                 <option value="M.TECH"  <?php echo ($row['stddegree'] == 'M.TECH') ? 'selected' : ''; ?>>M.TECH</option>
                                                  <option value="MBA"  <?php echo ($row['stddegree'] == 'MBA') ? 'selected' : ''; ?>>MBA</option>
                                             </select>
                                          </div>
                                      </div>
                                      <div class="col-md-4" id="StdDepartment" style="display: <?php echo ($row['relativesstuding'] === 'YES') ? 'block' : 'none'; ?>;">
                                          <div class="ip_main">
                                             <label>Department:</label>
                                             <select name="stddepartment" id="stddepartment">
                                                 <option value="">-- Select Department --</option>
                                                 <option value="CSE"  <?php echo ($row['stddepartment'] == 'CSE') ? 'selected' : ''; ?>>CSE</option>
                                                 <option value="IT" <?php echo ($row['stddepartment'] == 'IT') ? 'selected' : ''; ?>>IT</option>
                                                 <option value="ECE" <?php echo ($row['stddepartment'] == 'ECE') ? 'selected' : ''; ?>>ECE</option>
                                                 <option value="EEE" <?php echo ($row['stddepartment'] == 'EEE') ? 'selected' : ''; ?>>EEE</option>
                                                 <option value="MECH" <?php echo ($row['stddepartment'] == 'MECH') ? 'selected' : ''; ?>>MECH</option>
                                                 <option value="AERO" <?php echo ($row['stddepartment'] == 'AERO') ? 'selected' : ''; ?>>AERO</option>
                                                 <option value="AIDS" <?php echo ($row['stddepartment'] == 'AIDS') ? 'selected' : ''; ?>>AIDS</option>
                                                 <option value="BIOTECH" <?php echo ($row['stddepartment'] == 'BIOTECH') ? 'selected' : ''; ?>>BIOTECH</option>
                                                 <option value="CIVIL" <?php echo ($row['stddepartment'] == 'CIVIL') ? 'selected' : ''; ?>>CIVIL</option>
                                             </select>
                                          </div>
                                     </div>
                                     <div class="col-md-4" id="StdYear" style="display: <?php echo ($row['relativesstuding'] === 'YES') ? 'block' : 'none'; ?>;">
                                          <div class="ip_main">
                                              <label>Year:</label>
                                              <select name="stdyear" id="stdyear">
                                                  <option value="">-- Select Year--</option>
                                                  <option value="I" <?php echo ($row['stdyear'] == 'I') ? 'selected' : ''; ?>>I</option>
                                                  <option value="II" <?php echo ($row['stdyear'] == 'II') ? 'selected' : ''; ?>>II</option>
                                                  <option value="III" <?php echo ($row['stdyear'] == 'III') ? 'selected' : ''; ?>>III</option>
                                                  <option value="IV" <?php echo ($row['stdyear'] == 'IV') ? 'selected' : ''; ?>>IV</option>
                                                  <option value="V" <?php echo ($row['stdyear'] == 'V') ? 'selected' : ''; ?>>V</option>
                                              </select>
                                         </div>
                                      </div>

                                      <script>
                                          function toggleRelativesStudingFields() {
                                               const relativesstuding = document.getElementById('relativesstuding').value;
                                               const StdName = document.getElementById('StdName');
                                               const StdDegree = document.getElementById('StdDegree');
                                               const StdDepartment = document.getElementById('StdDepartment');
                                               const StdYear = document.getElementById('StdYear');
                                               if (relativesstuding === 'YES') {
                                                  StdName.style.display = 'block';
                                                  StdDegree.style.display = 'block';
                                                  StdDepartment.style.display = 'block';
                                                  StdYear.style.display = 'block';
                                                  
                                                 

                                              } else {
                                                  StdName.style.display = 'none';
                                                  StdDegree.style.display = 'none';
                                                  StdDepartment.style.display = 'none';
                                                  StdYear.style.display = 'none';
                                                }
                                            }
                                     </script>
                                       


                                       <div class="col-md-4">
                                         <div class="ip_main">
                                              <label> Any known / relative Staff or Faculty working here ? </label>
                                              <select name="relativestaffworking" id="relativestaffworking" onchange="toggleRelativeStaffWorkingFields()" value="<?php echo $row['relativestaffworking']; ?>">
                                                   <option value="">-- Select --</option>
                                                   <option value="YES" <?php echo ($row['relativestaffworking'] == 'YES') ? 'selected' : ''; ?>>YES</option>
                                                   <option value="NO" <?php echo ($row['relativestaffworking'] == 'NO') ? 'selected' : ''; ?>>NO</option>
                                             </select>
                                          </div>
                                      </div>
                                      <div class="col-md-4" id="StaffName" style="display: <?php echo ($row['relativestaffworking'] === 'YES') ? 'block' : 'none'; ?>;">
                                           <div class="ip_main">
                                              <label>Staff Name:</label>
                                              <input type="text" name="staffname" placeholder="Enter the Staff Name "  oninput="this.value = this.value.replace(/[^A-Z. ]/g, '').toUpperCase()"  value="<?php echo $row['staffname']; ?>">
                                          </div>
                                     </div>
                                     <div class="col-md-4" id="StaffWorking" style="display: <?php echo ($row['relativestaffworking'] === 'YES') ? 'block' : 'none'; ?>;">
                                         <div class="ip_main">
                                             <label>Staff Working has? :</label>
                                              <select name="staffworkinghas" id="StaffWorking">
                                                 <option value="">-- Select  --</option>
                                                 <option value="Professor" <?php echo ($row['staffworkinghas'] == 'Professor') ? 'selected' : ''; ?>>Professor</option>
                                                 <option value="Assistance-Professor" <?php echo ($row['staffworkinghas'] == 'Assistance-Professor') ? 'selected' : ''; ?>>Assistance-Professor</option>
                                                 <option value="Non-Teching Staff" <?php echo ($row['staffworkinghas'] == 'Non-Teching Staff') ? 'selected' : ''; ?>>Non-Teching Staff</option>
                                               </select>
                                          </div>
                                      </div>
                                     
                                      <script>
                                          function toggleRelativeStaffWorkingFields() {
                                               const relativestaffworking = document.getElementById('relativestaffworking').value;
                                               const StaffName = document.getElementById('StaffName');
                                               const StaffWorking = document.getElementById('StaffWorking');
                                               if (relativestaffworking === 'YES') {
                                                  StaffName.style.display = 'block';
                                                  StaffWorking.style.display = 'block';
                                               } else {
                                                  StaffName.style.display = 'none';
                                                  StaffWorking.style.display = 'none';
                                                }
                                            }
                                     </script>
                                     
                                              
                                         </div>
                                     </div>


                                        <div class="col-md-12 btn-container">
                                                <button type="submit" name="submit" class="btn btn-success btn-lg"> SUBMIT </button>
                                            </div>



                                          </div>
                                          
                                     </form>



                                    <!-- <form id="studentForm" onsubmit="return validateForm()">
                                     <div class="row" style="row-gap:15px; margin-top: 12px;">
                                        
                                        <div class="row">
                                            
                                        </div>
                                    </div>
                                          
                                     </form> -->
                                  </div>  
                             </div>
                         </div>
                     </div>
                 </div>

                        <!-- white card section end -->
                    </div>
             </div>
         </div>
     </div>

        <script>
            function validateForm() {
                var form = document.getElementById("studentForm");
                var inputs = form.querySelectorAll("input");
                var valid = true;

                inputs.forEach(function(input) {
                    if (!input.checkValidity()) {
                        valid = false;
                        input.style.borderColor = "red";
                    } else {
                        
                        input.style.borderColor = "skyblue";
                    }
                });

                return valid; // Return false if any input is invalid
            }
        </script>
    </body>