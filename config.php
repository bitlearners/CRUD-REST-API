<?php




$servername = "localhost";  // Rep  lace with your MySQL server hostname
$username = "root";        // Replace with your MySQL username
$password = "";    // Replace with your MySQL password
$database = "himalayan"; // Replace with your MySQL database name



// Create a conn
$conn = mysqli_connect($servername, $username, $password, $database);

// Check if the conn was successful
if (!$conn) {
    die("conn failed: " . mysqli_connect_error());
}


?>