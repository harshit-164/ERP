 <!DOCTYPE html>
<html lang="en">
    <?php include("con.php")?>
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
                                <h4 class="heading">STUDENT INFORMATIONS</h4>
                         </div>
                         <div class="card_cnt">
                             <div class="container">     
                                  <form id="studentForm" action="addstud.php" method="post" onsubmit="return validateForm()"  enctype="multipart/form-data">
                                     <div class="row" style="row-gap:15px;">
                                        <div class="col-md-12">

                                            <h1 style="color: var(--secondary_hex);font-size: 24px;padding: 15px 0;font-weight: 600;">GENERAL DETAILS:</h1>
                                        </div>   
                                          <div class="col-md-4">
                                                  <div class="ip_main">
                                                      <label>Name :</label>
                                                      <input type="text" name="name" placeholder="Name of the Student" style=""   oninput="this.value = this.value.replace(/[^A-Z. ]/g, '').toUpperCase()" >
                                                      <label for="ip_nm" name="namedocument" style="cursor: pointer; display: flex; align-items: center;">
                                                         <!-- SVG Icon -->
                                                           <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                            Upload File
                                                          <input type="file" id="ip_nm" name="ip_nm" style="height:0; width:0; padding:0;">
                                                      </label>
                                                  </div>
                                              </div>
                                              <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label> Enrollment or Application Number :</label>
                                                      <input type="text" name="enrollmentnumber" placeholder="EnrollmentNumber" onblur="validateEnrollmentNumber()" style="" > 
                                                      <script>
                                                            const enteredEnrollmentNumbers = new Set();
                                                            function validateEnrollmentNumber() {
                                                                const inputField = document.querySelector('input[name="enrollmentnumber"]');
                                                                const enrollmentNumber = inputField.value.trim();
                                                                if (enteredEnrollmentNumbers.has(enrollmentNumber)) {
                                                                   alert("This enrollment number is already entered. Please enter a unique number.");
                                                                  inputField.value = ""; // Clear the input field
                                                                 return false;
                                                                }
                                                                if (enrollmentNumber !== "") {
                                                                   enteredEnrollmentNumbers.add(enrollmentNumber); // Add to the set
                                                                }
                                                                return true;
                                                            }
                                                     </script>
                                                  </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Admission Numbers:</label>
                                                      <input type="text" name="admissionnumber" placeholder="Admission Numbers" style="" > 
                                                  </div>
                                              </div>
                                             <div class="col-md-4">
                                                  <div class="ip_main">
                                                       <label>Degree:</label>
                                                       <select name="degree" id="degree">
                                                          <option value="B.E">B.E</option>
                                                          <option value="B.TECH">B.TECH</option>
                                                          <option value="M.E">M.E</option>
                                                          <option value="M.TECH">M.TECH</option>
                                                          <option value="MBA">MBA</option>
                                                     </select>
                                                 </div>
                                             </div>
                                              
                                             <div class="col-md-4">
                                                  <div class="ip_main">
                                                       <label>Branch:</label>
                                                       <select name="branch" id="branch">
                                                         <!-- <option value="1">CSE</option>
                                                          <option value="2">IT</option>
                                                          <option value="3">BIO</option>
                                                          <option value="4">MECH</option>
                                                          <option value="5">EEE</option>
                                                          <option value="6">AERO</option>
                                                          <option value="7">ECE</option>
                                                          <option value="8">CIVIL</option>
                                                          <option value="9">AIDS</option>
                                                          <option value="10">CHEM</option> -->
                                                     
                                                   
                                                          
                                                            <?php
                                                            
                                                            $sql_d="SELECT * FROM dept WHERE 1";
                                                            $result_d=$conn->query($sql_d);
                                                            while($row_d=$result_d->fetch_assoc()){
                                                            
                                                            ?>

                                                                    <option value="<?php echo $row_d['dept_id']?>" ><?php echo $row_d['branch']; ?></option>
                                                            <?php } ?>
                                                            
                                                     </select>
                                                 </div>
                                             </div>
                                             <div class="col-md-4">
                                                  <div class="ip_main">
                                                      <label>Year:</label>
                                                      <select name="year" id="year">
                                                      <?php
                                                            
                                                            $sql_d="SELECT * FROM `year` WHERE 1";
                                                            $result_d=$conn->query($sql_d);
                                                            while($row_d=$result_d->fetch_assoc()){
                                                            
                                                            ?>

                                                                    <option value="<?php echo $row_d['id']?>" ><?php echo $row_d['name']; ?></option>
                                                            <?php } ?>
                                                     </select>
                                                 </div>
                                              </div>
                                              <div class="col-md-4">
                                                  <div class="ip_main">
                                                      <label>Semester:</label>
                                                      <select name="semester" id="semester">
                                                         
                                                      <?php
                                                            
                                                            $sql_d="SELECT * FROM `semester` WHERE 1";
                                                            $result_d=$conn->query($sql_d);
                                                            while($row_d=$result_d->fetch_assoc()){
                                                            
                                                            ?>

                                                                    <option value="<?php echo $row_d['id']?>" ><?php echo $row_d['sem']; ?></option>
                                                            <?php } ?>
                                                            
                                                     </select>
                                                 </div>
                                              </div>

                                              <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Batch:</label>
                                                      <input type="year" name="batch" placeholder="Batch" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)" style="" > 
                                                  </div>
                                              </div>
                                              <div class="col-md-4">
                                                  <div class="ip_main">
                                                      <label>Regulation</label>
                                                      <select name="regulation" id="regulation">
                                                      <?php
                                                            
                                                            $sql_d="SELECT * FROM `regulation` WHERE 1";
                                                            $result_d=$conn->query($sql_d);
                                                            while($row_d=$result_d->fetch_assoc()){
                                                            
                                                            ?>

                                                                    <option value="<?php echo $row_d['id']?>" ><?php echo $row_d['regulation']; ?></option>
                                                            <?php } ?>
                                                     </select>
                                                  </div>
                                              </div>
                                              <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Register No:</label>
                                                      <input type="text" name="reg_no" placeholder="Reg no" style="" >
                                                 </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Date of joining:</label>
                                                      <input type="date" id ="dateofjoining" name="dateofjoining" placeholder="Date of joining" style="" > 
                                                  </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Date of Birth:</label>
                                                      <input type="date" id ="dateofbirth" name="dateofbirth" placeholder="Date of Birth" style="" > 
                                                 </div>
                                             </div>
                                             <div class="col-md-4">
                                                  <div class="ip_main">
                                                      <label>Email Id:</label>
                                                      <input type="text" name="emailid" placeholder="Email Id" oninput="this.value = this.value.toLowerCase().replace(/[^a-z0-9@.]/g, '')" style="">
                                                  </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label> Phone Number:</label>
                                                      <input type="text" name="phoneno" placeholder="Phone no"  pattern="[0-9]{10}" maxlength="10"oninput="this.value = this.value.replace(/[^0-9]/g, '')" style=""> 
                                                 </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Alternate Number:</label>
                                                      <input type="text" name="alternateno" placeholder="Alternate No" pattern="[0-9]{10}" maxlength="10"oninput="this.value = this.value.replace(/[^0-9]/g, '')" style=""> 
                                                   </div>
                                             </div> 
                                             <div class="col-md-4">
                                                  <div class="ip_main">
                                                      <label> Gender:</label>
                                                      <select name="gender" id="Gender">
                                                          <option value="MALE">MALE</option>
                                                          <option value="FEMALE">FEMALE</option>
                                                          <option value="OTHERS">OTHERS</option>
                                                      </select>
                                                 </div>
                                              </div>    
                                             <div class="col-md-4">
                                                  <div class="ip_main">
                                                      <label>Blood Group:</label>
                                                      <select name="bloodgroup" id="Blood Group">
                                                          <option value="A+ve">A+ve</option>
                                                          <option value="A-ve">A-ve</option>
                                                          <option value="B+ve">B+ve</option>
                                                          <option value="B-ve">B-ve</option>
                                                          <option value="O+ve">O+ve</option>
                                                          <option value="O-ve">O-ve</option>
                                                          <option value="AB+ve">A1+ve</option>
                                                          <option value="AB+ve">AB+ve</option>
                                                          <option value="AB-ve">AB-ve</option>
                                                      </select>
                                                 </div>
                                              </div>
                                              <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Religion:</label>
                                                      <select name="religion" id="religion">
                                                          <option value="hindu">HINDU</option>
                                                          <option value="christian">CHRISTIAN</option>
                                                          <option value="muslim">MUSLIM</option>
                                                          <option value="others">OTHERS</option>
                                                     </select>
                                                  </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Community:</label>
                                                      <select name="community" id="Community">
                                                          <option value="oc">OC</option>
                                                          <option value="bc">BC</option>
                                                          <option value="mbc">MBC</option>
                                                          <option value="sc">SC</option>
                                                          <option value="sca">SCA</option>
                                                          <option value="st">ST</option>
                                                          <option value="others">OTHERS</option>
                                                     </select>
                                                     <label for="ip_community" name="communitydocument" style="cursor: pointer; display: flex; align-items: center;">
                                                         <!-- SVG Icon -->
                                                          <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                           Upload File
                                                           
                                                          <input type="file" id="ip_community" name="ip_community" style="height:0; width:0; padding:0;">
                                                     </label>
                                                 </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Community Certificate Number:</label>
                                                      <input type="text" name="communitycertificatenumber" placeholder="Community Certificate Number" style="" >
                                                   </div>
                                             </div> 
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Caste:</label>
                                                      <input type="text" name="caste" placeholder="Caste" style="" >
                                                   </div>
                                             </div> 
                                             <div class="col-md-4">
                                                  <div class="ip_main">
                                                       <label>Type of Entry:</label>
                                                       <select name="typeofentry" id="Type of entry">
                                                          <option value="regular">Regular</option>
                                                          <option value="lateral">Lateral</option>
                                                      </select>
                                                 </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                     <label>Are u a FirstGraduate?</label>
                                                     <select name="firstgraduate" id="firstgraduate">
                                                           <option value="Yes">Yes</option>
                                                          <option value="No">No</option>
                                                      </select>
                                                       <!-- Upload Section with Icon -->
                                                      <label for="ip_fg" name="fgdocument" style="cursor: pointer; display: flex; align-items: center;">
                                                         <!-- SVG Icon -->
                                                           <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                          Upload File
                                                          <input type="file" id="ip_fg" name="ip_fg" style="height:0; width:0;  padding:0;">
                                                      </label>
                                                 </div>
                                              </div>
                                              <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Who referanced to  joining this college?</label>
                                                      <select name="reference" id="reference">
                                                          <option value="Student">Student</option>
                                                          <option value="Faculty">Faculty</option>
                                                          <option value="Alumni-Student">Alumni-Student</option>
                                                          <option value="Counselling">counselling</option>
                                                          <option value="Others">Others</option>
                                                          <option value="None">None</option>
                                                        </select> 
                                                   </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Referance Name:</label>
                                                      <input type="text" name="referencename" placeholder="referencename"  oninput="this.value = this.value.replace(/[^A-Z. ]/g, '').toUpperCase()" style="" >
                                                   </div>
                                             </div>  
                                             <div class="col-md-4">
                                                  <div class="ip_main">
                                                     <label>Student Type:</label>
                                                     <select name="dayscholarorhostel" id="dayscholarorhostel" onchange="toggleTransport()">
                                                         <option value="">-- Select Type --</option>
                                                         <option value="Day Scholar">Day Scholar</option>
                                                         <option value="Hostel">Hostel</option>
                                                     </select>  
                                                 </div> 
                                             </div>
                                             <div class="col-md-4" id="transportSection" style="display: none;">
                                                  <div class="ip_main">
                                                       <label>Mode of Transport:</label>
                                                       <select name="transportmode" id="transportMode" onchange="toggleTransportMode()">
                                                           <option value="">-- Select --</option>
                                                           <option value="Train">Train</option>
                                                           <option value="College Bus">College Bus</option>
                                                           <option value="MTC Bus">MTC Bus</option>
                                                           <option value="Walk">Walk</option>
                                                           <option value="Own Vehicle">Own Vehicle</option>
                                                      </select>  
                                                  </div> 
                                              </div>
                                             <div class="col-md-4" id="vehicleDetails" style="display: none;">
                                                  <div class="ip_main">
                                                      <label>Vehicle Name:</label>
                                                       <input type="text" name="vehiclename" placeholder="Enter vehicle name">
                                                  </div>
                                             </div>
                                             <div class="col-md-4" id="vehicleRegno" style="display: none;">
                                                   <div class="ip_main">
                               
                                                       <label>Registration Number:</label>
                                                       <input type="text" name="registrationnumber" placeholder="Enter registration number" style="" pattern="[A-Z0-9]+" title="Only capital letters (A-Z) and numbers (0-9) allowed" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '')">
                                                  </div> 
                                              </div>
                                              <div class="col-md-4" id="collegeBusSection" style="display: none;">
                                                  <div class="ip_main">
                                                     <label>College Bus Number:</label>
                                                     <input type="text" name="clgbusnumber" placeholder="Enter bus number"  style="">
                                                 </div> 
                                             </div>
                                              <!-- Hostel Fields -->
                                             <div class="col-md-4" id="hostelSection" style="display: none;">
                                                 <div class="ip_main">
                                                     <label>Hostel Room No:</label>
                                                     <input type="text" name="hostelroomno" placeholder="Enter hostel room number" pattern="[0-9]{10}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')" style="">
                                                   </div>
                                               </div>
                                               <div class="col-md-4" id="wardenNameSection" style="display: none;">
                                                  <div class="ip_main">
                                                     <label>Warden Name:</label>
                                                     <input type="text" name="hostelwardenname" placeholder="Enter warden name" oninput="this.value = this.value.replace(/[^A-Z. ]/g, '').toUpperCase()">
                                                   </div>
                                              </div>
                                              <div class="col-md-4" id="guardianAddressSection" style="display: none;">
                                                  <div class="ip_main">
                                                      <label>Local Guardian Address:</label>
                                                      <input type="text" name="hostelguardianaddress" placeholder="Enter local guardian address"></textarea>
                                                   </div>
                                                </div>
                                               <div class="col-md-4" id="guardianPhoneSection" style="display: none;">
                                                    <div class="ip_main">
                                                       <label>Guardian Phone Number:</label>
                                                       <input type="text" name="hostelguardianphoneno" placeholder="Enter guardian phone number" pattern="[0-9]{10}" maxlength="10"oninput="this.value = this.value.replace(/[^0-9]/g, '')" style=""> 
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
                                                               <option value="TamilNadu">TamilNadu</option>
                                                               <option value="OtherPlace">Other Place</option>
                                                          </select>
                                                      </div>
                                                      <div id="otherPlaceInput" style="display: none; flex-grow: 1;">
                                                          <input type="text" name="otherplace" class="form-control" placeholder="Enter the Place">
                                                      </div>
                                                      <script>
                                                          function togglePlaceInput() {
                                                            const dropdown = document.getElementById('belongstoTNornot');
                                                            const inputField = document.getElementById('otherPlaceInput');
                                                              if (dropdown.value === 'OtherPlace') {
                                                                  inputField.style.display = 'block';
                                                                  placeField.style.display = true;
                                                              } else {
                                                                inputField.style.display = 'none';
                                                               
                                                               }
                                                            }
                                                     </script>
                                                  </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Identification Mark:</label>
                                                      <input type="text" name="identificationmark" placeholder="identificationmark" style="" >
                                                   </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Mother Tongue:</label>
                                                      <input type="text" name="mothertongue" placeholder="Enter your Mother Tongue" style="" >
                                                   </div>
                                             </div>  
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Nationality:</label>
                                                      <input type="text" name="nationality" placeholder="Nationality" style="" >
                                                   </div>
                                             </div> 
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Medium:</label>
                                                      <select name="medium" id="medium">
                                                          <option value="Tamil">Tamil</option>
                                                          <option value="English">English</option>
                                                        </select>  
                                                 </div> 
                                             </div>   
                                             <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Do you have any physical disabilities?</label>
                                                      <select name="physicaldisabilities" id="physicaldisabilities">
                                                          <option value="YES">YES</option>
                                                          <option value="NO">NO</option>
                                                        </select>  
                                                 </div> 
                                             </div>
                                           

                                                    

                                             <div class="col-md-4">
                                                <div class="ip_main" style="position: relative;">
                                                    <label>Password:</label>
                                                    <input type="text" id="passwordInput" name="password" placeholder="Enter the Password" style="width: 100%; padding-right: 60px;">
                                                    
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
                                                      <textarea name="address" placeholder="Address"id=""></textarea>
                                                  </div>
                                             </div>
                                        <div class="col-md-12">

                                            <h1 style="color: var(--secondary_hex);font-size: 24px;padding: 15px 0;font-weight: 600;">PERSONAL DETAILS:</h1>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Father Name:</label>
                                                <input type="text" name="fathername" placeholder="Father name"  oninput="this.value = this.value.replace(/[^A-Z. ]/g, '').toUpperCase()" style="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Father's Occupation:</label>
                                                <input type="text" name="fathersoccupation" placeholder="Father occupation" style="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Father's Income:</label>
                                                <input type="text" name="fatherincome" placeholder="FatherIncome" style="" >
                                                <label for="ip_fatherincome" name="fatherincomedocument" style="cursor: pointer; display: flex; align-items: center;">
                                                         <!-- SVG Icon -->
                                                          <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                           Upload File
                                                           
                                                          <input type="file" id="ip_fatherincome" name="ip_fatherincome" style="height:0; width:0; padding:0;">
                                                     </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Father's Number:</label>
                                                <input type="text" name="fathersnumber" placeholder="Father's Number" pattern="[0-9]{10}" maxlength="10"oninput="this.value = this.value.replace(/[^0-9]/g, '')" style=""> 
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Mother's Name:</label>
                                                <input type="text" name="mothername" placeholder="Mother name"  oninput="this.value = this.value.replace(/[^A-Z. ]/g, '').toUpperCase()" style="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Mother's Occupation:</label>
                                                <input type="text" name="motheroccupation" placeholder="Mother occupation" style="" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Mother's Income:</label>
                                                <input type="text" name="motherincome" placeholder="Mother's Income" style="" >
                                                <label for="ip_motherincome" name="motherincomedocument"style="cursor: pointer; display: flex; align-items: center;">
                                                   <!-- SVG Icon -->
                                                   <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                   Upload File
                                                    <input type="file" id="ip_motherincome" name="ip_motherincome" style="height:0; width:0; padding:0;">
                                             </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Mother's Number:</label>
                                                <input type="text" name="mothernumber" placeholder="Mother's Number" pattern="[0-9]{10}" maxlength="10"oninput="this.value = this.value.replace(/[^0-9]/g, '')" style=""> 
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="">
                                              <label for="">Is there is a Guardian?:</label>
                                              <ul class="list-inline mt-2"> <!-- YES Radio Button -->
                                                  <li class="list-inline-item">
                                                      <input type="radio" name="guardian" value="YES" onclick="toggleGuardianFields(true)">
                                                 </li>
                                                 <li class="list-inline-item">
                                                     <label for="yes">YES</label>
                                                  </li><!-- NO Radio Button -->
                                                  <li class="list-inline-item">
                                                     <input type="radio" name="guardian" value="NO" onclick="toggleGuardianFields(false)">
                                                 </li>
                                                 <li class="list-inline-item">
                                                     <label for="no">NO</label>
                                                 </li>
                                             </ul>
                                         </div>
                                     </div> <!-- Guardian Details Section -->
                                     <div class="col-md-4" id="guardian_name" style="display: none;">
                                            <div class="ip_main">
                                                <label>Guardian Name:</label>
                                                <input type="text" name="guardianname" placeholder="Guardian Name"  oninput="this.value = this.value.replace(/[^A-Z. ]/g, '').toUpperCase()" style="" class="form-control">
                                          </div>
                                     </div>
                                      <div class="col-md-4" id="guardian_contact" style="display: none;">
                                            <div class="ip_main">
                                                <label>Guardian Contact No:</label>
                                                <input type="text" name="guardiancontactno" placeholder="Guardian contact no" pattern="[0-9]{10}" maxlength="10"oninput="this.value = this.value.replace(/[^0-9]/g, '')" style="" class="form-control">
                                         </div>
                                      </div>
                                      <div class="col-md-4" id="relation_field" style="display: none;">
                                            <div class="ip_main">
                                                <label>Relation:</label>
                                                <input type="text" name="relation" placeholder="Relation" style="" class="form-control">
                                          </div>
                                      </div>
                                       <div class="col-md-12" id="guardian_address" style="display: none;">
                                           <div class="ip_main">
                                               <label>Guardian Address:</label>
                                                <textarea name="guardianaddress" placeholder="Guardian Address" style="" class="form-control"></textarea>
                                          </div>
                                     </div>
                                      
                                     <script>
                                            function toggleGuardianFields(show) {
                                              
                                              const guardianName = document.getElementById('guardian_name');
                                              const guardianContact = document.getElementById('guardian_contact');
                                              const relationField = document.getElementById('relation_field');
                                              const guardianAddress = document.getElementById('guardian_address');
                                              
                                              if (show) {
                                                  guardianName.style.display = 'block';     // Show Guardian Name field
                                                  guardianContact.style.display = 'block';  // Show Guardian Contact No field
                                                  relationField.style.display = 'block';    // Show Relation field
                                                  guardianAddress.style.display = 'block';  // Show Guardian Address field
                                            
                                             } else {
                                                  guardianName.style.display = 'none';      // Hide Guardian Name field
                                                  guardianContact.style.display = 'none';   // Hide Guardian Contact No field
                                                  relationField.style.display = 'none';     // Hide Relation field
                                                  guardianAddress.style.display = 'none';   // Hide Guardian Address field
                                                }
                                            }// Automatically hide/show guardian fields on page load based on the initial selection
                                             window.onload = function() {
                                                 const selectedRadio = document.querySelector('input[name="guardian"]:checked');
                                                  toggleGuardianFields(selectedRadio.value === 'YES');
                                           };
                                     </script>

                                            
                                     
                                     

                                       
                                       
                                       
                                        <div class="col-md-12">

                                            <h1 style="color: var(--secondary_hex);font-size: 24px;padding: 15px 0;font-weight: 600;">BANK DETAILS:</h1>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Bank Name:</label>
                                                <input type="text" name="bankname" placeholder="Bank name"  oninput="this.value = this.value.replace(/[^A-Z. ]/g, '').toUpperCase()" style="" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label> Bank Branch Name :</label>
                                                <input type="text" name="bankbranchname" placeholder="Bank Branch Name " style="" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label> Account Holder Name:</label>
                                                <input type="text" name="accountholdername" placeholder="Account Holder Name" style="" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Account Number & Passbook Document:</label>
                                                <input type="text" name="accountnumber" placeholder="Account Number" style="" >
                                                <label for="ip_acc_passbook" name="accountnumberdocument" style="cursor: pointer; display: flex; align-items: center;">
                                                   <!-- SVG Icon -->
                                                   <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                   Upload File
                                                    <input type="file" id="ip_acc_passbook" name="ip_acc_passbook" style="height:0; width:0; padding:0;">
                                             </label>
                                             </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Account Type:</label>
                                                <input type="text" name="accounttype" placeholder="Account Type" style="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label> IFSC Code:</label>
                                                <input type="text" name="ifsccode" placeholder="IFSC code" style="" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label> MICR Code:</label>
                                                <input type="text" name="micrcode" placeholder="MICR code" style="" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Branch Address:</label>
                                                <input type="text" name="bankaddress" placeholder="Bank address" style="" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Aadhar No:</label>
                                                <input type="text" name="aadharno" placeholder="Aadhar no"  pattern="[0-9]{4} [0-9]{4} [0-9]{4}" maxlength="14" oninput="this.value = this.value.replace(/[^0-9 ]/g, '').replace(/(\d{4})(\d{4})(\d{4})/, '$1 $2 $3').trim()" style="" >
                                                <label for="ip_aadhar" name="aadhardocument" style="cursor: pointer; display: flex; align-items: center;">
                                                   <!-- SVG Icon -->
                                                   <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                   Upload File
                                                    <input type="file" id="ip_aadhar" name="ip_aadhar" style="height:0; width:0; padding:0;">
                                             </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>PAN Card No:</label>
                                                <input type="text" name="pancardno" placeholder="PAN Card No"   pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" maxlength="10" inputmode="uppercase" style="text-transform: uppercase" >
                                                <label for="ip_pan" name="pancarddocument" style="cursor: pointer; display: flex; align-items: center;">
                                                   <!-- SVG Icon -->
                                                   <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                   Upload File
                                                    <input type="file" id="ip_pan" name="ip_pan" style="height:0; width:0; padding:0;">
                                             </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                                 <div class="ip_main">
                                                      <label>Scholarship Type:</label>
                                                      <select name="scholarshiptype" id="scholarshiptype">
                                                          <option value="BC/MBC Scholarship">BC/MBC Scholarship</option>
                                                          <option value="SC/ST Scholarship">SC/ST Scholarship</option>
                                                          <option value="PMSS Scholarship">PMSS Scholarship</option>
                                                          <option value="None">None</option>
                                                     </select>
                                                  </div>
                                             </div>

                                        <div class="col-md-12">

                                            <h1 style="color: var(--secondary_hex);font-size: 24px;padding: 15px 0;font-weight: 600;">EDUCATIONAL BACKGROUND DETAILS:</h1>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>EMIS Number:</label>
                                                <input type="text" name="emisumber" placeholder="EMIS Number" style="" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>UMIS Number:</label>
                                                <input type="text" name="umisnumber" placeholder="UMIS Number" style="" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>ABC Credit Number/APAAR ID:</label>
                                                <input type="text" name="abccreditnumber" placeholder="ABC Credit Number" style="" >
                                                <label for="ip_abc" name="abcdocument" style="cursor: pointer; display: flex; align-items: center;">
                                                   <!-- SVG Icon -->
                                                   <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                   Upload File
                                                    <input type="file" id="ip_abc" name="ip_abc" style="height:0; width:0; padding:0;">
                                             </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label> 10th Mark & Certificate:</label>
                                                <input type="text" name="tenthmark" placeholder="10th Mark" style="" >
                                                <label for="ip_ten" name="tenthdocument" style="cursor: pointer; display: flex; align-items: center;">
                                                   <!-- SVG Icon -->
                                                   <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                   Upload File
                                                    <input type="file" id="ip_ten" name="ip_ten" style="height:0; width:0; padding:0;">
                                             </label>
                                            </div>
                                        </div>
                                       
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>12th Mark & Certificate:</label>
                                                <input type="text" name="twelvethmark" placeholder="12th Mark" style="" >
                                                <label for="ip_twelveth" name="twelvethdocument" style="cursor: pointer; display: flex; align-items: center;">
                                                   <!-- SVG Icon -->
                                                   <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                   Upload File
                                                    <input type="file" id="ip_twelveth" name="ip_twelveth" style="height:0; width:0; padding:0;">
                                             </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="">
                                              <label for="">Are you a Diploma Student?:</label>
                                              <ul class="list-inline mt-2"> <!-- YES Radio Button -->
                                                  <li class="list-inline-item">
                                                      <input type="radio" name="diploma" value="YES" onclick="toggleDiplomaFields(true)">
                                                 </li>
                                                 <li class="list-inline-item">
                                                     <label for="yes">YES</label>
                                                  </li><!-- NO Radio Button -->
                                                  <li class="list-inline-item">
                                                     <input type="radio" name="diploma" value="NO" onclick="toggleDiplomaFields(false)">
                                                 </li>
                                                 <li class="list-inline-item">
                                                     <label for="no">NO</label>
                                                 </li>
                                             </ul>
                                         </div>
                                     </div> <!-- Guardian Details Section -->
                                       <div class="col-md-12" id="diploma_college" style="display: none;">
                                              <div class="ip_main">
                                                  <label>Where did you studied diploma college?:</label>
                                                  <input type="text" name="diplomacollege" placeholder="Enter the College Name" style="" class="form-control">

                                             </div>
                                          </div>
                                          <div class="col-md-4"  id="diploma_course" style="display: none;">
                                              <div class="ip_main">
                                                   <label>Diploma Course:</label>
                                                    <input type="text" name="diplomacourse" placeholder="Diploma Course" style="" class="form-control">
                                             </div>
                                         </div>
                                     
                                           <div class="col-md-4"  id="diploma_percentage" style="display: none;">
                                              <div class="ip_main">
                                                   <label>Diploma Percentage:</label>
                                                    <input type="text" name="diplomapercentage" placeholder="Diploma Percetage" style="" class="form-control">
                                             </div>
                                         </div>
                                      
                                      
                                           <div class="col-md-4" id="diploma_marksheets" style="display: none;">
                                              <div class="ip_main">
                                                  <label> Upload the Diploma Marksheets:</label>
                                                  <label for="ip_diplomamarksheets" name="diplomamarksheetsdocument" style="cursor: pointer; display: flex; align-items: center;">
                                                   <!-- SVG Icon -->
                                                   <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                   Upload File
                                                    <input type="file" id="ip_diplomamarksheets" name="ip_diplomamarksheets" style="height:0; width:0; padding:0;">
                                             </label>
                                              </div>
                                         </div>
                                      
                                      
                                          <div class="col-md-4" id="diploma_degree_certificate" style="display: none;" >
                                              <div class="ip_main">
                                                  <label>Diploma Degree Certificate:</label>
                                                 <label for="ip_diplomadegreecertificate" name="diplomadegreecertificatedocument" style="cursor: pointer; display: flex; align-items: center;">
                                                   <!-- SVG Icon -->
                                                   <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                   Upload File
                                                    <input type="file" id="ip_diplomadegreecertificate" name="ip_diplomadegreecertificate" style="height:0; width:0; padding:0;">
                                             </label>
                                             </div>
                                          </div>

                                                                             
                                     <script>
                                           function toggleDiplomaFields(show) {
                                            
                                               const DiplomaCollege = document.getElementById('diploma_college');
                                               const DiplomaCourse = document.getElementById('diploma_course');
                                               const DiplomaPercentage = document.getElementById('diploma_percentage');
                                               const DiplomaMarksheets = document.getElementById('diploma_marksheets');
                                               const DiplomaDegreeCertificate = document.getElementById('diploma_degree_certificate');
                                              
                                               
                                               if (show) {
                                                  DiplomaCollege.style.display = 'block';     // Show Guardian Name field
                                                  DiplomaCourse.style.display = 'block';
                                                  DiplomaPercentage.style.display = 'block';  // Show Guardian Contact No field
                                                  DiplomaMarksheets.style.display = 'block';    // Show Relation field
                                                  DiplomaDegreeCertificate.style.display = 'block';  // Show Guardian Address field
                                                 
                                              } else {
                                                  DiplomaCollege.style.display = 'none';      // Hide Guardian Name field
                                                  DiplomaCourse.style.display = 'none';
                                                  DiplomaPercentage.style.display = 'none';   // Hide Guardian Contact No field
                                                  DiplomaMarksheets.style.display = 'none';     // Hide Relation field
                                                  DiplomaDegreeCertificate.style.display = 'none';   // Hide Guardian Address field
                                               }
                                            }// Automatically hide/show guardian fields on page load based on the initial selection
                                              window.onload = function() {
                                                  const selectedRadio = document.querySelector('input[name="diploma"]:checked');
                                                  toggleDiplomaFields(selectedRadio.value === 'YES');
                                            };
                                     </script>

                                       <div class="col-md-4">
                                            <div class="">
                                              <label for="">Are you completed UG(Under Graduation)?:</label>
                                              <ul class="list-inline mt-2"> <!-- YES Radio Button -->
                                                  <li class="list-inline-item">
                                                      <input type="radio" name="ug" value="YES" onclick="toggleUgFields(true)">
                                                 </li>
                                                 <li class="list-inline-item">
                                                     <label for="yes">YES</label>
                                                  </li><!-- NO Radio Button -->
                                                  <li class="list-inline-item">
                                                     <input type="radio" name="ug" value="NO" onclick="toggleUgFields(false)">
                                                 </li>
                                                 <li class="list-inline-item">
                                                     <label for="no">NO</label>
                                                 </li>
                                             </ul>
                                         </div>
                                     </div> <!-- Guardian Details Section -->
                                       <div class="col-md-12" id="ug_college" style="display: none;">
                                            <div class="ip_main">
                                              <label>Where did you studied (college name)?:</label>
                                              <input type="text" name="ugcollegename" placeholder="Enter the College Name" style="" class="form-control">
                                          </div>
                                       </div>
                                       <div class="col-md-4" id="ug_degree"  style="display: none;">
                                            <div class="ip_main">
                                                <label>UG Degree:</label>
                                                <select name="ugdegree" id="ug_degree" style="" class="form-control">
                                                    <option value="B.E">B.E</option>
                                                    <option value="B.TECH">B.TECH</option>
                                                    <option value="B.ARCH">B.ARCH</option>
                                                    <option value="B.A">B.A</option>
                                                    <option value="B.B.A">B.B.A</option>
                                                    <option value="B.SC">B.SC</option>
                                                    <option value="B.COM">B.COM</option>
                                               </select>
                                           </div>
                                      </div>
                                     <div class="col-md-4"  id="ug_course" style="display: none;">
                                          <div class="ip_main">
                                                <label>UG Course Name:</label>
                                                <input type="text" name="ugcourse" placeholder="UG Course" style="" class="form-control">
                                           </div>
                                      </div>
                                      <div class="col-md-4"  id="ug_percentage" style="display: none;">
                                            <div class="ip_main">
                                                <label>UG Percentage:</label>
                                                <input type="text" name="ugpercentage" placeholder="UG Percetage" style="" class="form-control">
                                          </div>
                                      </div>
                                      
                                      
                                           <div class="col-md-4" id="ug_marksheets" style="display: none;">
                                              <div class="ip_main">
                                                  <label> Upload the UG Marksheets:</label>
                                                  <label for="ip_ugmarksheets" name="ugmarksheetsdocument" style="cursor: pointer; display: flex; align-items: center;">
                                                   <!-- SVG Icon -->
                                                   <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                   Upload File
                                                    <input type="file" id="ip_ugmarksheets" name="ip_ugmarksheets" style="height:0; width:0; padding:0;">
                                             </label>
                                              </div>
                                         </div>
                                      
                                      
                                          <div class="col-md-4" id="ug_degree_certificate" style="display: none;" >
                                              <div class="ip_main">
                                                  <label>UG Degree Certificate:</label>
                                                 <label for="ip_ugdegreecertificate" name="ugdegreecertificatedocument" style="cursor: pointer; display: flex; align-items: center;">
                                                   <!-- SVG Icon -->
                                                   <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                   Upload File
                                                    <input type="file" id="ip_ugdegreecertificate" name="ip_ugdegreecertificate" style="height:0; width:0; padding:0;">
                                             </label>
                                             </div>
                                          </div>

                                                                             
                                     <script>
                                           function toggleUgFields(show) {
                                            
                                               const ugCollege = document.getElementById('ug_college');
                                               const ugDegree = document.getElementById('ug_degree');
                                               const ugCourse = document.getElementById('ug_course');
                                               const ugPercentage = document.getElementById('ug_percentage');
                                               const ugMarksheets = document.getElementById('ug_marksheets');
                                               const ugDegreeCertificate = document.getElementById('ug_degree_certificate');
                                               ug_degree
                                               
                                               if (show) {
                                                  ugCollege.style.display = 'block';
                                                  ugDegree.style.display = 'block';     // Show Guardian Name field
                                                  ugCourse.style.display = 'block';
                                                  ugPercentage.style.display = 'block';  // Show Guardian Contact No field
                                                  ugMarksheets.style.display = 'block';    // Show Relation field
                                                  ugDegreeCertificate.style.display = 'block';  // Show Guardian Address field
                                                 
                                              } else {
                                                  ugCollege.style.display = 'none'; 
                                                  ugDegree.style.display = 'none';     // Hide Guardian Name field
                                                  ugCourse.style.display = 'none';
                                                  ugPercentage.style.display = 'none';   // Hide Guardian Contact No field
                                                  ugMarksheets.style.display = 'none';     // Hide Relation field
                                                  ugDegreeCertificate.style.display = 'none';   // Hide Guardian Address field
                                               }
                                            }// Automatically hide/show guardian fields on page load based on the initial selection
                                              window.onload = function() {
                                                  const selectedRadio = document.querySelector('input[name="ug"]:checked');
                                                  toggleUgFields(selectedRadio.value === 'YES');
                                            };
                                     </script>

                                       
                                       
                                       
                                        
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>TC No & Certificate:</label>
                                                <input type="text" name="tcno" placeholder="TC No" style="">
                                                <label for="ip_tc" name="tcnodocument" style="cursor: pointer; display: flex; align-items: center;">
                                                   <!-- SVG Icon -->
                                                   <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                   Upload File
                                                    <input type="file" id="ip_tc" name="ip_tc" style="height:0; width:0; padding:0;">
                                             </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label> 10th Percentage:</label>
                                                <input type="text" name="tenthpercentage" placeholder="10th Percentage" style="" >
                                                
                                            </div>
                                        </div>
                                       
                                        
                                        <div class="col-md-4">
                                           <div class="ip_main">
                                                <label>12th Percentage:</label>
                                                <input type="text" name="twelvethpercentage" placeholder="12th Percentage" style="" >
                                            </div>
                                      </div>
                                      <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>DOTE/MANAGEMENT:</label>
                                                <select name="dotemanagement" id="dotemanagement" onchange="toggleDoteManagement()">
                                                    <option value="">-- Select Type --</option>
                                                    <option value="DOTE">DOTE</option>
                                                    <option value="MANAGEMENT">MANAGEMENT</option>
                                                </select>  
                                            </div> 
                                        </div>

                                        <!-- Quota selection (hidden by default) -->
                                        <div class="col-md-4" id="quotaSelection" style="display:none;">
                                            <div class="ip_main">
                                                <label>Select the Quota:</label>
                                                <select name="quota" id="quota" onchange="toggleQuotaFields()">
                                                    <option value="">-- Select Quota --</option>
                                                    <option value="7.5 quota">7.5 quota</option>
                                                    <option value="Sport quota">Sport quota</option>
                                                    <option value="Ex-Service Man quota">Ex-Service Man quota</option>
                                                    <option value="General quota">General quota</option>
                                                </select>  
                                            </div> 
                                        </div>

                                        <!-- TNEARankingNumber (hidden by default) -->
                                        <div class="col-md-4" id="additionalFields" style="display:none;">
                                            <div class="ip_main">
                                                <label>TNEARankingNumber:</label>
                                                <input type="text" name="tnearankingnumber" id="tnearankingnumber" placeholder="Enter the TNEARankingNumber">
                                            </div>
                                        </div>

                                        <!-- CommunityRankingNumber (hidden by default) -->
                                        <div class="col-md-4" id="communityRankingField" style="display:none;">
                                            <div class="ip_main">
                                                <label>CommunityRankingNumber:</label>
                                                <input type="text" name="communityrankingnumber" id="communityrankingnumber" placeholder="Enter the CommunityRankingNumber">
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
                                                <input type="text" name="cutoff" placeholder="cutoff" style="" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>10th School Name:</label>
                                                <input type="text" name="tenthschoolname" placeholder="Enter the School Name" style="" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>12th School Name:</label>
                                                <input type="text" name="twelvethschoolname" placeholder="Enter the School Name" style="" >
                                            </div>
                                        </div>

                                        <div class="col-md-12">

                                            <h1 style="color: var(--secondary_hex);font-size: 24px;padding: 15px 0;font-weight: 600;">EXTRA CURRICULAR DETAILS:</h1>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Name of the Sport:</label>
                                                <input type="text" name="nameofthesport" placeholder="Name of the Sport" style="" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Sports Level:</label>
                                                <select name="sportslevel" id="Sports Level">
                                                  <option value="Beginner">Beginner</option>
                                                  <option value="Intermediate">Intermediate</option>
                                                  <option value="Advance">Advance</option>
                                                  <option value="None">None</option>
                                              </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="ip_main">
                                              <label>Achievements:</label>
                                              <select name="achievements" id="Achievements">
                                                  <option value="Winner">Winner</option>
                                                  <option value="Runner-up">Runner-up</option>
                                                  <option value="None">None</option>
                                              </select>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="ip_main">
                                              <label>Is there a Sport Certificate? Fill & Upload:</label>
                                              <select name="certifications" id="Certifications">
                                                  <option value="Yes">Yes</option>
                                                  <option value="No">No</option>
                                              </select>
                                              <!-- Upload Section with Icon -->
                                              
                                              <label for="ip_sport_c" name="certificationdocument" style="cursor: pointer; display: flex; align-items: center;">
                                                   <!-- SVG Icon -->
                                                   <img src="assets\image\file-files-and-folders-svgrepo-com.svg" alt="Upload Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                                   Upload File
                                                    <input type="file" id="ip_sport_c" name="ip_sport_c" style="height:0; width:0; padding:0;">
                                             </label>
                                          </div>
                                      </div>
                                      <div class="col-md-4">
                                            <div class="ip_main">
                                                <label>Sports Quota Percentage:</label>
                                                <input type="text" name="sportsquotapercentage" placeholder="Sports Quota Percentage" style="" >
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
                                                   <option value="2 WHEELER">2 WHEELER</option>
                                                   <option value="4 WHEELER">4 WHEELER</option>
                                                   <option value="NONE">NONE</option>
                                             </select>
                                          </div>
                                      </div>
                                      <div class="col-md-4" id="licenseFields" style="display: none;">
                                           <div class="ip_main">
                                              <label>Driving License Number:</label>
                                              <input type="text" name="licensenumber" placeholder="Enter the License Number">
                                          </div>
                                     </div>
                                     <div class="col-md-4" id="isuseOffice" style="display: none;">
                                         <div class="ip_main">
                                             <label>Office of Issue:</label>
                                              <input type="text" name="issueoffice"  placeholder="Enter the Office Issue">
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
                                              <input type="text" name="languageknown" placeholder="Bank Branch Name " style="" >
                                         </div>
                                      </div>
                                     <div class="col-md-4">
                                         <div class="ip_main">
                                              <label> Any relatives are studing here ? </label>
                                              <select name="relativesstuding" id="relativesstuding" onchange="toggleRelativesStudingFields()">
                                                   <option value="">-- Select --</option>
                                                   <option value="YES">YES</option>
                                                   <option value="NO">NO</option>
                                             </select>
                                          </div>
                                      </div>
                                      <div class="col-md-4" id="StdName" style="display: none;">
                                           <div class="ip_main">
                                              <label>Student Name:</label>
                                              <input type="text" name="stdname" placeholder="Enter the Student Name"  oninput="this.value = this.value.replace(/[^A-Z. ]/g, '').toUpperCase()" style="">
                                          </div>
                                     </div>
                                     <div class="col-md-4" id="StdDegree" style="display: none;">
                                         <div class="ip_main">
                                             <label>Student Degree:</label>
                                              <select name="stddegree" id="stddegree">
                                                 <option value="">-- Select Degree --</option>
                                                 <option value="B.E">B.E</option>
                                                 <option value="B.TECH">B.TECH</option>
                                                 <option value="B.ARCH">B.ARCH</option>
                                                 <option value="M.E">M.E</option>
                                                 <option value="M.TECH">M.TECH</option>
                                                  <option value="MBA">MBA</option>
                                             </select>
                                          </div>
                                      </div>
                                      <div class="col-md-4" id="StdDepartment" style="display: none;">
                                          <div class="ip_main">
                                             <label>Department:</label>
                                             <select name="stddepartment" id="stddepartment">
                                                 <option value="">-- Select Department --</option>
                                                  <option value="CSE">CSE</option>
                                                  <option value="IT">IT</option>
                                                  <option value="ECE">ECE</option>
                                                  <option value="EEE">EEE</option>
                                                  <option value="MECH">MECH</option>
                                                  <option value="AERO">AERO</option>
                                                  <option value="AIDS">AIDS</option>
                                                  <option value="BIOTECH">BIOTECH</option>
                                                  <option value="CIVIL">CIVIL</option>
                                             </select>
                                          </div>
                                     </div>
                                     <div class="col-md-4" id="StdYear" style="display: none;">
                                          <div class="ip_main">
                                              <label>Year:</label>
                                              <select name="stdyear" id="stdyear">
                                                  <option value="">-- Select Year--</option>
                                                    <option value="I">I</option>
                                                    <option value="II">II</option>
                                                    <option value="III">III</option>
                                                    <option value="IV">IV</option>
                                                    <option value="V">V</option>
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
                                              <select name="relativestaffworking" id="relativestaffworking" onchange="toggleRelativeStaffWorkingFields()">
                                                   <option value="">-- Select --</option>
                                                   <option value="YES">YES</option>
                                                   <option value="NO">NO</option>
                                             </select>
                                          </div>
                                      </div>
                                      <div class="col-md-4" id="StaffName" style="display: none;">
                                           <div class="ip_main">
                                              <label>Staff Name:</label>
                                              <input type="text" name="staffname" placeholder="Enter the Staff Name"  oninput="this.value = this.value.replace(/[^A-Z. ]/g, '').toUpperCase()"  style="">
                                          </div>
                                     </div>
                                     <div class="col-md-4" id="StaffWorking" style="display: none;">
                                         <div class="ip_main">
                                             <label>Staff Working has? :</label>
                                              <select name="staffworkinghas" >
                                                 <option value="">-- Select  --</option>
                                                 <option value="Professor">Professor</option>
                                                 <option value="Assistance-Professor">Assistance-Professor</option>
                                                 <option value="Non-Teching Staff">Non-Teching Staff</option>

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
                                                <button type="submit" class="btn btn-success btn-lg"> SUBMIT </button>
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
             </div>+
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