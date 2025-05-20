<?php
header("Content-Type: application/json");

include('db_online.php');

$facultyId = $_GET['facultyId']; // Get faculty login_id from URL

// Fetch all columns for this faculty
$sql = "SELECT * FROM faculty_new WHERE login_id = '$facultyId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $faculty = $result->fetch_assoc(); // fetch full row
    echo json_encode(["success" => true, "data" => $faculty]);
} else {
    echo json_encode(["success" => false, "message" => "Faculty not found"]);
}

$conn->close();
?>
