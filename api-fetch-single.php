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

$data=json_decode(file_get_contents("php://input"),TRUE); //true pass kregy toh json decode() associative array return krta hai
#php://input ===ye agr request mobileAPP ya desktopApp ya WebApp se ayi hai jo bhi raw data ayega usko read krega chae kon se bi format se ho json ho ya xml
$path = explode('/', $_SERVER['REQUEST_URI']);


if (isset($path[3]) && is_numeric($path[3])){

  $id=$path[3];

  include "config.php";

  $sql="SELECT * FROM blog WHERE BID='{$id}'";

  
  $result=mysqli_query($conn,$sql) or die("SQL Query Failed");
  
  if(mysqli_num_rows($result) > 0){
    $output=mysqli_fetch_all($result,MYSQLI_ASSOC);
    echo json_encode($output);
  }else{
    echo json_encode(array("message"=> "No Records Found","status"=> FALSE));
  }
}
else{
  echo json_encode(array("message"=> "error in url","status"=> FALSE));
  
}





?>
