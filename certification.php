<?php

include("con.php");
$type=$_POST["h_t"];
$id=$_POST["h_sid"];
$category=$_POST["category"];
$description=$_POST["description"];
$attach_files = isset($_FILES['ip_certificate']) ? $_FILES['ip_certificate'] : null;
if($attach_files){
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["ip_certificate"]["name"]);
echo ($_FILES["ip_certificate"]["name"]);
//echo $_POST["name"];
move_uploaded_file($_FILES["ip_certificate"]["tmp_name"],$target_file);
}
$sql="INSERT INTO `certificate`(`sid`, `category`, `description`, `attach_files`, `type`) 
VALUES ('$id','$category','$description','$target_file','$type')";
$conn->query($sql);




?>