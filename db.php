<?php
$host = "localhost";    // Your database host (usually localhost)
$user = "root";         // Your database username
$password = "";          // Your database password
$dbname = "ecommerce"; // Your database name

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>