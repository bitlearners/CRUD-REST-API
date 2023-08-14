<?php
//protip==use GET method in postman api

header("content-type: application/json"); //return json data

header("Access-Control-Allow-Origin: *");   //koi bhi website aur mobile app access kr skti hai

header("Access-Control-Allow-Mehtods: POST, GET"); 

//X-Requested-With ==jo bhi value esko mile wo sirf ajax ke through ayegi restriction laga di hai
header("Access-Control-Allow-Headers:Access-Control-Allow-Mehtods,Content-Type,Access-Control-Allow-Mehtods,Authorization,X-Requested-With");


include "config.php";

$sql="
SELECT 
    bo.Best_id,
    bo.BName,
    bo.Bimg,
    bo.slug AS best_slug,
    bo.BAlt,
    bop.place_id,
    bop.CID AS place_CID,
    bop.PID AS place_PID,
    pkg.PID AS pkg_PID,
    pkg.CID AS pkg_CID,
    pkg.PTitle,
    pkg.slug AS pkg_slug,
    pkg.banner1,
    pkg.banner_alt1,
    pkg.temp
FROM
    best_of bo
JOIN
    best_of_place bop ON bo.Best_id = bop.Best_id
JOIN
    pkg_for_himalayan pkg ON bop.PID = pkg.PID

WHERE
    bo.Best_id = '4'";




$result=mysqli_query($conn,$sql) or die("SQL Query Failed");

if(mysqli_num_rows($result) > 0){
  $output=mysqli_fetch_all($result,MYSQLI_ASSOC);
  echo json_encode($output);
}else{
  echo json_encode(array("message"=> "No Records Found","status"=> FALSE));
}
