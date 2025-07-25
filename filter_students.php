<?php
include("con.php");

$branch = $_POST['branch'];
$year = $_POST['year'];

$sql = "SELECT s.*, d.branch AS branch_name, y.name AS year_name 
        FROM students s
        LEFT JOIN dept d ON s.branch = d.dept_id
        LEFT JOIN year y ON s.year = y.id
        WHERE 1=1";

if (!empty($branch)) {
    $sql .= " AND s.branch = '$branch'";
}

if (!empty($year)) {
    $sql .= " AND s.year = '$year'";
}

$result = $conn->query($sql);

$output = "";

while ($row = $result->fetch_assoc()) {
    $output .= "<tr>";
    $output .= "<td scope='row'>" . $row['id'] . "</td>";
    $output .= "<td>" . $row['name'] . "</td>";
    $output .= "<td>" . $row['reg_no'] . "</td>";
    $output .= "<td>" . $row['degree'] . "</td>";
    $output .= "<td>" . $row['branch_name'] . "</td>";
    $output .= "<td>" . $row['year_name'] . "</td>";
    $t_id = $row["id"];
    $enrollmentnumber = $row["enrollmentnumber"];
    $output .= "<td><a href='http://localhost/erp/profile.php?enrollmentnumber=" . $enrollmentnumber . "'><img onclick='view(\"" . $t_id . "\")' src='assets/icons/view_ic.png'> </a> <img src='assets/icons/edit_ic.png'> <img onclick='remove(\"" . $t_id . "\")' src='assets/icons/delete_ic.png'></td>";
    $output .= "</tr>";
}

echo $output;
?>