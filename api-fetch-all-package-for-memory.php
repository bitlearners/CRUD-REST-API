<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include "config.php";

// Check if the slug is present in the URL
if (isset($_GET['slug'])) {
  // Retrieve the slug from the URL and sanitize it
  $slug = trim($_GET['slug']);
  $slug = mysqli_real_escape_string($conn, $slug);

  // Prepare the SQL statement to fetch data from the 'blog' table based on the slug
  $sql = "

SELECT
    *
FROM
    pkg_for_himalayan
JOIN category ON pkg_for_himalayan.CID = category.CID
WHERE
    `category`.`slug` = '$slug'";


  // Execute the SQL query
  $result = $conn->query($sql);

  // Check if there are results
  if ($result->num_rows > 0) {
    // Fetch all the data from the result set as an array of associative arrays
    $data = []; 
    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
    }

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
