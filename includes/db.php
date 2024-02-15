<?php
// Database credentials
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "rentals";

// Create a database connection
$connection = mysqli_connect($host, $dbUsername, $dbPassword, $dbName);

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>