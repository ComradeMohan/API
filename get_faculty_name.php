<?php
header("Content-Type: application/json");

include('db_online.php');

$facultyId = $_GET['facultyId']; // Get student ID from URL

// Fetch student data by ID
$sql = "SELECT name,college FROM faculty_new WHERE login_id = '$facultyId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $faculty_name = $result->fetch_assoc();
    echo json_encode(["success" => true, "college" => $faculty_name["college"],"name" => $faculty_name["name"]]);
} else {
    echo json_encode(["success" => false, "message" => "Student not found"]);
}

$conn->close();
?>
