<?php
//protip==use GET method in postman api

header("content-type: application/json"); //return json data

header("Access-Control-Allow-Origin: *");   //koi bhi website aur mobile app access kr skti hai

header("Access-Control-Allow-Mehtods: POST, GET"); 

//X-Requested-With ==jo bhi value esko mile wo sirf ajax ke through ayegi restriction laga di hai
header("Access-Control-Allow-Headers:Access-Control-Allow-Mehtods,Content-Type,Access-Control-Allow-Mehtods,Authorization,X-Requested-With");


include "../config.php";    

$sql="SELECT * FROM explore";



$result=mysqli_query($conn,$sql) or die("SQL Query Failed");

if(mysqli_num_rows($result) > 0){
  $output=mysqli_fetch_all($result,MYSQLI_ASSOC);
  echo json_encode($output);
}else{
  echo json_encode(array("message"=> "No Records Found","status"=> FALSE));
}
?>
