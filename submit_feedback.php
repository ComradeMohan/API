<?php
header("Content-Type: application/json");

// --- CONFIGURE YOUR DATABASE HERE ---
include('db_online.php');// <-- Your target database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'] ?? '';
    $feedback = $_POST['feedback'] ?? '';

    if (empty($userId) || empty($feedback)) {
        echo json_encode(["success" => false, "message" => "Missing user ID or feedback"]);
        exit;
    }

    // Connect to the database


    // Optional: sanitize inputs (use prepared statements to prevent SQL injection)
    $stmt = $conn->prepare("INSERT INTO feedbacks (user_id, feedback) VALUES (?, ?)");
    $stmt->bind_param("ss", $userId, $feedback);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Feedback submitted successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to submit feedback"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
