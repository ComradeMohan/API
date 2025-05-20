<?php
// Set JSON header before any output
header("Content-Type: application/json");

// Support both GET and POST
$student_number = $_GET["student_number"] ?? ($_POST["student_number"] ?? '');
$password = $_GET["password"] ?? ($_POST["password"] ?? '');

// Normalize input
$student_number = trim($student_number);
$password = trim($password);

// Route based on prefix
if (strpos($student_number, "19") === 0) {
    include("student_login.php");
} else if (stripos($student_number, "sse") === 0) {
    include("faculty_login.php");
} else if (stripos($student_number, "admin") === 0) {
    include("admin_login.php");
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid user type"
    ]);
}
?>
