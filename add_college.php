<?php
include('db_online.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];

    $sql = "INSERT INTO colleges (name) VALUES ('$name')";

    if ($conn->query($sql) === TRUE) {
        echo "New college added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
