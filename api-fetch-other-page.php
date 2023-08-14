<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include "config.php";

if (isset($_GET['slug'])) {
  $slug = trim($_GET['slug']);
  $slug = mysqli_real_escape_string($conn, $slug);

  $sql = "SELECT PAGE.Page_Id,
  PAGE.Page_Name,
  PAGE.Page_Content,
  PAGE.Page_Img,
  PAGE.Page_Slug,
  detailpage.temp,
  detailpage.Page_Id
FROM PAGE
LEFT JOIN detailpage ON PAGE
  .Page_Id = detailpage.Page_Id
WHERE PAGE
  .Page_Slug = '$slug' ";

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      $data = array(); // Initialize an empty array to store fetched data

      while ($row = $result->fetch_assoc()) {
          $data[] = $row; // Append each row to the data array
      }

      $conn->close();

      header('Content-Type: application/json');
      echo json_encode($data);
  } else {
      $conn->close();

      header('Content-Type: application/json');
      echo json_encode(array("error" => "No data found for the given slug"));
  }
} else {
  $conn->close();

  header('Content-Type: application/json');
  echo json_encode(array("error" => "Slug parameter is not provided in the URL"));
}
?>
