<?php
header("Content-Type: application/json");       //return json data
header("Access-Control-Allow-Origin: *");       //koi bhi website aur mobile app access kr skti hai
header("Access-Control-Allow-Mehtods: POST");   //insert ke liye post method chalega

//Authorization=koi bhi mobile app person authorization esko easily access kr sakti hai
//X-Requested-With ==jo bhi value esko mile wo sirf ajax ke through ayegi restriction laga di hai
header("Access-Control-Allow-Headers:Access-Control-Allow-Mehtods,Content-Type,Access-Control-Allow-Mehtods,Authorization,X-Requested-With");






if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $BName = $_POST['BName'];
    $content = $_POST['content'];
    $image = $_FILES['image'];
    $BAlt = $_POST['BAlt'];
    $CID = $_POST['CID'];

  $uploadDirectory = 'uploads/';
  $uploadedFile = $uploadDirectory . basename($image['name']);
  move_uploaded_file($image['tmp_name'], $uploadedFile);

  $dbHost = 'localhost';
  $dbUsername = 'root';
  $dbPassword = '';
  $dbName = 'himalayan';



  $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
  if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
  }

  $query = "INSERT INTO blog (BName, content, image, BAlt, CID) VALUES (?, ?, ?, ?, ?)";
  $stmt = $db->prepare($query);
  $stmt->bind_param("sssss", $BName, $content, $uploadedFile, $BAlt, $CID);
  if ($stmt->execute()) {
    $response = ['success' => true, 'message' => 'Blog post saved successfully'];
  } else {
    $response = ['success' => false, 'message' => 'An error occurred while saving the blog post'];
  }

  $stmt->close();
  $db->close();

  header('Content-Type: application/json');
  echo json_encode($response);
} else {
  $response = ['success' => false, 'message' => 'Incomplete form data'];
  header('Content-Type: application/json');
  echo json_encode($response);
}
?>
