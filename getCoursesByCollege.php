<?php
header("Content-Type: application/json");

include('db_online.php');

$college = $_GET["college"];

$sql = "SELECT course_code, subject_name, faculty_name FROM courses WHERE college = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $college);
$stmt->execute();

$result = $stmt->get_result();

$courses = [];

while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}

echo json_encode(["success" => true, "courses" => $courses]);

$stmt->close();
$conn->close();
?>
