<?php   

// Database connection details
include("con.php");

// Create connection
//$conn =  mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

   $id=$_POST["h_sid"];

   $date = $_POST["date"];
   $reason = $conn->real_escape_string($_POST["reason"]);
   $leaveletter = isset($_FILES['leaveletter']) ? $_FILES['leaveletter'] : null;



   //leave letter
   $target_dir = "uploads/";
   $target_file3 = $target_dir . basename($_FILES["ip_leave"]["name"]);
   echo ($_FILES["ip_leave"]["name"]);
   //echo $_POST["name"];
   move_uploaded_file($_FILES["ip_leave"]["tmp_name"],$target_file3);


   $sql = "INSERT INTO `leaverecord`(`sid`,`date`, `reason`, `leaveletter`) 
   VALUES ('$id','$date','$reason','$target_file3')";

   
   if ($conn->query($sql) === TRUE) {
    echo "Record Submitted Successfully";
   } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>