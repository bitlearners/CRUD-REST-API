<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


// header("Content-Type: application/json");       //return json data
// header("Access-Control-Allow-Origin: *");       //koi bhi website aur mobile app access kr skti hai
// header("Access-Control-Allow-Mehtods: GET");   //insert ke liye post method chalega

// //Authorization=koi bhi mobile app person authorization esko easily access kr sakti hai
// //X-Requested-With ==jo bhi value esko mile wo sirf ajax ke through ayegi restriction laga di hai
// header("Access-Control-Allow-Headers:Access-Control-Allow-Mehtods,Content-Type,Access-Control-Allow-Mehtods,Authorization,X-Requested-With");

//{"sid": "1"} suppose manlo is format me data aya hoga
//json format me jo data ayega uske liye



  include "config.php";
// Check if the slug is present in the URL
if (isset($_GET['slug'])) {
  // Retrieve the slug from the URL and sanitize it
  $slug = trim($_GET['slug']);
  $slug = mysqli_real_escape_string($conn, $slug);

  // Prepare the SQL statement to fetch data from the 'blog' table based on the slug
  $sql = "SELECT * FROM page WHERE Page_Slug = '$slug' LIMIT 1";

  // $sql="SELECT b.*, c.CName FROM blog b LEFT JOIN category c ON b.CID = c.CID WHERE slug = '$slug' LIMIT 1";

  // Execute the SQL query
  $result = $conn->query($sql);

  // Check if there are results
  if ($result->num_rows > 0) {
      // Fetch the data from the result set as an associative array
      $data = $result->fetch_assoc();

      // Close the connection
      $conn->close();

      // Encode the data as JSON and print it
      header('Content-Type: application/json');
      echo json_encode($data);
  } else {
      // No data found for the given slug
      // Close the connection
      $conn->close();

      // Return an error response as JSON
      header('Content-Type: application/json');
      echo json_encode(array("error" => "No data found for the given slug"));
  }
} else {
  // Slug parameter is not provided in the URL
  // Close the connection
  $conn->close();

  // Return an error response as JSON
  header('Content-Type: application/json');
  echo json_encode(array("error" => "Slug parameter is not provided in the URL"));
}


?>
