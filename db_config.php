<?php



// Replace 'your_host', 'your_username', 'your_password', and 'your_database' with actual credentials.
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'himalayan';

// Establish a connection to the database
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

?>