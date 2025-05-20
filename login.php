<?php
// Set JSON header before any output
header("Content-Type: application/json");

// Only accept POST method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode([
        "success" => false,
        "message" => "Only POST requests are allowed"
    ]);
    exit();
}

// Read JSON input from request body
$input = json_decode(file_get_contents('php://input'), true);

// Validate input presence
if (empty($input['student_number']) || empty($input['password'])) {
    http_response_code(400); // Bad Request
    echo json_encode([
        "success" => false,
        "message" => "Missing student_number or password"
    ]);
    exit();
}

$student_number = trim($input['student_number']);
$password = trim($input['password']);

// Route login based on student_number prefix
if (strpos($student_number, "19") === 0) {
    include("student_login.php");
} else if (stripos($student_number, "sse") === 0) {
    include("faculty_login.php");
} else if (stripos($student_number, "admin") === 0) {
    include("admin_login.php");
} else {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Invalid user type"
    ]);
    exit();
}
?>
