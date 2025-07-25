<?php

// Database connection details
include("con.php");


if (isset($_GET["id"])){
    $id=$_GET["id"];

    

    //create connection
  
    $sql = "DELETE FROM students WHERE id=$id";
    $conn -> query($sql);

}

header("location: /erp/stutable.php");
?>