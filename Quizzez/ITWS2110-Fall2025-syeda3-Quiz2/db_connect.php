<?php
$servername = "localhost";
$username = "root";
$password = ""; // default for XAMPP
$dbname = "ITWS2110_Fall2025_syeda3_Quiz2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

