<?php

header("Content-Type: application/json");       //return json data
header("Access-Control-Allow-Origin: *");       //allow requests from any origin
header("Access-Control-Allow-Methods: POST");   //allow only POST method for this API

//Authorization: allow authorization from any mobile app or client
//X-Requested-With: restrict this API to be accessed only through AJAX requests
header("Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "db_config.php";

// API endpoint to add a new page
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["Page_Img"])) {
    $Page_Name = $_POST["Page_Name"];
    $Page_Content = $_POST["Page_Content"];
    $Page_Slug = $_POST["Page_Slug"];

    // Handle the image upload and store its path in the database
    $image = $_FILES["Page_Img"];
    $targetDir = "uploads/"; // Replace with the actual path to your image folder
    $targetFile = $targetDir . basename($image["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowedExtensions = array("jpg", "jpeg", "png", "gif");

    if (in_array($imageFileType, $allowedExtensions)) {
        if (move_uploaded_file($image["tmp_name"], $targetFile)) {
            $imagePath = $targetFile;
            $fullImagePath = 'http://localhost/himalayan/' . $imagePath;

            // Use prepared statements to insert data into the database
            $stmt = $conn->prepare("INSERT INTO page (Page_Name, Page_Content, Page_Img, Page_Slug) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $Page_Name, $Page_Content, $fullImagePath, $Page_Slug);

            if ($stmt->execute()) {
                echo json_encode(array("status" => "success", "message" => "Page added successfully"));
            } else {
                echo json_encode(array("status" => "error", "message" => "Failed to add page: " . $stmt->error));
            }

            $stmt->close();
        } else {
            echo json_encode(array("status" => "error", "message" => "Failed to upload image."));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "Invalid image file. Allowed file types: jpg, jpeg, png, gif"));
    }
}

// Close the database connection
$conn->close();

?>
