<?php
// Get the admin_id from the URL
$admin_id = $_GET['admin_id'];

// Database connection
include('db_online.php');

// SQL query to fetch admin details
$sql = "SELECT name, college FROM admins WHERE admin_id = '$admin_id'";
$result = $conn->query($sql);

// Check if admin exists
if ($result->num_rows > 0) {
    // Fetch the data
    $row = $result->fetch_assoc();
    $response = array(
        "name" => $row['name'],
        "college" => $row['college']
    );
    echo json_encode($response);
} else {
    echo json_encode(array("error" => "Admin not found"));
}

$conn->close();
?>
