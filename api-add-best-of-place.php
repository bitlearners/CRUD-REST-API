<?php
header("PDuration-Type: application/json");       //return json data
header("Access-Control-Allow-Origin: *");       //koi bhi website aur mobile app access kr skti hai
header("Access-Control-Allow-Mehtods: POST");   //insert ke liye post method chalega

//Authorization=koi bhi mobile app person authorization esko easily access kr sakti hai
//X-Requested-With ==jo bhi value esko mile wo sirf ajax ke through ayegi restriction laga di hai
header("Access-Control-Allow-Headers:Access-Control-Allow-Mehtods,PDuration-Type,Access-Control-Allow-Mehtods,Authorization,X-Requested-With");


// Assuming you have a MySQL database, replace the database credentials below

include "db_config.php";
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $CID = $_POST["categoryId"];
    $Best_id = $_POST["best_of_id"];
    $PID = $_POST["package_id"];

    // Perform SQL insertion based on your table structure
    // Assuming you have a table called "places" with columns: ID, Category, BestOfID, PackageID
    $sql = "INSERT INTO best_of_place (PID, CID, Best_id) VALUES ('$PID', '$CID', '$Best_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
