<?php
include("con.php");

$enrollmentnumber=$_GET["enrollmentnumber"];
//echo $name;
$sql="SELECT * FROM students WHERE enrollmentnumber ='$enrollmentnumber'";

$sql = "SELECT s.*, d.branch AS branch_name, y.name AS year_name 
        FROM students s
        LEFT JOIN dept d ON s.branch = d.dept_id
        LEFT JOIN year y ON s.year = y.id
        WHERE s.enrollmentnumber = '$enrollmentnumber'";


$result=$conn->query($sql);
$row=$result->fetch_assoc();


?>

<!DOCTYPE html>
<html lang="en">
    <?php include("head.php")?>
    <body>
        <?php include("nav.php")?>
        <style>
            
        </style>
        <div class="frame_body">
            <?php include("sidenav.php"); ?>
            <div class="cnt_frame_main">
                <div class="cnt_frame_inner">
                    <div class="breadcrumb_main text-right">
                        <a href="" class="hpc_low">Home / </a>
                        <span> Student Profile page</span>
                    </div>
                    <div class="cnt_sec">
                        <!-- white card section -->
                        <div class="card_wht">
                            <div class="head_main">
                                <h4 class="heading">
                                    PROFILE DASHBOARD
                                </h4>
                            </div>
                            <div class="card_cnt">
                            <nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Profile</button>
    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Academic Performance</button>
    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Certifications</button>
    <button class="nav-link" id="nav-attendance-tab" data-bs-toggle="tab" data-bs-target="#nav-attendance" type="button" role="tab" aria-controls="nav-attendance" aria-selected="false">Attendance</button>
    <button class="nav-link" id="nav-leave-tab" data-bs-toggle="tab" data-bs-target="#nav-leave" type="button" role="tab" aria-controls="nav-leave" aria-selected="false">Details of Leave Record</button>
    <button class="nav-link" id="nav-parentmeet-tab" data-bs-toggle="tab" data-bs-target="#nav-parentmeet" type="button" role="tab" aria-controls="nav-parentmeet" aria-selected="false">Parents Meet Record</button>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
       <div class="row mt-5">
            <div class="col lg-4">
                 <div class="cnt_sec">
                    <!-- white card section -->
                    <div class="card_wht">
                        <div class="Profile" style="display: flex; justify-content: center; align-items: center; height: 80px;">
                            <img src="assets/image/erp_profile.png">
                        </div>
                        <div class="head_main">
                                <h4><?php echo $row['name']; ?></h4>
                        </div>      
                        <div class="card_cnt">
                                <h3>Degree: <?php echo $row['degree']; ?></h3>
                                <h3>Department: <?php echo $row['branch_name']; ?></h3>  
                                <h3>Year: <?php echo $row['year_name']; ?></h3>
                                <h3>Register No: <?php echo $row['reg_no']; ?></h3>
                                <h3>Batch: <?php echo $row['batch']; ?></h3>
                        </div>
                    </div> <!-- white card section end -->
                    <!-- white card section end -->
                 </div> <!-- cnt_sec end -->
            </div> <!-- col lg-4 end -->
            <div class="col-lg-4 row" style=" width: 685px; gap: 15px;">
                <div class="cnt_sec">
                    <!-- white card section -->
                     <div class="card_wht">
                            <div class="head_main"><h4>General Details</h4></div>
                            <div class="card_cnt">
                                <h3>Enrollment No: <?php echo $row['enrollmentnumber']; ?></h3>
                                <h3>Date of Joining: <?php echo $row['dateofjoining']; ?></h3>
                                <h3>Type of Entry: <?php echo $row['typeofentry']; ?></h3>
                                <h3>Day Scholar / Hosteller: <?php echo $row['dayscholarorhostel']; ?></h3>
                                <h3>Email ID: <?php echo $row['emailid']; ?></h3>
                               <!-- <h3>Password: <!?php echo base64_decode($pw_ec) ?><img onclick="view()" src="assets/icons/view_ic.png"> </h3> -->
                                <h3>Password: <!?php echo base64_decode($row['password'])?><img onclick="view()" src="assets/icons/view_ic.png"> </h3>
                               
                                <h3>Contact No: <?php echo $row['phoneno']; ?>
                                                <br> <br>
                                                <?php echo $row['alternateno']; ?></h3>
                                <h3>Address: <?php echo $row['address']; ?></h3>
                            </div> <!-- card_cnt end -->
                     </div> <!-- white card section end -->
                </div> <!-- cnt_sec end -->

                <br>

                <div class="card_wht"> <!-- white card section -->
                     <div class="accordion accordion-flush" id="accordionFlushExample"> <!-- accordion section -->
                     <div class="accordion-item">
                                   <h2 class="accordion-header" id="flush-headingFive">
                                         <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                                                 Personal Details
                                         </button>
                                   </h2>
                                             <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                                                  <div class="accordion-body">
                                                         <!-- white card section -->
                                                         <div class="card_wht">
                                                              <div class="head_main"><h4>Supplementry Details</h4></div>
                                                              <div class="card_cnt">
                                                                   <h3>Date of Birth: <?php echo $row['dateofbirth']; ?></h3>
                                                                   <h3>Gender: <?php echo $row['gender']; ?></h3>
                                                                   <h3>Blood Group: <?php echo $row['bloodgroup']; ?></h3>
                                                                   <br>
                                                                   <h3>Religion: <?php echo $row['religion']; ?></h3>
                                                                   <h3>Community: <?php echo $row['community']; ?></h3>
                                                                   <h3>Caste: <?php echo $row['caste']; ?></h3>
                                                                   <h3>Community Certificate:<a href="<?php echo $row_c['communitydocument']?>" target="_blank"> View </a>       </h3>
                                                              </div> <!-- card_cnt end -->
                                                         </div>
                                                         <!-- white card section end -->

                                                          <br>
                                                          <!-- white card section -->
                                                          <div class="card_wht">
                                                                <div class="head_main"><h4>Family Details</h4></div>
                                                                <div class="card_cnt">
                                                                     <h3>Father's Name: <?php echo $row['fathername']; ?></h3>
                                                                     <h3>Occupation: <?php echo $row['fatheroccupation']; ?></h3>
                                                                     <h3>Annual Income: <?php echo $row['fatherincome']; ?></h3>
                                                                     <h3>Father's Income Certificate:<a href="<?php echo $row_c['fatherincomedocument']?>" target="_blank"> View </a> 
                                                                     <h3>Contact No: <?php echo $row['fathernumber']; ?></h3>
                                                                     <div class="head_main"> <h4 class=""> </h4> </div>
                                                                     <br>
                                                                     <h3>Mother's Name: <?php echo $row['mothername']; ?></h3>
                                                                     <h3>Occupation: <?php echo $row['motheroccupation']; ?></h3>
                                                                     <h3>Annual Income: <?php echo $row['motherincome']; ?></h3>
                                                                     <h3>Mother's Income Certificate:<a href="<?php echo $row_c['motherincomedocument']?>" target="_blank"> View </a> 
                                                                     <h3>Contact No: <?php echo $row['mothernumber']; ?></h3>
                                                                     <h3><center>Guardian Details, if yes</center></h3>
                                                                     <h3>Guardian Name: <?php echo $row['guardianname']; ?></h3>
                                                                     <h3>Type of Relation: <?php echo $row['relation']; ?></h3>
                                                                     <h3>Contact No: <?php echo $row['guardiancontactno']; ?></h3>
                                                                </div><!-- card_cnt end -->
                                                          </div> <!--white card section end -->
                                                 </div> <!-- accordion-body end -->
                                             </div> <!-- accordion-collapse end -->
                                </div> <!-- accordion-item end -->

                                <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                Admission Details
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                    <!-- white card section -->
                                                    <div class="card_wht">
                                                        <div class="head_main"><h4>Joining Information</h4></div>
                                                        <div class="card_cnt">
                                                            <h3>DOTE / MANAGEMENT :  <?php echo $row['dotemanagement']; ?></h3>
                                                            <h3><center>if DOTE</center></h3>
                                                            <h3>TNEA Rank: <?php echo $row['tnearankingnumber']; ?></h3>
                                                            <h3>Community Rank: <?php echo $row['communityrankingnumber']; ?> </h3>
                                                            <h3>Quota: <?php echo $row['quota']; ?></h3>
                                                            <h3>Are you a First Graduate (FG) Student?: <?php echo $row['firstgraduate']; ?></h3>
                                                            <h3>FG Certificate:<a href="<?php echo $row_c['fgdocument']?>" target="_blank"> View </a> </h3>
                                                        </div><!-- card_cnt end -->
                                                    </div><!-- white card section end -->
                                            </div> <!-- accordion-body end -->
                                        </div> <!-- accordion-collapse end -->
                                </div>
                                 
                                     <div class="accordion-item">
                                             <h2 class="accordion-header" id="flush-headingTwo">
                                                 <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                                     Educational Background Details
                                                 </button>
                                             </h2>
                                         <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                             <div class="accordion-body">
                                                  <div class="card_wht"> <!-- white card section -->
                                                        <div class="head_main"> <h4> Academic History </h4> </div>
                                                         <div class="card_cnt">
                                                              <h3>EMIS No: <?php echo $row['emisnumber']; ?></h3>
                                                              <h3>UMIS No: <?php echo $row['umisnumber']; ?></h3>
                                                              <h3>ABC Credit No: <?php echo $row['abccreditnumber']; ?></h3>
                                                         </div>
                                                         <br>
                                                         <div class="head_main"> <h4></h4> </div>
                                                         <div class="card_cnt">
                                                                <h3>10th Mark: <?php echo $row['tenthmark']; ?></h3>
                                                                <h3>10th Percentage: <?php echo $row['tenthpercentage']; ?></h3>
                                                                <h3>10th Marksheet:<a href="<?php echo $row_c['tenthdocument']?>" target="_blank"> View </a>       </h3>
                                                         </div>
                                                         <div class="head_main">  <h4></h4> </div>             
                                                         <div class="card_cnt">
                                                              <h3>12th Mark: <?php echo $row['twelfthmark']; ?></h3>
                                                              <h3>12th Percentage: <?php echo $row['twelfthpercentage']; ?></h3>
                                                              <h3>12th Marksheet:<a href="<?php echo $row_c['twelvethdocument']?>" target="_blank"> View </a>       </h3>
                                                              <h3>Cut off: <?php echo $row['cutoff']; ?></h3>
                                                              <h3>TC no: <?php echo $row['tcno']?></h3>
                                                              <h3>TC document: <a href="<?php echo $row_c['tcnodocument']?>" target="_blank"> View </a></h3>
                                                         </div> <!-- card_cnt end -->
                                                 </div> <!--white card section end -->
                                                 <br>
                                                 <div class="card_wht"> <!-- white card section -->
                                                       <div class="head_main"> <h4> Diploma Details, if yes </h4> </div>
                                                       <div class="card_cnt">
                                                            <h3>Are you a Diploma Student: <?php echo $row['diploma']?></h3>
                                                            <h3>Course: <?php echo $row['diplomacourse']; ?></h3>
                                                            <h3>University / College: <?php echo $row['diplomacollege']; ?></h3>
                                                            <!--<h3>Mark: <?php echo $row['diplomamark']; ?></h3>-->
                                                            <h3>Percentage: <?php echo $row['diplomapercentage']; ?></h3>
                                                            <h3>Marksheet Document:<a href="<?php echo $row_c['diplomamarksheetsdocument']?>" target="_blank"> View </a> 
                                                            <h3>Certificate:<a href="<?php echo $row_c['diplomadegreecertificatedocument']?>" target="_blank"> View </a> 
                                                       </div>
                                                 </div> <!-- white card section end -->
                                                 <br>
                                                 <div class="card_wht"> <!-- white card section -->
                                                      <div class="head_main"><h4>UG Details, (for PG Student) if yes</h4></div>
                                                      <div class="card_cnt">
                                                           <h3>Are you a PG Student: <?php echo $row['ug']?></h3>
                                                           <h3>Course: <?php echo $row['ugcourse']?></h3>
                                                           <h3>University / College: <?php echo $row['ugcollegename']?></h3>
                                                           <h3>Percentage: <?php echo $row['ugpercentage']?></h3>
                                                           <h3>Marksheet Document:<a href="<?php echo $row_c['ugmarksheetsdocument']?>" target="_blank"> View </a> 
                                                           <h3>Certificate:<a href="<?php echo $row_c['ugdegreecertificatedocument']?>" target="_blank"> View </a> 
                                                      </div>
                                                 </div> <!-- white card section end -->
                                             </div> <!-- accordion-body end -->
                                         </div> <!-- accordion-collapse end -->
                                     </div>  <!-- accordion-item end -->
                                    
                                     <div class="accordion-item">
                                                         <h2 class="accordion-header" id="flush-headingThree">
                                                             <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                                                   Scholarship Details
                                                             </button>
                                                         </h2>
                                                     <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                                         <div class="accordion-body">
                                                              <div class="card_wht"> <!-- white card section -->
                                                                    <div class="head_main"> <h4> Details of Scholarship </h4> </div>
                                                                     <div class="card_cnt">
                                                                         <h3>Name of the Scholarship:       <?php echo $row['scholarshiptype']; ?></h3>
                                                                     </div>
                                                              </div> <!-- white card section end -->

                                                              <br>

                                                              <div class="card_wht"> <!--white card section -->
                                                                    <div class="head_main"> <h4> Bank Details </h4> </div>
                                                                     <div class="card_cnt">
                                                                            <h3>Bank Name: <?php echo $row['bankname']; ?></h3>
                                                                            <h3>Branch: <?php echo $row['bankbranchname']; ?></h3>
                                                                            <h3>Account Holder Name: <?php echo $row['accountholdername']; ?></h3>
                                                                            <h3>Account Type: <?php echo $row['accounttype']; ?></h3>
                                                                            <h3>Account No: <?php echo $row['accountnumber']; ?></h3>
                                                                            <h3>IFSC Code: <?php echo $row['ifsccode']; ?></h3>
                                                                            <h3>MICR Code: <?php echo $row['micrcode']; ?></h3>
                                                                            <h3>Aadhar No: <?php echo $row['aadharno']; ?></h3>
                                                                            <h3>Pan Card No: <?php echo $row['pancardno']; ?></h3>
                                                                     </div> <!-- card_cnt end -->
                                                              </div> <!-- white card section end -->
                                                         </div> <!-- accordion-body end -->
                                                     </div> <!-- accordion-collapse end -->
                                              </div> <!-- accordion-item end -->

                                              <div class="accordion-item">
                                                   <h2 class="accordion-header" id="flush-headingFour">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                                                Extra Curricular Details
                                                         </button>
                                                   </h2>
                                                   <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body">
                                                            <div class="card_wht">
                                                                <div class="head_main"><h4>Sports</h4></div>
                                                                <div class="card_cnt">
                                                                      <h3>Name of the Sport: <?php echo $row['sportname']; ?></h3>
                                                                      <h3>Sport Level: <?php echo $row['sportslevel']; ?></h3>
                                                                      <h3>Achievements: <?php echo $row['achievements']; ?></h3>
                                                                      <h3>Certifications: <?php echo $row['certifications']; ?> </h3>
                                                                      <h3>Sports Quota Percentage: <?php echo $row['sportsquotapercentage']; ?></h3>
                                                                </div> <!-- card_cnt end -->
                                                            </div> <!-- white card section end -->
                                                        </div> <!-- accordion-body end -->
                                                   </div> <!-- accordion collapse end -->
                                              </div> <!--accordion-item end -->

                                              <div class="accordion-item">
                                              <h2 class="accordion-header" id="flush-headingSix">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
                                                                    Other Details
                                                            </button>
                                                    </h2>
                                                    <div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample">
                                                          <div class="accordion-body">
                                                                <div class="card_wht">
                                                                 <div class="head_main"><h4>Details of Day Scholar / Hosteller</h4></div>
                                                                 <div class="card_cnt">
                                                                         <h3><center>(a) if Day Scholar, </center></h3>
                                                                         <h3>Mode of Transport: <?php echo $row['transportmode']; ?></h3>
                                                                         <br>
                                                                         <h3><center>(i) if by own vehicle, </center></h3>
                                                                         <h3>Name of the Vehicle: <?php echo $row['vehiclename']; ?></h3>
                                                                         <h3>Registration No: <?php echo $row['registrationnumber']; ?></h3>
                                                                         <br>
                                                                         <h3><center>(b) if Hosteller, </center></h3>
                                                                         <h3>Local Guardian Name: <?php echo $row['hostelwardenname']; ?> </h3>
                                                                         <h3>Address: <?php echo $row['hostelguardianaddress']; ?></h3>
                                                                         <h3>Phone no: <?php echo $row['hostelguardianphoneno']; ?></h3>
                                                                 </div> <!-- card_cnt end -->
                                                                </div> <!-- white card section end -->
                                                                <br>
                                                                <div class="card_wht"> <!-- white card section -->
                                                                     <div class="head_main"><h4>Details of Driving</h4></div>
                                                                     <div class="card_cnt"> <!-- card_cnt -->
                                                                           <h3>Driving known: <?php echo $row['drivingknown']?></h3>
                                                                           <h3><center>(a) Driving known, if yes</center></h3>
                                                                           <h3>Driving License No <?php echo $row['licensenumber']?>
                                                                               <br>and Office of issue: <?php echo $row['issueoffice']?>
                                                                           </h3>
                                                                     </div> <!-- card_cnt end -->
                                                                     <div class="head_main"><h4>Language Skills</h4></div>
                                                                     <div class="card_cnt"> <!-- card_cnt -->
                                                                          <h3>Languages known: <?php echo $row['languageknown']?></h3>
                                                                     </div> <!-- card_cnt end -->
                                                                     <div class="head_main"><h4>Details of Siblings / relatives</h4></div>
                                                                     <div class="card_cnt"> <!-- card_cnt -->
                                                                          <h3>1. Any relatives are studying here ?: <?php echo $row['relativesstuding']?></h3>
                                                                          <h3><center>(i) if yes,</center></h3>
                                                                          <h3>Name of the relative: <?php echo $row['stdname']?></h3>
                                                                          <h3>Degree & Department: <?php echo $row['stddegree']?>   <?php echo $row['stddepartment']?></h3>
                                                                          <h3>Year: <?php echo $row['stdyear']?></h3>
                                                                          <h3>2. Any Known/relative Staff or faculty are working here ?: <?php echo $row['relativestaffworking']?></h3>
                                                                          <h3><center>(i) if yes,</center></h3>
                                                                          <h3>Name of the person: <?php echo $row['staffname']?></h3>
                                                                          <h3>Designation: <?php echo $row['staffworkinghas']?></h3>
                                                                     </div> <!-- card_cnt end -->
                                                                </div> <!-- white card section end -->
                                                          </div> <!-- accordion-body end -->
                                              </div> <!-- accordion-collapse end -->
                                              </div> <!-- accordion-item end -->


                     </div> <!-- accordion end -->
                </div> <!-- card_wht end -->
            </div> <!-- col-lg-4 row end -->
       </div> <!-- row mt-5 end -->
  </div> <!-- Profile tab end -->
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
        <div class="cnt_sec">
                    <a href="internal page.php?enrollmentnumber=<?php echo $enrollmentnumber; ?>">
                            <div class="card_wht">
                                <h4>Internal Marks</h4>
                            </div>
                    </a>
                    <br>
                    <a href="semester results.php?enrollmentnumber=<?php echo $enrollmentnumber; ?>">
                        <div class="card_wht">
                            <h4>Semester Result</h4>
                        </div>
                    </a>
            </div> <!-- cnt_sec end -->
  </div> <!-- Academic Performance tab end -->
  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
        <div class="row mt-5">
                    <div class="col-lg-4">
                        <div class="cnt_sec">
                                <!-- white card section -->
                                <div class="card_wht">
                                    <div class="Profile" style="display: flex; justify-content: center; align-items: center; height: 80px;">
                                        <img src="assets/image/erp_profile.png">
                                    </div>
                                    <div class="head_main">
                                            <h4><?php echo $row['name']; ?></h4>
                                    </div>      
                                    <div class="card_cnt">
                                            <h3>Degree: <?php echo $row['degree']; ?></h3>
                                            <h3>Department: <?php echo $row['branch_name']; ?></h3>  
                                            <h3>Year: <?php echo $row['year_name']; ?></h3>
                                            <h3>Register No: <?php echo $row['reg_no']; ?></h3>
                                            <h3>Batch: <?php echo $row['batch']; ?></h3>
                                    </div>
                                </div>
                                <!-- white card section end -->
                        </div> <!-- cnt_sec end -->
                    </div> <!-- col-lg-4 end -->

                    <div class="col-lg-4 row" style=" width: 685px; gap: 15px;">
                        <div class="cnt_sec">
                            <!-- white card section -->
                            <div class="card_wht">
                                    <div class="head_main"><h4>Certifications</h4></div>
                                    <div class="card_cnt">
                                    <?php
                                                                
                                        $sql_c="SELECT * FROM `certificate` WHERE `sid`='$enrollmentnumber'";
                                        $result_c=$conn->query($sql_c);
                                        while($row_c=$result_c->fetch_assoc()){
                                            if($row_c["type"]==1){
                                            $type="Academics";
                                                }elseif($row_c["type"]==2){
                                                    $type="Sports";

                                                        }
                                                        elseif($row_c["type"]==3){
                                                        $type="Cultural Events";

                                                            }
                                                            ?>
                                        <h3>Category of Certification:   <?php echo $type?> - <?php echo $row_c["category"]?> </h3>
                                        <!--<h3>Category of Certification:   <?php echo $row_c["category"]?> </h3>-->
                                        <h3>Description:    <?php echo $row_c["description"]?></h3>
                                        <h3>Document:<a href="<?php echo $row_c['attach_files']?>" target="_blank"> Uploaded </a>       </h3>

                                                    <?php } ?>

                                    </div>
                            </div>
                        </div>
                    </div>
            </div> <!-- row mt-5 end -->

      </nav>  
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-academics-tab" data-bs-toggle="tab" data-bs-target="#nav-academics" type="button" role="tab" aria-controls="nav-academics" aria-selected="true">Academics</button>
                <button class="nav-link" id="nav-sports-tab" data-bs-toggle="tab" data-bs-target="#nav-sports" type="button" role="tab" aria-controls="nav-sports" aria-selected="false">Sports</button>
                <button class="nav-link" id="nav-culturals-tab" data-bs-toggle="tab" data-bs-target="#nav-culturals" type="button" role="tab" aria-controls="nav-culturals" aria-selected="false">Culturals</button>
            </div>
     </nav>

     <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-academics" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                <div class="certification-forms" id="academics-forms">
                        <div class="card_cnt">
                            <form action="certification.php" id="myForm" method="post" enctype="multipart/form-data"> 
                                    <h3>1. Select the Category of Certification</h3>
                                    <input type="hidden" name="h_t" value="1">
                                    <input type="hidden" name="h_sid" value="<?php echo $enrollmentnumber;?>">
                                    <select name="category" id="" style=" margin-left: 60px; width: 180px; height: 30px;  border:1px solid #89B0E7;  border-radius:4px; font-size: 16px;">
                                            <option value="Choose the Category">Choose the Category</option>
                                            <option value="Internship">Internship</option>
                                            <option value="Certification Course">Certification Course</option>
                                            <option value="Seminar">Seminar</option>
                                            <option value="Symposium">Symposium</option>
                                            <option value="Conference">Conference</option>
                                            <option value="Paper Presentation">Paper Presentation</option>
                                            <option value="Mini Project">Mini Project</option>
                                            <option value="Project">Project</option>
                                            <option value="Hackathon">Hackathon</option>
                                            <option value="Industrial Visit / Training">Industrial Visit / Training</option>
                                            <option value="Workshop">Workshop</option>  
                                    </select>
                                    <h3>2. Description:</h3>
                                    <textarea class="form-control" name="description" rows="5" placeholder="Give a Short Description about the Certification" required style="width: 550px; margin-left: 60px;"></textarea>
                                    <h3>3. Attach document</h3>
                                    <div>                                                
                                        <label for="ip_certificate" name="attach_files" style=" margin-left: 60px;">
                                                <input type="file" name="ip_certificate" id="ip_certificate">
                                                <div style="margin-top: 30px; margin-left: 120px;">
                                                    <button id="submit-button" style="margin-left: 60px; background: skyblue; border: 1px solid skyblue; color: white; width: 114px; height: 30px; border-radius: 50px;">Submit</button>
                                                </div>            
                                        </label>
                                    </div>       
                            </form>
                            <div>
                                <button onclick="addCertification()" style="position: relative; top: -25px; margin-left: 640px; background: skyblue; border: 1px solid skyblue; color: white; width: 114px; height: 30px; border-radius: 50px;">Add Another</button>
                            </div>
                        </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-sports" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                <div class="certification-forms" id="sports-forms">
                    <div class="card_cnt">
                    <form action="certification.php" id="myForm1" method="post" enctype="multipart/form-data">  
                                                        <h3>1. Select the Category of Certification</h3>
                                                        <input type="hidden" name="h_t" value="2">
                                                        <input type="hidden" name="h_sid" value="<?php echo $enrollmentnumber;?>">
                                                        <select name="category" id="" style=" margin-left: 60px; width: 180px; height: 30px;  border:1px solid #89B0E7;  border-radius:4px; font-size: 16px;">
                                                        <option value="Choose the Category">Choose the Category</option>
                                                        <option value="Cricket">Cricket</option>
                                                        <option value="Football">Football</option>
                                                        <option value="Volleyball">Volleyball</option>
                                                        <option value="Handball">Handball</option>
                                                        <option value="Athletics">Athletics</option>
                                                        <option value="Shot-put">Shot-put</option>
                                                        <option value="Kabbadi">Kabbadi</option>
                                                        <option value="Kho-Kho">Kho-Kho</option>
                                                        <option value="Badminton">Badminton</option>
                                                        <option value="Tennis">Tennis</option>
                                                        <option value="Chess">Chess</option>
                                                        <option value="Carrom">Carrom</option>
                                                        
                                                    </select>
                                                        <h3>2. Description:</h3>
                                                        <textarea class="form-control" name="description" rows="5" placeholder="Give a Short Description about the Certification" required style="width: 550px; margin-left: 60px;"></textarea>
                                                        <h3>3. Attach document</h3>
                                                        <div>                                                
                                                                <label for="ip_certificate" name="attach_files" style=" margin-left: 60px;">
                                                                        <input type="file" name="ip_certificate" id="ip_certificate">
                                                                            <div style="margin-top: 30px; margin-left: 120px;">
                                                                                <button id="submit-button" style="margin-left: 60px; background: skyblue; border: 1px solid skyblue; color: white; width: 114px; height: 30px; border-radius: 50px;">Submit</button>
                                                                            </div>            
                                                                </label>
                                                        </div>       
                                                </form>
                        <div>
                            <button onclick="addCertification1()" style="position: relative; top: -25px; margin-left: 640px; background: skyblue; border: 1px solid skyblue; color: white; width: 114px; height: 30px; border-radius: 50px;" >Add Another</button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-culturals" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
                <div class="certification-forms" id="cultural-forms">
                        <div class="card_cnt">
                        <form action="certification.php" id="myForm2" method="post" enctype="multipart/form-data">  
                                <h3>1. Select the Category of Certification</h3>
                                <input type="hidden" name="h_t" value="3">
                                <input type="hidden" name="h_sid" value="<?php echo $enrollmentnumber;?>">
                                <select name="category" id="" style=" margin-left: 60px; width: 180px; height: 30px;  border:1px solid #89B0E7;  border-radius:4px; font-size: 16px;">                                    
                                        <option value="Choose the Category">Choose the Category</option>
                                        <option value="Dance">Dance</option>
                                        <option value="Song">Song</option>
                                        <option value="Music">Music</option>
                                        <option value="Others">Others</option>
                                </select>
                                <h3>2. Description:</h3>
                                <textarea class="form-control" name="description" rows="5" placeholder="Give a Short Description about the Certification" required style="width: 550px; margin-left: 60px;"></textarea>
                                <h3>3. Attach document</h3>
                                <div>                                                
                                    <label for="ip_certificate" name="document" style=" margin-left: 60px;">
                                            <input type="file" name="ip_certificate" id="ip_certificate">
                                            <div style="margin-top: 30px; margin-left: 120px;">
                                                <button id="submit-button" style="margin-left: 60px; background: skyblue; border: 1px solid skyblue; color: white; width: 114px; height: 30px; border-radius: 50px;">Submit</button>
                                            </div>            
                                    </label>
                                </div>       
                        </form>
                        <div>
                                <button onclick="addCertification2()" style="position: relative; top: -25px; margin-left: 640px; background: skyblue; border: 1px solid skyblue; color: white; width: 114px; height: 30px; border-radius: 50px;" style="margin-top: 10px;">Add Another</button>
                        </div>

                        </div>
                </div>
            </div>
     </div> <!-- certification tab-content end -->
  </div>  <!-- Certification tab-pane end -->
  <div class="tab-pane fade" id="nav-attendance" role="tabpanel" aria-labelledby="nav-attendance-tab" tabindex="0">
            <div class="card_wht">
                    <div class="head_main">
                        <h4 class="heading">ATTENDANCE</h4>
                    </div>

            <form id="attendanceForm">
                <input type="hidden" name="h_sid" value="<?php echo $enrollmentnumber; ?>">
                <div class="row">
                    <div class="col lg-4">
                        <h3>1. Select Semester:</h3>
                        <select name="semester" style="margin-left: 60px; width: 180px; height: 30px; border:1px solid #89B0E7; border-radius:4px; font-size: 16px;">
                            <option value="">Choose the Semester</option>
                            <option value="1">Semester 1</option>
                            <option value="2">Semester 2</option>
                            <option value="3">Semester 3</option>
                            <option value="4">Semester 4</option>
                            <option value="5">Semester 5</option>
                            <option value="6">Semester 6</option>
                            <option value="7">Semester 7</option>
                        </select>
                    </div> <div class="col lg-4">
                        <h3>2. Select Month:</h3>
                        <select name="month" id="" style="margin-left: 60px; width: 180px; height: 30px; border:1px solid #89B0E7; border-radius:4px; font-size: 16px;">
                            <option value="">Choose the Month</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div> <div class="col lg-4">
                        <h3>3. Select Year:</h3>
                        <select name="year" id="" style="margin-left: 60px; width: 180px; height: 30px; border:1px solid #89B0E7; border-radius:4px; font-size: 16px;">
                            <option value="">Choose the Year</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                        </select>
                    </div> </div> <br><br>

                <h3><center><button type="button" id="submitButton" style="background: skyblue; border: 1px solid skyblue; color: white; width: 114px; height: 30px; border-radius: 50px;">Submit</button></center></h3>

            </form>

            <div id="attendanceData">
                </div>

        </div>

        <style>
            #attendanceData table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                border: 1px solid #ddd;
                font-size: 16px;
            }

            #attendanceData th, #attendanceData td {
                padding: 12px 15px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }

            #attendanceData th {
                background-color: #f2f2f2;
                font-weight: bold;
            }

            #attendanceData tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            #attendanceData tr:hover {
                background-color: #e0f7fa;
            }
        </style>

        <script>
            document.getElementById('submitButton').addEventListener('click', function() {
                const form = document.getElementById('attendanceForm');
                const formData = new FormData(form);

                fetch('get_attendance1.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('attendanceData').innerHTML = data;
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('attendanceData').innerHTML = '<p>Error fetching attendance data.</p>';
                });
            });
        </script>
  </div> <!-- Attendance tab end -->
  <div class="tab-pane fade" id="nav-leave" role="tabpanel" aria-labelledby="nav-leave-tab" tabindex="0">
     <div class="cnt_sec">
           <div class="card_wht">
                <div class="head_main">
                    <h4 class="heading">LEAVE RECORD</h4>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col">Date</th>
                            <th scope="col">Reason for Leave</th>
                            <th scope="col">Leave letter</th>
                        </tr>
                    </thead>
                    <tbody id="leavetable">
                        <?php
                            // Fetch leave records for the table
                            $sql_table = "SELECT * FROM `leaverecord` WHERE `sid` = '$enrollmentnumber'"; // Assuming $enrollmentnumber is available
                            $result_table = $conn->query($sql_table);

                            if ($result_table->num_rows > 0) {
                                while ($row = $result_table->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td scope='row'>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['date'] . "</td>";
                                    echo "<td>" . $row['reason'] . "</td>";
                                    echo "<td><a href='" . $row['leaveletter'] . "' target='_blank'>View</a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No leave records found.</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
         </div> <!-- white card section end -->
         <br> <br>
         <div class="card_wht"> <!-- white card section -->
              <div class="head_main"><h4>Leave Records</h4></div>
              <div class="leaveform" id="leave-forms">
                     <div class="card_cnt"> <!-- card_cnt section -->
                          <form action="leave.php" id="form4" method="post" enctype="multipart/form-data">
                                <h3>1. Date when the leave is taken</h3>
                                <input type="date" name="date" id="date" style="margin-left: 60px; width: 180px; height: 30px; border:1px solid #89B0E7; border-radius:4px; font-size: 16px;">
                                <h3>2. Reason for Leave</h3>
                                <input type="hidden" name="h_sid" value="<?php echo $enrollmentnumber; ?>">
                                 <select name="reason" id="reason" style="margin-left: 60px; width: 180px; height: 30px; border:1px solid #89B0E7; border-radius:4px; font-size: 16px;">
                                        <option value="">Select the Category</option>
                                        <option value="Medical Leave">Medical Leave</option>
                                        <option value="Emergency Leave">Emergency Leave</option>
                                        <option value="Others">Others</option>
                                 </select>
                                 <h3>3. Leave Letter</h3>
                                <div>
                                    <label for="ip_leave" name="leaveletter" style="margin-left: 60px;">
                                        <input type="file" name="ip_leave" id="ip_leave">
                                        <div style="margin-top: 30px; margin-left: 120px;">
                                            <button id="submit-button" style="margin-left: 60px; background: skyblue; border: 1px solid skyblue; color: white; width: 114px; height: 30px; border-radius: 50px;">Submit</button>
                                        </div>
                                    </label>
                                </div>
                         </form>
                      </div> <!-- card_cnt end -->
                    </div> <!-- leave form end -->
                </div> <!-- white card section end -->
     </div> <!-- cnt_sec end -->
  </div> <!-- Leave Record tab end -->
  <div class="tab-pane fade" id="nav-parentmeet" role="tabpanel" aria-labelledby="nav-parentmeet-tab" tabindex="0">
             <div class="card_wht">
                    <div class="head_main">
                            <h4 class="heading">
                                PARENT/GUARDIAN MEETING 
                            </h4>
                    </div>
                    <br> <br>
                    <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">S.No</th>
                                    <th scope="col">Name of the Parent/Guardian</th>
                                    <th scope="col">Reason for the meeting</th>
                                    <th scope="col">Remarks</th>
                                </tr>
                            </thead>
                            <tbody id="stutable">
                               <!-- <tr>
                                        <td scope="row">1</td>
                                        <td>xxxxxx</td>
                                        <td>General Parent's meeting</td>
                                        <td>None</td>
                                </tr> -->

                                <?php
                            // Fetch leave records for the table
                            $sql_table = "SELECT * FROM `parentsmeeting` WHERE `sid` = '$enrollmentnumber'"; // Assuming $enrollmentnumber is available
                            $result_table = $conn->query($sql_table);

                            if ($result_table->num_rows > 0) {
                                while ($row = $result_table->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td scope='row'>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['parent_guardian_name'] . "</td>";
                                    echo "<td>" . $row['reasonformeeting'] . "</td>";
                                    echo "<td>" . $row['remarks'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No Parents meeting records found.</td></tr>";
                            }
                        ?>
                            </tbody>
                        </table>
             </div> <!-- card_wht end -->
             <br> <br>
             <div class="card_wht"> <!-- white card section -->
              <div class="head_main"><h4>Parents Meeting Records</h4></div>
              <div class="leaveform" id="leave-forms">
                     <div class="card_cnt"> <!-- card_cnt section -->
                          <form action="parentsmeeting.php" id="form5" method="post" enctype="multipart/form-data">
                                <h3>1. Name of the Parent</h3>
                                <input type="text" name="parent_guardian_name" id="parent_guardian_name" style="margin-left: 60px; width: 180px; height: 30px; border:1px solid #89B0E7; border-radius:4px; font-size: 16px;">
                                <h3>2. Reason for Meeting</h3>
                                <input type="hidden" name="h_sid" value="<?php echo $enrollmentnumber; ?>">
                                 <select name="reasonformeeting" id="reasonformeeting" style="margin-left: 60px; width: 180px; height: 30px; border:1px solid #89B0E7; border-radius:4px; font-size: 16px;">
                                        <option value="">Select the Category</option>
                                        <option value="General Meeting">General meeting</option>
                                        <option value="Behavioral Issues">Behavioral Issues</option>
                                        <option value="Others">Others</option>
                                 </select>
                                 <h3>3. Remarks</h3>
                                 <input type="text" name="remarks" id="remarks" style="margin-left: 60px; width: 350px; height: 80px; border:1px solid #89B0E7; border-radius:4px; font-size: 16px;">
                                 <div style="margin-top: 30px; margin-left: 120px;">
                                        <button id="submit-button" style="margin-left: 60px; background: skyblue; border: 1px solid skyblue; color: white; width: 114px; height: 30px; border-radius: 50px;">Submit</button>
                                 </div>
                         </form>
                      </div> <!-- card_cnt end -->
                    </div> <!-- leave form end -->
                </div> <!-- white card section end -->
  </div> <!-- Parents Meet Record tab end -->
</div>
                            </div>
                        </div>
                        <!-- white card section end -->

                    </div>
                </div>
            </div>
        </div>
        
        
        
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

    <script>

            document.getElementById('myForm').addEventListener('submit', function(event) {
                event.preventDefault();

                const form = document.getElementById('myForm');
                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    console.log('Success/Error:', data); // Log the full response

                    if (data.includes("File uploaded and record inserted successfully")) { // Exact match
                        alert("Document uploaded successfully!");
                        form.reset(); // Clear the form after successful upload
                    }
                        else {
                        alert("File upload: " + data); // Show detailed error
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("Error submitting the form.");
                });
            });


                // sports form
            document.getElementById('myForm1').addEventListener('submit', function(event) {
                event.preventDefault();

                const form = document.getElementById('myForm1');
                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    console.log('Success/Error:', data); // Log the full response

                    if (data.includes("File uploaded and record inserted successfully")) { // Exact match
                        alert("Document uploaded successfully!");
                        form.reset(); // Clear the form after successful upload
                    }
                        else {
                        alert("File upload: " + data); // Show detailed error
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("Error submitting the form.");
                });
            });


                //culturals form
            document.getElementById('myForm2').addEventListener('submit', function(event) {
                event.preventDefault();

                const form = document.getElementById('myForm2');
                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    console.log('Success/Error:', data); // Log the full response

                    if (data.includes("File uploaded and record inserted successfully")) { // Exact match
                        alert("Document uploaded successfully!");
                        form.reset(); // Clear the form after successful upload
                    }
                        else {
                        alert("File upload: " + data); // Show detailed error
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("Error submitting the form.");
                });
            });




            function addCertification() {
            var container = document.createElement('div');
            container.classList.add('card_cnt');

            var html = `
            <div class="card_cnt">
                                        <form action="certification.php" id="myForm" method="post" enctype="multipart/form-data"> 
                                                    <h3>1. Select the Category of Certification</h3>
                                                    <input type="hidden" name="h_t" value="1">
                                                    <input type="hidden" name="h_sid" value="<?php echo $enrollmentnumber;?>">
                                                            <select name="category" id="" style=" margin-left: 60px; width: 180px; height: 30px;  border:1px solid #89B0E7;  border-radius:4px; font-size: 16px;">
                                                                <option value="Choose the Category">Choose the Category</option>
                                                                <option value="Internship">Internship</option>
                                                                <option value="Certification Course">Certification Course</option>
                                                                <option value="Seminar">Seminar</option>
                                                                <option value="Symposium">Symposium</option>
                                                                <option value="Conference">Conference</option>
                                                                <option value="Paper Presentation">Paper Presentation</option>
                                                                <option value="Mini Project">Mini Project</option>
                                                                <option value="Project">Project</option>
                                                                <option value="Hackathon">Hackathon</option>
                                                                <option value="Industrial Visit / Training">Industrial Visit / Training</option>
                                                                <option value="Workshop">Workshop</option>  
                                                            </select>
                                                    <h3>2. Description:</h3>
                                                    <textarea class="form-control" name="description" rows="5" placeholder="Give a Short Description about the Certification" required style="width: 550px; margin-left: 60px;"></textarea>
                                                    <h3>3. Attach document</h3>
                                                    <div>                                                
                                                            <label for="ip_certificate" name="attach_files" style=" margin-left: 60px;">
                                                                    <input type="file" name="ip_certificate" id="ip_certificate">
                                                                        <div style="margin-top: 30px; margin-left: 120px;">
                                                                            <button id="submit-button" style="margin-left: 60px; background: skyblue; border: 1px solid skyblue; color: white; width: 114px; height: 30px; border-radius: 50px;">Submit</button>
                                                                        </div>            
                                                            </label>
                                                    </div>       
                                                </form>
                                        
                                            <div>
                                                <button onclick="addCertification()" style="position: relative; top: -25px; margin-left: 640px; background: skyblue; border: 1px solid skyblue; color: white; width: 114px; height: 30px; border-radius: 50px;">Add Another</button>
                                            </div>
                                    </div>`;

            container.innerHTML = html;
            document.getElementById('academics-forms').appendChild(container);

            container.querySelector('#submit-button').addEventListener('click', function(event) {
            event.preventDefault();
            alert("Document submitted successfully!");
            });
            }

            function addCertification1() {
            var container = document.createElement('div');
            container.classList.add('card_cnt');

            var html = `
            <div class="card_cnt">
                    <form action="certification.php" id="myForm1" method="post" enctype="multipart/form-data">  
                                                    <h3>1. Select the Category of Certification</h3>
                                                    <input type="hidden" name="h_t" value="2">
                                                    <input type="hidden" name="h_sid" value="<?php echo $enrollmentnumber;?>">
                                                    <select name="category" id="" style=" margin-left: 60px; width: 180px; height: 30px;  border:1px solid #89B0E7;  border-radius:4px; font-size: 16px;">
                                                        <option value="Choose the Category">Choose the Category</option>
                                                        <option value="Cricket">Cricket</option>
                                                        <option value="Football">Football</option>
                                                        <option value="Volleyball">Volleyball</option>
                                                        <option value="Handball">Handball</option>
                                                        <option value="Athletics">Athletics</option>
                                                        <option value="Shot-put">Shot-put</option>
                                                        <option value="Kabbadi">Kabbadi</option>
                                                        <option value="Kho-Kho">Kho-Kho</option>
                                                        <option value="Badminton">Badminton</option>
                                                        <option value="Tennis">Tennis</option>
                                                        <option value="Chess">Chess</option>
                                                        <option value="Carrom">Carrom</option>
                                                        
                                                    </select>
                                                    <h3>2. Description:</h3>
                                                    <textarea class="form-control" name="description" rows="5" placeholder="Give a Short Description about the Certification" required style="width: 550px; margin-left: 60px;"></textarea>
                                                    <h3>3. Attach document</h3>
                                                    <div>                                                
                                                            <label for="ip_certificate" name="attach_files" style=" margin-left: 60px;">
                                                                    <input type="file" name="ip_certificate" id="ip_certificate">
                                                                        <div style="margin-top: 30px; margin-left: 120px;">
                                                                            <button id="submit-button" style="margin-left: 60px; background: skyblue; border: 1px solid skyblue; color: white; width: 114px; height: 30px; border-radius: 50px;">Submit</button>
                                                                        </div>            
                                                            </label>
                                                    </div>       
                                                </form>
                        <div>
                            <button onclick="addCertification1()" style="position: relative; top: -25px; margin-left: 640px; background: skyblue; border: 1px solid skyblue; color: white; width: 114px; height: 30px; border-radius: 50px;" >Add Another</button>
                        </div>
                </div>`;

            container.innerHTML = html;
            document.getElementById('sports-forms').appendChild(container);

            container.querySelector('#submit-button1').addEventListener('click', function(event) {
            event.preventDefault();
            alert("Document submitted successfully!");
            });
            }

            function addCertification2() {
            var container = document.createElement('div');
            container.classList.add('card_cnt');

            var html = `
            <div class="card_cnt">
                    <form action="certification.php" id="myForm2" method="post" enctype="multipart/form-data">  
                                                    <h3>1. Select the Category of Certification</h3>
                                                    <input type="hidden" name="h_t" value="3">
                                                    <input type="hidden" name="h_sid" value="<?php echo $enrollmentnumber;?>">
                                                            <select name="category" id="" style=" margin-left: 60px; width: 180px; height: 30px;  border:1px solid #89B0E7;  border-radius:4px; font-size: 16px;">
                                                            
                                                                    <option value="Choose the Category">Choose the Category</option>
                                                                    <option value="Dance">Dance</option>
                                                                    <option value="Song">Song</option>
                                                                    <option value="Music">Music</option>
                                                                    <option value="Others">Others</option>
                                                    
                                                            </select>
                                                    <h3>2. Description:</h3>
                                                    <textarea class="form-control" name="description" rows="5" placeholder="Give a Short Description about the Certification" required style="width: 550px; margin-left: 60px;"></textarea>
                                                    <h3>3. Attach document</h3>
                                                    <div>                                                
                                                            <label for="ip_certificate" name="document" style=" margin-left: 60px;">
                                                                    <input type="file" name="ip_certificate" id="ip_certificate">
                                                                        <div style="margin-top: 30px; margin-left: 120px;">
                                                                            <button id="submit-button" style="margin-left: 60px; background: skyblue; border: 1px solid skyblue; color: white; width: 114px; height: 30px; border-radius: 50px;">Submit</button>
                                                                        </div>            
                                                            </label>
                                                    </div>       
                                                </form>
                                        <div>
                                            <button onclick="addCertification2()" style="position: relative; top: -25px; margin-left: 640px; background: skyblue; border: 1px solid skyblue; color: white; width: 114px; height: 30px; border-radius: 50px;" style="margin-top: 10px;">Add Another</button>
                                        </div>
                </div>`;

            container.innerHTML = html;
            document.getElementById('cultural-forms').appendChild(container);

            container.querySelector('#submit-button2').addEventListener('click', function(event) {
            event.preventDefault();
            alert("Document submitted successfully!");
            });
            }



            document.getElementById('form4').addEventListener('submit', function(event) {
                event.preventDefault();

                const form = document.getElementById('form4');
                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    console.log('Success/Error:', data); // Log the full response

                    if (data.includes("File uploaded and record inserted successfully")) { // Exact match
                        alert("Document uploaded successfully!");
                        form.reset(); // Clear the form after successful upload
                    }
                        else {
                        alert("File upload: " + data); // Show detailed error
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("Error submitting the form.");
                });
            });



            </script>
                                                    
                
            </body>

            <script>
                //function open_pop(){
                //        document.getElementById("popalert").style.display="flex";
                //}
                //function close_pop(){
                //        document.getElementById("popalert").style.display="none";
                //}

                
                //document.getElementById('add-button').addEventListener('click', function() {
                //document.getElementById('file-input').click();
                // });

                                                                              
   </script>
</html>