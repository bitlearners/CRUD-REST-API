<?php


header("Content-Type: application/json");       //return json data
header("Access-Control-Allow-Origin: *");       //koi bhi website aur mobile app access kr skti hai
header("Access-Control-Allow-Mehtods: POST");   //insert ke liye post method chalega

//Authorization=koi bhi mobile app person authorization esko easily access kr sakti hai
//X-Requested-With ==jo bhi value esko mile wo sirf ajax ke through ayegi restriction laga di hai
header("Access-Control-Allow-Headers:Access-Control-Allow-Mehtods,Content-Type,Access-Control-Allow-Mehtods,Authorization,X-Requested-With");
    
include "db_config.php";
// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $CID = $_POST["CID"];
    $slug = $_POST["slug"];
    $EName = $_POST["EName"];
    $EAlt = $_POST["EAlt"];

    // Handle image upload
    if ($_FILES["Eimg"]["error"] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/explore/"; // Set the directory where you want to store the uploaded images
        $fileName = $targetDir.basename($_FILES["Eimg"]["name"]);
        $targetFilePath =  $fileName;
        

        // Move the uploaded image to the target directory
        if (move_uploaded_file($_FILES["Eimg"]["tmp_name"], $targetFilePath)) {
            $fullImagePath = 'http://localhost/himalayan/' . $targetFilePath;

            // Image upload successful, now insert data into the database

            // Create a prepared statement to insert the data
            $stmt = $conn->prepare("INSERT INTO explore (CID, slug, Eimg, EName, EAlt) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $CID, $slug, $fullImagePath, $EName, $EAlt);

            if ($stmt->execute()) {
                // Data insertion successful
                $response = array(
                    "status" => "success",
                    "message" => "Data inserted successfully into the database.",
                );
                echo json_encode($response);
            } else {
                // Data insertion failed
                $response = array(
                    "status" => "error",
                    "message" => "Failed to insert data into the database.",
                );
                echo json_encode($response);
            }
        } else {
            // Image upload failed
            $response = array(
                "status" => "error",
                "message" => "Failed to upload image.",
            );
            echo json_encode($response);
        }
    } else {
        // Error in image upload
        $response = array(
            "status" => "error",
            "message" => "Error in image upload.",
        );
        echo json_encode($response);
    }
} else {
    // Invalid request method
    $response = array(
        "status" => "error",
        "message" => "Invalid request method.",
    );
    echo json_encode($response);
}
?>
