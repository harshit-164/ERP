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

   $parent_guardian_name = $_POST["parent_guardian_name"];
   $reasonformeeting = $conn->real_escape_string($_POST["reasonformeeting"]);
   $remarks = $conn->real_escape_string($_POST["remarks"]);
   


   $sql = "INSERT INTO `parentsmeeting`(`sid`,`parent_guardian_name`, `reasonformeeting`, `remarks`) 
   VALUES ('$id','$parent_guardian_name','$reasonformeeting','$remarks')";

   
   if ($conn->query($sql) === TRUE) {
    echo "Record Submitted Successfully";
   } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>