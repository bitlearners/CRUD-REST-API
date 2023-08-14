<?php

header("PDuration-Type: application/json");       //return json data
header("Access-Control-Allow-Origin: *");       //koi bhi website aur mobile app access kr skti hai
header("Access-Control-Allow-Mehtods: POST");   //insert ke liye post method chalega

//Authorization=koi bhi mobile app person authorization esko easily access kr sakti hai
//X-Requested-With ==jo bhi value esko mile wo sirf ajax ke through ayegi restriction laga di hai
header("Access-Control-Allow-Headers:Access-Control-Allow-Mehtods,PDuration-Type,Access-Control-Allow-Mehtods,Authorization,X-Requested-With");


include "db_config.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the form data
    $PTitle = $_POST["PTitle"];
    $slug = $_POST["slug"];
    $CID = $_POST["CID"];
    $temp = $_POST["temp"];
    $key_img_alt1 = $_POST["key_img_alt1"];
    $key_img_alt2 = $_POST["key_img_alt2"];
    $key_img_alt3 = $_POST["key_img_alt3"];
    $key_img_alt4 = $_POST["key_img_alt4"];
    $banner_alt1 = $_POST["banner_alt1"];
    $banner_alt2 = $_POST["banner_alt2"];
    $banner_alt3 = $_POST["banner_alt3"];
    $banner_alt4 = $_POST["banner_alt4"];
   
    

// Retrieve the file data from $_FILES array
$key_img1 = $_FILES["key_img1"]["name"];
$key_img_tmp1 = $_FILES["key_img1"]["tmp_name"];
$key_img2 = $_FILES["key_img2"]["name"];
$key_img_tmp2 = $_FILES["key_img2"]["tmp_name"];
$key_img3 = $_FILES["key_img3"]["name"];
$key_img_tmp3 = $_FILES["key_img3"]["tmp_name"];
$key_img4 = $_FILES["key_img4"]["name"];
$key_img_tmp4 = $_FILES["key_img4"]["tmp_name"];

$banner1 = $_FILES["banner1"]["name"];
$banner_tmp1 = $_FILES["banner1"]["tmp_name"];
$banner2 = $_FILES["banner2"]["name"];
$banner_tmp2 = $_FILES["banner2"]["tmp_name"];
$banner3 = $_FILES["banner3"]["name"];
$banner_tmp3 = $_FILES["banner3"]["tmp_name"];
$banner4 = $_FILES["banner4"]["name"];
$banner_tmp4 = $_FILES["banner4"]["tmp_name"];

// Similarly, retrieve other file inputs in a similar way

// Move the uploaded files to a permanent location

move_uploaded_file($key_img_tmp1, "uploads/" . $key_img1);
move_uploaded_file($key_img_tmp2, "uploads/" . $key_img2);
move_uploaded_file($key_img_tmp3, "uploads/" . $key_img3);
move_uploaded_file($key_img_tmp4, "uploads/" . $key_img4);

move_uploaded_file($banner_tmp1, "uploads/" . $banner1);
move_uploaded_file($banner_tmp2, "uploads/" . $banner2);
move_uploaded_file($banner_tmp3, "uploads/" . $banner3);
move_uploaded_file($banner_tmp4, "uploads/" . $banner4);
// Similarly, move other files to their respective directories

$img1 = 'http://localhost/himalayan/uploads/' . $key_img1;
$img2 = 'http://localhost/himalayan/uploads/' . $key_img2;
$img3 = 'http://localhost/himalayan/uploads/' . $key_img3;
$img4 = 'http://localhost/himalayan/uploads/' . $key_img4;

$bnrimg1 = 'http://localhost/himalayan/uploads/' . $banner1;
$bnrimg2 = 'http://localhost/himalayan/uploads/' . $banner2;
$bnrimg3 = 'http://localhost/himalayan/uploads/' . $banner3;
$bnrimg4 = 'http://localhost/himalayan/uploads/' . $banner4;


   // Perform validation if needed
    if (empty($key_img_alt1)) {
    $response = array("status" => "error", "message" => "Key Features Image Alt 1 is required.");
    echo json_encode($response);
    exit; // Stop further execution
}
      // Perform validation if needed
      if (empty($key_img_alt2)) {
        $response = array("status" => "error", "message" => "Key Features Image Alt 2 is required.");
        echo json_encode($response);
        exit; // Stop further execution
    }

      // Perform validation if needed
      if (empty($key_img_alt3)) {
        $response = array("status" => "error", "message" => "Key Features Image Alt 3 is required.");
        echo json_encode($response);
        exit; // Stop further execution
    }

      // Perform validation if needed
      if (empty($key_img_alt4)) {
        $response = array("status" => "error", "message" => "Key Features Image Alt 4 is required.");
        echo json_encode($response);
        exit; // Stop further execution
    }




    // Insert the data into the database
    $sql = "INSERT INTO Pkg_for_himalayan  (PTitle, slug, CID, temp, key_img1, key_img_alt1, key_img2, key_img_alt2, key_img3, key_img_alt3, key_img4, key_img_alt4, banner1, banner_alt1, banner2, banner_alt2, banner3, banner_alt3, banner4, banner_alt4)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the parameters and execute the statement
    $stmt->bind_param(
        "ssssssssssssssssssss",
        $PTitle,
        $slug,
        $CID,
        $temp,
        $img1,
        $key_img_alt1,
        $img2,
        $key_img_alt2,
        $img3,
        $key_img_alt3,
        $img4,
        $key_img_alt4,
        $bnrimg1,
        $banner_alt1,
        $bnrimg2,
        $banner_alt2,
        $bnrimg3,
        $banner_alt3,
        $bnrimg4,
        $banner_alt4
    );
    

    if ($stmt->execute()) {
        // Database insertion was successful
        $response = array("status" => "success", "message" => "Package added successfully!");
        echo json_encode($response);
    } else {
        // Database insertion failed
        $response = array("status" => "error", "message" => "Failed to add package. Please try again later.");
        echo json_encode($response);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}


?>