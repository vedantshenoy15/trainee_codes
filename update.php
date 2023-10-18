<?php
// Create a connection to the MySQL database
$conn = new mysqli("localhost:3306", "root", "vedant", "test");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ip_address = $_POST["ip_add"];
    $mac_address = $_POST["mac_address"];
    // Add code to retrieve and sanitize other form fields as needed

    // Create an SQL query to update the database
    $sql = "UPDATE network_info SET mac_address = '$mac_address' WHERE ip_add = '$ip_address'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
