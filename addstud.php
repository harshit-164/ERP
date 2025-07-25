<?php
// Database connection details
include("con.php");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming your form data is submitted via POST method
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data (replace with appropriate sanitization methods)
    $name = $conn->real_escape_string($_POST["name"]);
    $nameDocument = isset($_FILES['namedocument']) ? $_FILES['namedocument'] : null;
    $enrollmentNumber = $conn->real_escape_string($_POST["enrollmentnumber"]);
    $admissionNumber = $conn->real_escape_string($_POST["admissionnumber"]);
    $degree = $conn->real_escape_string($_POST["degree"]);
    $Branch = $conn->real_escape_string($_POST["branch"]);
    $year = $conn->real_escape_string($_POST["year"]);
    $Semester =  $conn->real_escape_string($_POST["semester"]);
    $batch = $conn->real_escape_string($_POST["batch"]);
    $Regulation = isset($_POST['regulation']) ? $_POST['regulation'] : '';
    $regNo = $conn->real_escape_string($_POST["reg_no"]);
    $dateOfJoining = $conn->real_escape_string($_POST["dateofjoining"]);
    $dateOfBirth = $conn->real_escape_string($_POST["dateofbirth"]);
    $emailId = $conn->real_escape_string($_POST["emailid"]);
    $phoneNo = $conn->real_escape_string($_POST["phoneno"]);
    $alternateNo = $conn->real_escape_string($_POST["alternateno"]);
    $gender = $conn->real_escape_string($_POST["gender"]);
    $bloodGroup = $conn->real_escape_string($_POST["bloodgroup"]);
    $religion = $conn->real_escape_string($_POST["religion"]);
    $community = $conn->real_escape_string($_POST["community"]);
    $communityDocument = isset($_FILES['communitydocument']) ? $_FILES['communitydocument'] : null;
    $communityCertificateNumber = $conn->real_escape_string($_POST["communitycertificatenumber"]);
    $caste = $conn->real_escape_string($_POST["caste"]);
    $typeOfEntry = $conn->real_escape_string($_POST["typeofentry"]);
    $firstgraudate = $conn->real_escape_string($_POST["firstgraduate"]);
    $fgDocument = isset($_FILES['fgdocument']) ? $_FILES['fgdocument'] : null;
    $reference = $conn->real_escape_string($_POST["reference"]);
    $referenceName = $conn->real_escape_string($_POST["referencename"]);
    $DayScholarorHostel = $conn->real_escape_string($_POST["dayscholarorhostel"]);
    $Modeoftransport = $conn->real_escape_string($_POST["transportmode"]);
    $Vehiclename = $conn->real_escape_string($_POST["vehiclename"]);
    $RegNumber = $conn->real_escape_string($_POST["registrationnumber"]);
    $Clgbusnumber = $conn->real_escape_string($_POST["clgbusnumber"]);
    $RoomNo = $conn->real_escape_string($_POST["hostelroomno"]);
    $WardenName = $conn->real_escape_string($_POST["hostelwardenname"]);
    $hosteladdress = $conn->real_escape_string($_POST["hostelguardianaddress"]);
    $hostelPhoneNo = $conn->real_escape_string($_POST["hostelguardianphoneno"]);

    $belongstoTNornot = $conn->real_escape_string($_POST["belongstoTNornot"]);
    $otherPlace = $conn->real_escape_string($_POST["otherplace"]);
        if ($belongstoTNornot === 'OtherPlace' && !empty($otherPlace)) {
            $place = $otherPlace;
      } else {
          $place = 'TamilNadu'; // Default to TamilNadu
        }
    $identificationMark = $conn->real_escape_string($_POST["identificationmark"]);
    $motherTongue = $conn->real_escape_string($_POST["mothertongue"]);
    $nationality = $conn->real_escape_string($_POST["nationality"]);
    $medium = $conn->real_escape_string($_POST["medium"]);
    $physicaldisabilities = $conn->real_escape_string($_POST["physicaldisabilities"]);
    $PassWord = $conn->real_escape_string($_POST["password"]);
    $plainPassword = $_POST["password"];
    
    // Encryption settings
    $encryptionMethod = "AES-256-CBC"; // Encryption algorithm
    $secretKey = "your-secret-key-here"; // Should be a 32 character string
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($encryptionMethod));
    
    // Encrypt the password
    $encryptedPassword = openssl_encrypt(
        $plainPassword, 
        $encryptionMethod, 
        $secretKey, 
        0, 
        $iv
    );
    
    // Store both the encrypted password and IV (initialization vector)
    // You might want to combine them for storage, like:
    $encryptedData = base64_encode($iv).'::'.base64_encode($encryptedPassword);
    $address = $conn->real_escape_string($_POST["address"]);
    $fatherName = $conn->real_escape_string($_POST["fathername"]);
    $fatherOccupation = $conn->real_escape_string($_POST["fathersoccupation"]);
    $fatherIncome = $conn->real_escape_string($_POST["fatherincome"]);
    $fatherIncomeDocument =isset($_FILES['fatherincomedocument']) ? $_FILES['fatherincomedocument'] : null;
    $fatherNumber = $conn->real_escape_string($_POST["fathersnumber"]);
    $motherName = $conn->real_escape_string($_POST["mothername"]);
    $motherOccupation = $conn->real_escape_string($_POST["motheroccupation"]);
    $motherIncome = $conn->real_escape_string($_POST["motherincome"]);
    $motherIncomeDocument = isset($_FILES['motherincomedocument']) ? $_FILES['motherincomedocument'] : null;
    $motherNumber = $conn->real_escape_string($_POST["mothernumber"]);
    $guardian = isset($_POST["guardian"]) ? $_POST["guardian"] : null;
    $guardianName = (isset($_POST["guardianname"]) && $guardian === "YES") ? 
                        $conn->real_escape_string($_POST["guardianname"]) : null;                   
    $guardianContactNo = (isset($_POST["guardiancontactno"]) && $guardian === "YES") ? 
                        $conn->real_escape_string($_POST["guardiancontactno"]) : null;
    $relation = (isset($_POST["relation"]) && $guardian === "YES") ? 
                        $conn->real_escape_string($_POST["relation"]) : null;
    $guardianAddress = (isset($_POST["guardianaddress"]) && $guardian === "YES") ? 
                        $conn->real_escape_string($_POST["guardianaddress"]) : null;                          
    $bankName = $conn->real_escape_string($_POST["bankname"]);
    $bankBranchName = $conn->real_escape_string($_POST["bankbranchname"]);
    $accountHolderName = $conn->real_escape_string($_POST["accountholdername"]);
    $accountNumber = $conn->real_escape_string($_POST["accountnumber"]);
    $accountNumberDocument = isset($_FILES['accountnumberdocument']) ? $_FILES['accountnumberdocument'] : null;
    $accountType = $conn->real_escape_string($_POST["accounttype"]);
    $ifscCode = $conn->real_escape_string($_POST["ifsccode"]);
    $micrCode = $conn->real_escape_string($_POST["micrcode"]); 
    $bankAddress = $conn->real_escape_string($_POST["bankaddress"]);
    $aadharNo = $conn->real_escape_string($_POST["aadharno"]);
    $aadharNoDocument = isset($_FILES['aadhardocument']) ? $_FILES['aadhardocument'] : null;
    $panCardNo = $conn->real_escape_string($_POST["pancardno"]);
    $panCardNoDocument = isset($_FILES['pancarddocument']) ? $_FILES['pancarddocument'] : null;
    $scholarshipType = $conn->real_escape_string($_POST["scholarshiptype"]);
    $emisNumber = $conn->real_escape_string($_POST["emisumber"]);
    $umisNumber = $conn->real_escape_string($_POST["umisnumber"]);
    $abcCerditNumber = $conn->real_escape_string($_POST["abccreditnumber"]); 
    $abcDocument = isset($_FILES['abcdocument']) ? $_FILES['abcdocument'] : null;
    $tenthMark = $conn->real_escape_string($_POST["tenthmark"]);
    $tenthMarkDocument = isset($_FILES['tenthdocument']) ? $_FILES['tenthdocument'] : null;
    

    $twelfthMark = $conn->real_escape_string($_POST["twelvethmark"]);
    $twelfthMarkDocument = isset($_FILES['twelvethdocument']) ? $_FILES['twelvethdocument'] : null;
    $diploma =  isset($_POST["diploma"]) ? $_POST["diploma"] : null;
    $diplomaCollege = isset($_POST["diplomacollege"]) && $diploma === "YES" ? 
                          $conn->real_escape_string($_POST["diplomacollege"]) : null;    
    $diplomaCourse = isset($_POST["diplomacourse"]) && $diploma === "YES" ? 
                          $conn->real_escape_string($_POST["diplomacollege"]) : null;
    $diplomaPercentage = isset($_POST["diplomapercentage"]) && $diploma === "YES" ? 
                          $conn->real_escape_string($_POST["diplomapercentage"]) : null;
    $diplomaMarksheetsDocument =isset($_POST["diplomamarksheetsdocument"]) && $diploma === "YES" ? 
                             (isset($_FILES['diplomamarksheetsdocument']) ? $_FILES['diplomamarksheetsdocument'] : null) : null;
    $diplomaDegreeCertificateDocument = isset($_POST["diplomadegreecertificatedocument"]) && $diploma === "YES" ? 
                             (isset($_FILES['diplomadegreecertificatedocument']) ? $_FILES['diplomadegreecertificatedocument'] : null) : null;
    $Ug =  isset($_POST["ug"]) ? $_POST["ug"] : null;  
    $UgCollege = isset($_POST["ugcollegename"]) && $Ug === "YES" ? 
                        $conn->real_escape_string($_POST["ugcollegename"]) : null; 
    $UgDegree = isset($_POST["ugdegree"]) && $Ug === "YES" ? 
                        $conn->real_escape_string($_POST["ugdegree"]) : null;    
    $UgCourse = isset($_POST["ugcourse"]) && $Ug === "YES" ? 
                       $conn->real_escape_string($_POST["ugcourse"]) : null;
    $UgPercentage = isset($_POST["ugpercentage"]) && $Ug === "YES" ? 
                         $conn->real_escape_string($_POST["ugpercentage"]) : null;
    $UgMarksheetsDocument =isset($_POST["ugmarksheetsdocument"]) && $Ug === "YES" ? 
                             (isset($_FILES['ugmarksheetsdocument']) ? $_FILES['ugmarksheetsdocument'] : null) : null;
    $UgDegreeCertificateDocument = isset($_POST["ugdegreecertificatedocument"]) && $Ug === "YES" ? 
                                (isset($_FILES['ugdegreecertificatedocument']) ? $_FILES['ugdegreecertificatedocument'] : null) : null;
    $tcNo = $conn->real_escape_string($_POST["tcno"]);
    $tcNoDocument = isset($_FILES['tcnodocument']) ? $_FILES['tcnodocument'] : null;
    $tenthPercentage = $conn->real_escape_string($_POST["tenthpercentage"]);   
   
    $twelfthPercentage = $conn->real_escape_string($_POST["twelvethpercentage"]);
    $doteManagement =  $conn->real_escape_string($_POST["dotemanagement"]);
    $quota =  $conn->real_escape_string($_POST["quota"]);
    $tneaRanking = $conn->real_escape_string($_POST["tnearankingnumber"]);
    $communityRanking = $conn->real_escape_string($_POST["communityrankingnumber"]);
    $cutoff = $conn->real_escape_string($_POST["cutoff"]);
    $TenthschoolName = $conn->real_escape_string($_POST["tenthschoolname"]);
    $TwelvethschoolName = $conn->real_escape_string($_POST["twelvethschoolname"]);
    $sportName = $conn->real_escape_string($_POST["nameofthesport"]);
    $sportslevel = $conn->real_escape_string($_POST['sportslevel']);
    $achievements = $conn->real_escape_string($_POST["achievements"]);
    $certifications = $conn->real_escape_string($_POST["certifications"]);
    $certificationsDocument = isset($_FILES['certificationdocument']) ? $_FILES['certificationdocument'] : null;
    $sportsQuotaPercentage = $conn->real_escape_string($_POST["sportsquotapercentage"]);
    $drivingKnown = $conn->real_escape_string($_POST["drivingknown"]);
    $licenseNumber = $conn->real_escape_string($_POST["licensenumber"]);
    $issueOffice = $conn->real_escape_string($_POST["issueoffice"]);
    $lanuageKnown = $conn->real_escape_string($_POST["languageknown"]);
    $RelativeStuding = $conn->real_escape_string($_POST["relativesstuding"]);
    $StdName = $conn->real_escape_string($_POST["stdname"]);
    $StdDegree = $conn->real_escape_string($_POST["stddegree"]);
    $StdDepartment = $conn->real_escape_string($_POST["stddepartment"]);
    $StdYear = $conn->real_escape_string($_POST["stdyear"]);
    $RelativeStaff = $conn->real_escape_string($_POST["relativestaffworking"]);
    $StaffName = $conn->real_escape_string($_POST["staffname"]);
    $StaffWorking = $conn->real_escape_string($_POST["staffworkinghas"]);
    
    
    $target_dir = "uploads/";
       if (!empty($_FILES["ip_sport_c"]["name"])) {
           $target_file = $target_dir . basename($_FILES["ip_sport_c"]["name"]); 
          // Move the uploaded file to the uploads directory
          if (move_uploaded_file($_FILES["ip_sport_c"]["tmp_name"], $target_file)) {
             echo "File uploaded successfully: " . $_FILES["ip_sport_c"]["name"];
         } else {
             echo "Error uploading file.";
           }
     } else {
         $target_file = "Not uploaded ";
      }
     
        
      $target_dir = "uploads/";
      if (!empty($_FILES["ip_ten"]["name"])) {
          $target_file1 = $target_dir . basename($_FILES["ip_ten"]["name"]); 
         // Move the uploaded file to the uploads directory
         if (move_uploaded_file($_FILES["ip_ten"]["tmp_name"], $target_file1)) {
            echo "File uploaded successfully: " . $_FILES["ip_ten"]["name"];
        } else {
            echo "Error uploading file.";
          }
    } else {
        $target_file1 = "Not uploaded ";
     }


     $target_dir = "uploads/";
     if (!empty($_FILES["ip_community"]["name"])) {
         $target_file2 = $target_dir . basename($_FILES["ip_community"]["name"]); 
        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($_FILES["ip_community"]["tmp_name"], $target_file2)) {
           echo "File uploaded successfully: " . $_FILES["ip_community"]["name"];
       } else {
           echo "Error uploading file.";
         }
   } else {
       $target_file2 = "Not uploaded ";
    }

    $target_dir = "uploads/";
    if (!empty($_FILES["ip_fatherincome"]["name"])) {
        $target_file3 = $target_dir . basename($_FILES["ip_fatherincome"]["name"]); 
       // Move the uploaded file to the uploads directory
       if (move_uploaded_file($_FILES["ip_fatherincome"]["tmp_name"], $target_file3)) {
          echo "File uploaded successfully: " . $_FILES["ip_fatherincome"]["name"];
      } else {
          echo "Error uploading file.";
        }
  } else {
      $target_file3 = "Not uploaded ";
   }

        $target_dir = "uploads/";
       if (!empty($_FILES["ip_motherincome"]["name"])) {
           $target_file4 = $target_dir . basename($_FILES["ip_motherincome"]["name"]); 
          // Move the uploaded file to the uploads directory
          if (move_uploaded_file($_FILES["ip_motherincome"]["tmp_name"], $target_file4)) {
             echo "File uploaded successfully: " . $_FILES["ip_motherincome"]["name"];
         } else {
             echo "Error uploading file.";
           }
     } else {
         $target_file4 = "Not uploaded ";
        }
       // Now you can insert $target_file4 into the database
       

       $target_dir = "uploads/";
       if (!empty($_FILES["ip_acc_passbook"]["name"])) {
           $target_file5 = $target_dir . basename($_FILES["ip_acc_passbook"]["name"]); 
          // Move the uploaded file to the uploads directory
          if (move_uploaded_file($_FILES["ip_acc_passbook"]["tmp_name"], $target_file5)) {
             echo "File uploaded successfully: " . $_FILES["ip_acc_passbook"]["name"];
         } else {
             echo "Error uploading file.";
           }
     } else {
         $target_file5 = "Not uploaded ";
        }

        $target_dir = "uploads/";
        if (!empty($_FILES["ip_aadhar"]["name"])) {
            $target_file6 = $target_dir . basename($_FILES["ip_aadhar"]["name"]); 
           // Move the uploaded file to the uploads directory
           if (move_uploaded_file($_FILES["ip_aadhar"]["tmp_name"], $target_file6)) {
              echo "File uploaded successfully: " . $_FILES["ip_aadhar"]["name"];
          } else {
              echo "Error uploading file.";
            }
      } else {
          $target_file6 = "Not uploaded ";
       }

       $target_dir = "uploads/";
       if (!empty($_FILES["ip_pan"]["name"])) {
           $target_file7 = $target_dir . basename($_FILES["ip_pan"]["name"]); 
          // Move the uploaded file to the uploads directory
          if (move_uploaded_file($_FILES["ip_pan"]["tmp_name"], $target_file7)) {
             echo "File uploaded successfully: " . $_FILES["ip_pan"]["name"];
         } else {
             echo "Error uploading file.";
           }
     } else {
         $target_file7 = "Not uploaded ";
      }

        

      $target_dir = "uploads/";
      if (!empty($_FILES["ip_twelveth"]["name"])) {
          $target_file9 = $target_dir . basename($_FILES["ip_twelveth"]["name"]); 
         // Move the uploaded file to the uploads directory
         if (move_uploaded_file($_FILES["ip_twelveth"]["tmp_name"], $target_file9)) {
            echo "File uploaded successfully: " . $_FILES["ip_twelveth"]["name"];
        } else {
            echo "Error uploading file.";
          }
    } else {
        $target_file9 = "Not uploaded ";
     }
     
     
     $target_dir = "uploads/";
     if (!empty($_FILES["ip_tc"]["name"])) {
         $target_file10 = $target_dir . basename($_FILES["ip_tc"]["name"]); 
        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($_FILES["ip_tc"]["tmp_name"], $target_file10)) {
           echo "File uploaded successfully: " . $_FILES["ip_tc"]["name"];
       } else {
           echo "Error uploading file.";
         }
   } else {
       $target_file10 = "Not uploaded ";
    }


    
      
    $target_dir = "uploads/";
    if (!empty($_FILES["ip_fg"]["name"])) {
        $target_file11 = $target_dir . basename($_FILES["ip_fg"]["name"]); 
       // Move the uploaded file to the uploads directory
       if (move_uploaded_file($_FILES["ip_fg"]["tmp_name"], $target_file11)) {
          echo "File uploaded successfully: " . $_FILES["ip_fg"]["name"];
      } else {
          echo "Error uploading file.";
        }
  } else {
      $target_file11 = "Not uploaded ";
   }
      
    $target_dir = "uploads/";
    if (!empty($_FILES["ip_nm"]["name"])) {
        $target_file12 = $target_dir . basename($_FILES["ip_nm"]["name"]); 
        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($_FILES["ip_nm"]["tmp_name"], $target_file12)) {
            echo "File uploaded successfully: " . $_FILES["ip_nm"]["name"];
        } else {
            echo "Error uploading file.";
        }
    } else {
        $target_file12 = "Not uploaded ";
    }
            
    $target_dir = "uploads/";
    if (!empty($_FILES["ip_diplomamarksheets"]["name"])) {
        $target_file13 = $target_dir . basename($_FILES["ip_diplomamarksheets"]["name"]); 
       // Move the uploaded file to the uploads directory
       if (move_uploaded_file($_FILES["ip_diplomamarksheets"]["tmp_name"], $target_file13)) {
          echo "File uploaded successfully: " . $_FILES["ip_diplomamarksheets"]["name"];
      } else {
          echo "Error uploading file.";
        }
  } else {
      $target_file13 = "Not uploaded ";
   }
               
               
   $target_dir = "uploads/";
   if (!empty($_FILES["ip_diplomadegreecertificate"]["name"])) {
       $target_file14 = $target_dir . basename($_FILES["ip_diplomadegreecertificate"]["name"]); 
      // Move the uploaded file to the uploads directory
      if (move_uploaded_file($_FILES["ip_diplomamarksheets"]["tmp_name"], $target_file14)) {
         echo "File uploaded successfully: " . $_FILES["ip_diplomadegreecertificate"]["name"];
     } else {
         echo "Error uploading file.";
       }
 } else {
     $target_file14 = "Not uploaded ";
  }
                
  $target_dir = "uploads/";
  if (!empty($_FILES["ip_ugdegreecertificate"]["name"])) {
      $target_file15 = $target_dir . basename($_FILES["ip_ugdegreecertificate"]["name"]); 
     // Move the uploaded file to the uploads directory
     if (move_uploaded_file($_FILES["ip_ugdegreecertificate"]["tmp_name"], $target_file15)) {
        echo "File uploaded successfully: " . $_FILES["ip_ugdegreecertificate"]["name"];
    } else {
        echo "Error uploading file.";
      }
    } else {
        $target_file15 = "Not uploaded ";
    }

    $target_dir = "uploads/";
    if (!empty($_FILES["ip_ugmarksheets"]["name"])) {
        $target_file16 = $target_dir . basename($_FILES["ip_ugmarksheets"]["name"]); 
        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($_FILES["ip_ugmarksheets"]["tmp_name"], $target_file16)) {
        echo "File uploaded successfully: " . $_FILES["ip_ugmarksheets"]["name"];
    } else {
        echo "Error uploading file.";
        }
    } else {
    $target_file16 = "Not uploaded ";
    }
    $target_dir = "uploads/";
    if (!empty($_FILES["ip_abc"]["name"])) {
        $target_file17 = $target_dir . basename($_FILES["ip_abc"]["name"]); 
    // Move the uploaded file to the uploads directory
    if (move_uploaded_file($_FILES["ip_abc"]["tmp_name"], $target_file17)) {
        echo "File uploaded successfully: " . $_FILES["ip_abc"]["name"];
    } else {
        echo "Error uploading file.";
        }
    } else {
    $target_file17 = "Not uploaded ";
    }



    // SQL query to insert data into the database
    $sql = "INSERT INTO students (
        id,name, namedocument, enrollmentnumber, admissionnumber, degree, 
        branch, year, semester, batch, regulation, reg_no,  dateofjoining,
        dateofbirth, emailid, phoneno, alternateno, gender, 
        bloodgroup, religion, community, communitydocument, communitycertificatenumber,
        caste, typeofentry,  firstgraduate, fgdocument, reference,
        referencename, dayscholarorhostel, transportmode, vehiclename, registrationnumber,
        clgbusnumber, hostelroomno, hostelwardenname, hostelguardianaddress, hostelguardianphoneno,   
        belongstoTNornot, otherplace, identificationmark, mothertongue, nationality, 
        medium, physicaldisabilities, password, address, fathername, fatheroccupation, 
        fatherincome, fatherincomedocument, fathernumber,mothername, motheroccupation,
        motherincome, motherincomedocument, mothernumber, guardian, guardianname, 
        guardiancontactno, relation, guardianaddress,bankname, bankbranchname,
        accountholdername, accountnumber, accountnumberdocument, accounttype, ifsccode, 
        micrcode, bankaddress, aadharno, aadhardocument, pancardno, 
        pancarddocument, scholarshiptype, emisnumber, umisnumber, abccreditnumber, 
        abcdocument, tenthmark, tenthdocument, twelfthmark, twelvethdocument, 
        diploma, diplomacollege, diplomacourse, diplomapercentage, diplomamarksheetsdocument, 
        diplomadegreecertificatedocument, ug, ugcollegename, ugdegree, ugcourse, ugpercentage, 
        ugmarksheetsdocument, ugdegreecertificatedocument, tcno, tcnodocument,tenthpercentage, 
        twelfthpercentage, dotemanagement,quota, tnearankingnumber, communityrankingnumber,
        cutoff, tenthschoolname, twelvethschoolname, sportname, sportslevel, 
        achievements, certifications, certificationdocument, sportsquotapercentage, drivingknown, 
        licensenumber, issueoffice, languageknown, relativesstuding, stdname, 
        stddegree, stddepartment, stdyear, relativestaffworking, staffname, 
        staffworkinghas 
    ) VALUES (
        '0','$name', '$target_file12', '$enrollmentNumber','$admissionNumber', '$degree', 
        '$Branch', '$year', '$Semester', '$batch', '$Regulation', '$regNo','$dateOfJoining', 
        '$dateOfBirth', '$emailId', '$phoneNo', '$alternateNo','$gender', 
        '$bloodGroup', '$religion', '$community','$target_file2','$communityCertificateNumber', 
        '$caste', '$typeOfEntry',  '$firstgraudate','$target_file11','$reference',
        '$referenceName','$DayScholarorHostel','$Modeoftransport', '$Vehiclename', '$RegNumber', 
        '$Clgbusnumber', '$RoomNo', '$WardenName', '$hosteladdress', '$hostelPhoneNo',
        '$belongstoTNornot','$otherPlace','$identificationMark','$motherTongue','$nationality',
        '$medium','$physicaldisabilities', '$encryptedPassword', '$address', '$fatherName', '$fatherOccupation',
        '$fatherIncome','$target_file3', '$fatherNumber','$motherName', '$motherOccupation',
        '$motherIncome','$target_file4', '$motherNumber', '$guardian', '$guardianName', 
        '$guardianContactNo', '$relation', '$guardianAddress','$bankName', '$bankBranchName', 
        '$accountHolderName', '$accountNumber','$target_file5','$accountType', '$ifscCode',
        '$micrCode', '$bankAddress', '$aadharNo','$target_file6','$panCardNo',
        '$target_file7', '$scholarshipType','$emisNumber', '$umisNumber', '$abcCerditNumber', 
        '$target_file17', '$tenthMark', '$target_file1', '$twelfthMark', '$target_file9',
        '$diploma', '$diplomaCollege', '$diplomaCourse','$diplomaPercentage','$target_file13', 
        '$target_file14','$Ug', '$UgCollege', '$UgCourse', '$UgDegree', '$UgPercentage',
        '$target_file16', '$target_file15', '$tcNo', '$target_file10','$tenthPercentage',
        '$twelfthPercentage', '$doteManagement','$quota', '$tneaRanking','$communityRanking',
        '$cutoff','$TenthschoolName', '$TwelvethschoolName',  '$sportName', '$sportslevel',
        '$achievements', '$certifications', '$target_file', '$sportsQuotaPercentage', '$drivingKnown', 
        '$licenseNumber', '$issueOffice', '$lanuageKnown', '$RelativeStuding', '$StdName', 
        '$StdDegree', '$StdDepartment', '$StdYear', '$RelativeStaff', '$StaffName', 
        '$StaffWorking'
    )";
echo $sql;
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


$conn->close();

?>
