<?php
include('db_online.php');
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['college_name'])) {
        echo json_encode(["success" => false, "message" => "college_name is required"]);
        exit();
    }

    $college_name = $_POST['college_name'];

    $query = "SELECT id FROM colleges WHERE TRIM(LOWER(name)) = TRIM(LOWER(?))";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $college_name);
    $stmt->execute();
    $stmt->bind_result($college_id);  // ✅ use variable with $

    if ($stmt->fetch()) {
        echo json_encode(["success" => true, "college_id" => $college_id]);
    } else {
        echo json_encode(["success" => false, "message" => "College not found"]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>
