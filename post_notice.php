<?php
// Database connection
include('db_online.php');
// Get POST data
$title = isset($_POST['title']) ? $_POST['title'] : '';
$details = isset($_POST['details']) ? $_POST['details'] : '';
$college = isset($_POST['college']) ? $_POST['college'] : '';
$schedule_date = isset($_POST['schedule_date']) ? $_POST['schedule_date'] : null;
$schedule_time = isset($_POST['schedule_time']) ? $_POST['schedule_time'] : null;
$attachment = isset($_POST['attachment']) ? $_POST['attachment'] : null;
$is_high_priority = ($is_high_priority === 'true' || $is_high_priority === 1) ? 1 : 0;


// Validate mandatory fields
if (empty($title) || empty($details)) {
    echo json_encode(["status" => "error", "message" => "Title and Details are mandatory!"]);
    exit;
}

// Insert into the database
$sql = "INSERT INTO notices (title, description, college, schedule_date, schedule_time, attachment, is_high_priority)
        VALUES ('$title', '$details', '$college', '$schedule_date', '$schedule_time', '$attachment', $is_high_priority)";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Notice posted successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error posting notice: " . $conn->error]);
}

$conn->close();
?>
