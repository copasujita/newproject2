<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ems_db";

$conn = new mysqli($host, $user, $pass, $dbname);

// कनेक्शन चेक करें
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>