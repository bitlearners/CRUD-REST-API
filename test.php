<?php

header("Content-Type: application/json");       //return json data
header("Access-Control-Allow-Origin: *");       //koi bhi website aur mobile app access kr skti hai
header("Access-Control-Allow-Mehtods: POST");   //insert ke liye post method chalega

//Authorization=koi bhi mobile app person authorization esko easily access kr sakti hai
//X-Requested-With ==jo bhi value esko mile wo sirf ajax ke through ayegi restriction laga di hai
header("Access-Control-Allow-Headers:Access-Control-Allow-Mehtods,Content-Type,Access-Control-Allow-Mehtods,Authorization,X-Requested-With");



$servername = "localhost";  // Rep  lace with your MySQL server hostname
$username = "root";        // Replace with your MySQL username
$password = "";    // Replace with your MySQL password
$database = "himalayan"; // Replace with your MySQL database name

// Create a connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Connection successful
echo "Connected to the database successfully";

// Perform your database operations here

// Close the connection when done




// Assuming you have already established a connection to your MySQL database

// Get the title, content, image, altTag, and categoryId from the request body
$title = $_POST['BName'];
$content = $_POST['content'];
$image = $_FILES['image']['tmp_name'];
$altTag = $_POST['BAlt'];
$categoryID = $_POST['CID'];
$slug = $_POST['slug'];

// Perform any necessary sanitization or validation of the input data

// Move the uploaded image to a suitable location on your server
$imagePath = 'http://localhost/himalayan/uploads/' . $_FILES['image']['name'];
move_uploaded_file($image, $imagePath);

// Insert the blog into the MySQL database
$query = "INSERT INTO blog (BName, content, image, slug, BAlt, CID) VALUES ('$title', '$content', '$imagePath',  '$slug', '$altTag' , '$categoryID')";
$result = mysqli_query($connection, $query);

if ($result) {
    // Insertion successful
    $response = ['success' => true, 'message' => 'Blog added successfully'];
} else {
    // Insertion failed
    $response = ['success' => false, 'message' => 'Failed to add blog'];
}

// Send the response back to the client as JSON
header('Content-Type: application/json');
echo json_encode($response);
echo json_decode($query );

?>