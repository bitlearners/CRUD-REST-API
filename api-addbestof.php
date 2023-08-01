<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

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

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    // BName, Bimg, slug, BAlt

    if (!isset($_POST["slug"]) || !isset($_POST["BName"]) || !isset($_POST["BAlt"]) || !isset($_FILES["Bimg"])) {
        $response = array(
            "status" => "error",
            "message" => "Invalid form data. Please provide all the required fields.",
        );
        echo json_encode($response);
        exit;
    }

    $slug = $_POST["slug"];
    $BName = $_POST["BName"];
    $BAlt = $_POST["BAlt"];

    // Handle image upload
    if ($_FILES["Bimg"]["error"] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES["Bimg"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        // Check file type
        $allowedExtensions = array("webp", "jpg", "jpeg", "png", "avif");
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedExtensions)) {
            $response = array(
                "status" => "error",
                "message" => "Invalid file type. Only webp, jpg, jpeg, png, and avif files are allowed.",
            );
            echo json_encode($response);
            exit;
        }

        // Move the uploaded image to the target directory
        if (move_uploaded_file($_FILES["Bimg"]["tmp_name"], $targetFilePath)) {
            // Image upload successful, now insert data into the database

            // Create a prepared statement to insert the data
            $stmt = $conn->prepare("INSERT INTO best_of (slug, Bimg, BName, BAlt) VALUES (?, ?, ?, ?)");

            // Check for errors in preparing the statement
            if ($stmt === false) {
                $response = array(
                    "status" => "error",
                    "message" => "Error preparing the statement: " . $conn->error,
                );
                echo json_encode($response);
                exit;
            }

            // Bind the parameters to the statement
            $stmt->bind_param("ssss", $slug, $fileName, $BName, $BAlt);

            // Execute the prepared statement
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
                    "message" => "Failed to insert data into the database. Error: " . $stmt->error,
                );
                echo json_encode($response);
            }

            // Close the prepared statement
            $stmt->close();
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
