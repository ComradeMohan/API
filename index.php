<?php
header("Content-Type: application/json");

echo json_encode([
    "success" => true,
    "message" => "PHP is running successfully on Render!",
    "timestamp" => date("Y-m-d H:i:s")
]);
?>
