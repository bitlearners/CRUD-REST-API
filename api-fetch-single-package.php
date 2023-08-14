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
      pkg.PID,
      pkg.CID,
      pkg.PTitle,
      pkg.slug as pkg_slug,
      pkg.key_img1,
      pkg.key_img_alt1,
      pkg.key_img2,
      pkg.key_img_alt2,
      pkg.key_img3,
      pkg.key_img_alt3,
      pkg.key_img4,
      pkg.key_img_alt4,
      pkg.banner1,
      pkg.temp,
      pkg.banner_alt1,
      pkg.banner2,
      pkg.banner_alt2,
      pkg.banner3,
      pkg.banner_alt3,
      pkg.banner4,
      pkg.banner_alt4,
      cat.CID,
      cat.CName,
      cat.slug AS category_slug,
      cat.CImg,
      cat.CAlt,
      cat.front,
      cat.state_city,
      pd.PDID,
      pd.Title AS package_title,
      pd.Content,
      pd.Price,
      pd.Date,
      pd.Duration
  FROM
      pkg_for_himalayan pkg   
  JOIN category cat ON
      pkg.CID = cat.CID
  JOIN package_details pd ON
      pkg.PID = pd.PID
  WHERE
  pkg.slug = '$slug'";

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
