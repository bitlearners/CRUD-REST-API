<?php
header("Content-Type: application/json");       // Return JSON data
header("Access-Control-Allow-Origin: *");       // Allow requests from any website or mobile app
header("Access-Control-Allow-Methods: POST");   // Allow only POST method for inserting data

// Access-Control-Allow-Headers: Allow certain headers for proper authorization and restrictions
header("Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

// Connect to your MySQL database (Replace with your actual database credentials)
$host = "localhost";
$username = "root";
$password = "";
$database = "himalayan";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection  failed: " . $conn->connect_error);
}

// API endpoint to add a new package
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["image"])) {
    // Handle form data from the React application
    $PTitle = $_POST["PTitle"];
    $slug = $_POST["slug"];
    $key_img1 = $_POST["key_img1"];
    $key_img_alt1 = $_POST["key_img_alt1"];
    $key_img2 = $_POST["key_img2"];
    $key_img_alt2 = $_POST["key_img_alt2"];
    $key_img3 = $_POST["key_img3"];
    $key_img_alt3 = $_POST["key_img_alt3"];
    $key_img4 = $_POST["key_img4"];
    $key_img_alt4 = $_POST["key_img_alt4"];
    $banner1 = $_POST["banner1"];
    $temp = $_POST["temp"];
    $banner_alt1 = $_POST["banner_alt1"];
    $banner2 = $_POST["banner2"];
    $banner_alt2 = $_POST["banner_alt2"];
    $banner3 = $_POST["banner3"];
    $banner_alt3 = $_POST["banner_alt3"];
    $banner4 = $_POST["banner4"];
    $banner_alt4 = $_POST["banner_alt4"];

    // Handle the image upload and store its path in the database
    $image = $_FILES["image"];
    $targetDir = "uploads/"; // Replace with the actual path to your image folder
    $targetFile = $targetDir . basename($image["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowedExtensions = array("jpg", "jpeg", "png", "gif");

    if (in_array($imageFileType, $allowedExtensions)) {
        if (move_uploaded_file($image["tmp_name"], $targetFile)) {
            $imagePath = $targetFile;
            $fullImagePath = 'http://localhost/himalayan/' . $imagePath;

            // Insert the package data into the database
            $sql = "INSERT INTO pkg_for_himalayan (PTitle, slug, key_img1, key_img_alt1, key_img2, key_img_alt2, key_img3, key_img_alt3, key_img4, key_img_alt4, banner1, temp, banner_alt1, banner2, banner_alt2, banner3, banner_alt3, banner4, banner_alt4)
                    VALUES ('$PTitle', '$slug', '$key_img1', '$key_img_alt1', '$key_img2', '$key_img_alt2', '$key_img3', '$key_img_alt3', '$key_img4', '$key_img_alt4', '$banner1', '$temp', '$banner_alt1', '$banner2', '$banner_alt2', '$banner3', '$banner_alt3', '$banner4', '$banner_alt4')";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(array("status" => "success", "message" => "Package added successfully"));
            } else {
                echo json_encode(array("status" => "error", "message" => "Failed to add package: " . $conn->error));
            }
        } else {
            echo json_encode(array("status" => "error", "message" => "Failed to upload image."));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "Invalid image format. Allowed formats: " . implode(", ", $allowedExtensions)));
    }
}

// Close the database connection
$conn->close();
?>
