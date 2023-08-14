<?php
// Include the database configuration file
include "config.php";

// Set appropriate headers to allow cross-origin requests
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

// SQL query to fetch data from the Ads table
$sql = "SELECT * FROM Ads";

// Execute the query
$result = mysqli_query($conn, $sql) or die("SQL Query Failed");

if (mysqli_num_rows($result) > 0) {
  // Fetch all the rows as an associative array
  $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
  echo json_encode($output);
} else {
  echo json_encode(array("message" => "No Records Found", "status" => FALSE));
}
?>
