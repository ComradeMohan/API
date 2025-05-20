<?php
ob_clean();
header('Content-Type: application/json');
error_reporting(0);

include 'db_online.php';

$title = $_POST['title'];
$details = $_POST['description'];
$college = $_POST['college'];
$schedule_date = $_POST['schedule_date'];
$schedule_time = $_POST['schedule_time'];
$attachment = $_POST['attachment'];
$is_high_priority = ($_POST['is_high_priority'] === 'true') ? 1 : 0;

$sql = "INSERT INTO notices (title, description, college, schedule_date, schedule_time, attachment, is_high_priority)
        VALUES ('$title', '$details', '$college', '$schedule_date', '$schedule_time', '$attachment', $is_high_priority)";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Notice posted successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}
?>
