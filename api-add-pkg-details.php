<?php

header("Content-Type: application/json");       //return json data
header("Access-Control-Allow-Origin: *");       //koi bhi website aur mobile app access kr skti hai
header("Access-Control-Allow-Mehtods: POST");   //insert ke liye post method chalega

//Authorization=koi bhi mobile app person authorization esko easily access kr sakti hai
//X-Requested-With ==jo bhi value esko mile wo sirf ajax ke through ayegi restriction laga di hai
header("Access-Control-Allow-Headers:Access-Control-Allow-Mehtods,Content-Type,Access-Control-Allow-Mehtods,Authorization,X-Requested-With");


include "config.php";


// Assuming you have already established a conn to your MySQL database

// Get the title, content, image, Price, and PID from the request body
$title = $_POST['title'];
$content = $_POST['content'];

$Price = $_POST['Price'];
$PID = $_POST['PID'];
$Duration = $_POST['Duration'];



// Insert the blog into the MySQL database
$query = "INSERT INTO `package_details` (`PID`, `Title`, `Content`, `Price`,  `Duration`) VALUES ('$PID', '$title', '$content', '$Price', '$Duration')";
$result = mysqli_query($conn, $query);

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