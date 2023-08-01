<?php

header("Content-Type: application/json");       //return json data
header("Access-Control-Allow-Origin: *");       //koi bhi website aur mobile app access kr skti hai
header("Access-Control-Allow-Mehtods: POST");   //insert ke liye post method chalega

//Authorization=koi bhi mobile app person authorization esko easily access kr sakti hai
//X-Requested-With ==jo bhi value esko mile wo sirf ajax ke through ayegi restriction laga di hai
header("Access-Control-Allow-Headers:Access-Control-Allow-Mehtods,Content-Type,Access-Control-Allow-Mehtods,Authorization,X-Requested-With");

/*{   Suppose ye values ayi hain ajax se
	"sname": "Prince",
	"sage":"24",
	"scity":"ferozepur"
}*/






if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $BName = $_POST['BName'];
  $Content = $_POST['Content'];
  $image = $_FILES['image'];
  $BAlt = $_POST['BAlt'];
  $CID = $_POST['CID'];

  $targetDir = "http://localhost/himalayan/uploads/";
  $targetFile = $targetDir . basename($image['name']);

  // Move the uploaded image file to the desired directory
  if (move_uploaded_file($image['tmp_name'], $targetFile)) {
    // Establish a connection to the MySQL database
	$conn = new mysqli('localhost', 'root', '', 'himalayan');


    // Check if the connection was successful
    if ($conn->connect_error) {
      die('Connection failed: ' . $conn->connect_error);
    }

    // Prepare the SQL statement with parameter placeholders
    $sql = 'INSERT INTO form_data (BName, Content, Image, BAlt, CID) VALUES (?, ?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);

    // Bind the form data and image path to the prepared statement parameters
    $stmt->bind_param('ssssi', $BName, $Content, $targetFile, $BAlt, $CID);

    // Execute the prepared statement
    if ($stmt->execute()) {
      // Process the form data and perform necessary actions
      // ...
      // Return a response if needed


	  echo json_encode(array("message" => "Student Record Inserted", "status" => TRUE));
	} else {
		echo json_encode(array("message" => $sql, "status" => FALSE));

    
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
  } else {
    echo 'Failed to upload image.';
  }
}
