<?php

header("PDuration-Type: application/json");       //return json data
header("Access-Control-Allow-Origin: *");       //koi bhi website aur mobile app access kr skti hai
header("Access-Control-Allow-Mehtods: POST");   //insert ke liye post method chalega

//Authorization=koi bhi mobile app person authorization esko easily access kr sakti hai
//X-Requested-With ==jo bhi value esko mile wo sirf ajax ke through ayegi restriction laga di hai
header("Access-Control-Allow-Headers:Access-Control-Allow-Mehtods,PDuration-Type,Access-Control-Allow-Mehtods,Authorization,X-Requested-With");


include "db_config.php";

// API endpoint to add a new package
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["image"])) {
    $PName = $_POST["PName"];
    $PDuration = $_POST["PDuration"];
    $PLocation = $_POST["PLocation"];
    $PHighlight = $_POST["PHighlight"];
    $POverview = $_POST["POverview"];
    $PackPolicyID = $_POST["PackPolicyID"];
    $slug = $_POST["slug"];
    $CID = $_POST["CID"];
    $multiplelocation = isset($_POST["multilocation"]) ? $_POST["multilocation"] : [];

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
            $sql = "INSERT INTO package (PName, PDuration, PLocation, PHighlight, POverview, PackPolicyID, image_path, slug, CID, multiplelocation)
                    VALUES ('$PName', '$PDuration', '$PLocation', '$PHighlight', '$POverview', '$PackPolicyID', '$fullImagePath', '$slug', '$CID', '" . implode(",", $multiplelocation) . "')";

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
