<?php
header("Content-Type: application/json");

include('db_online.php');

$college = $_GET['college'];

// Prepare SQL to fetch courses based on college
$sql = "SELECT course_code, subject_name, strength FROM courses WHERE college = '$college'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $courses = [];
    while ($row = $result->fetch_assoc()) {
        $courses[] = [
            "course_code" => $row["course_code"],
            "subject_name" => $row["subject_name"],
            "strength" => $row["strength"]
        ];
    }
    echo json_encode(["success" => true, "courses" => $courses]);
} else {
    echo json_encode(["success" => false, "message" => "No courses found"]);
}

$conn->close();
?>
