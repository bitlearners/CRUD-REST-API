<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "db_config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate the received data
    if (empty($_POST["E_Name"]) || empty($_POST["Mobile_No"]) || empty($_POST["Email"])) {
        echo json_encode(array("status" => "error", "message" => "Required fields are missing."));
        exit;
    }

    $E_Name = $_POST["E_Name"];
    $Mobile_No = $_POST["Mobile_No"];
    $Email = $_POST["Email"];
    $Date = $_POST["Date"];
    $People = $_POST["People"];
    $E_msg = $_POST["E_msg"];
    $Slug = $_POST["Slug"];

    // Set a time limit for script execution
    set_time_limit(30); // 30 seconds

    // Use prepared statements to insert data into the database
    $stmt = $conn->prepare("INSERT INTO enquire (E_Name, Mobile_No, Email, Date, People, E_msg, Slug) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiss", $E_Name, $Mobile_No, $Email, $Date, $People, $E_msg, $Slug);

    if ($stmt->execute()) {
        echo json_encode(array("status" => "success", "message" => "Enquiry added successfully"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Failed to add enquiry: " . $stmt->error));
    }

    $stmt->close();
}

$conn->close();
?>
