<?php
// Database configuration
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "ems_db"; // Aapke database ka naam

// Connection banana
$conn = mysqli_connect($host, $user, $pass, $db_name);

// Check karein ki connection sahi hai ya nahi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>