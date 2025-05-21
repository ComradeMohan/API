<?php
header('Content-Type: application/json');
include('db_online.php');

$result = $conn->query("SELECT id, name FROM colleges");

$colleges = [];
while ($row = $result->fetch_assoc()) {
    $colleges[] = $row;
}

echo json_encode(["success" => true, "colleges" => $colleges]);
$conn->close();
?>
