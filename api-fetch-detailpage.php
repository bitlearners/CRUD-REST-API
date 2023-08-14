<?php
//protip==use GET method in postman api

header("content-type: application/json"); //return json data

header("Access-Control-Allow-Origin: *");   //koi bhi website aur mobile app access kr skti hai

header("Access-Control-Allow-Mehtods: POST, GET"); 

//X-Requested-With ==jo bhi value esko mile wo sirf ajax ke through ayegi restriction laga di hai
header("Access-Control-Allow-Headers:Access-Control-Allow-Mehtods,Content-Type,Access-Control-Allow-Mehtods,Authorization,X-Requested-With");


// Connect to your MySQL database (Replace with your actual database credentials)
include "db_config.php";

// Fetch data from page and detailpage tables using a join
$sql = "SELECT PAGE.Page_Id,
PAGE.Page_Name,
PAGE.Page_Content,
PAGE.Page_Img,
PAGE.Page_Slug,
PAGE.Date,
detailpage.Key_name,
detailpage.Key_value,
detailpage.Img AS Detail_Img,
detailpage.Img_Alt,
detailpage.Designation,
detailpage.Fname,
detailpage.Finfo,
detailpage.Fimg,
detailpage.Falt,
detailpage.A_IMG
FROM PAGE
LEFT JOIN detailpage ON PAGE.Page_Id = detailpage.Page_Id
WHERE PAGE.Page_Slug = 'about-us'";


$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Close the connection
$conn->close();

// Set response headers
header("Content-Type: application/json");

// Output the fetched data as JSON
echo json_encode($data);


?>
