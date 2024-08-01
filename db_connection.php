<?php
// Database configuration
$db_host = 'localhost';     // Usually 'localhost' if your database is on the same server
$db_name = 'allapp';   // The name of your database
$db_user = 'root'; // Your MySQL username
$db_pass = ''; // Your MySQL password

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
