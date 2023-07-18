<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

$method = $_SERVER['REQUEST_METHOD'];
switch($method) {

case "POST":
    // this is fo create
    $user = json_decode( file_get_contents('php://input') );
    $sql = "INSERT INTO blog(`BID`, `CID`, `BName`, `BDate`, `BlogBy`, `BDetail`, `BImg`, `BAlt`) VALUES(null, :BID, :CID, :mobile, :BName, :BDate, :BlogBy, :BDetail , :BImg, :BAlt )";
    $stmt = $conn->prepare($sql);
   
    
    $stmt->bindParam(':CID', $user->CID);
    $stmt->bindParam(':BName', $user->BDate);
    $stmt->bindParam(':BName', $user->$BName);
    $stmt->bindParam(':BDate', $user->$BDate);
    $stmt->bindParam(':BlogBy', $user->$BlogBy);
    $stmt->bindParam(':BDetail', $user->$BDetail);
    $stmt->bindParam(':BImg', $user->$BImg);
    $stmt->bindParam(':BAlt', $user->$BAlt);
    


    if($stmt->execute()) {
        $response = ['status' => 1, 'message' => 'Record created successfully.'];
    } else {
        $response = ['status' => 0, 'message' => 'Failed to create record.'];
    }
    echo json_encode($response);
    break;
}

?>