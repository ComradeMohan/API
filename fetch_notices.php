<?php
// Database connection
include('db_online.php');

// Get college parameter from GET request
$college = isset($_GET['college']) ? $_GET['college'] : '';

// Validate that 'college' is not empty
if (empty($college)) {
    echo json_encode(["status" => "error", "message" => "College parameter is required."]);
    exit;
}

// SQL query to fetch notices by college
$sql = "SELECT title, description, schedule_date, schedule_time, is_high_priority 
        FROM notices 
        WHERE college = ? 
        ORDER BY schedule_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $college); // Bind the college parameter

// Execute the query
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Prepare an array to hold the notices
$notices = array();

if ($result->num_rows > 0) {
    // Fetch each row of the result and add to the notices array
    while ($row = $result->fetch_assoc()) {
        $notices[] = $row;
    }
    // Return the notices as a JSON response
    echo json_encode($notices);
} else {
    // No notices found for the given college
    echo json_encode(["status" => "error", "message" => "No notices found for the specified college."]);
}

// Close the connection
$stmt->close();
$conn->close();
?>
