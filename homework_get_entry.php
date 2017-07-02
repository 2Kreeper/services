<?php

$print = false;
require_once __DIR__ . '/homework_user_exists.php';

$response = array();

if($user_exists && isset($_GET["id"])) {
    $id = $_GET["id"];
    include "../INCLUDE/sqllogin.php";
    
    $result = mysqli_query($conn, "SELECT * FROM `_HOMEWORK_ENTRYS` WHERE ID = '$id';");
    
    if($result && $row = mysqli_fetch_assoc($result)) {
        $response["success"] = 1;
        $response["message"] = "The entry with ID '$id' has been successfully requested!";
        
        $response["ID"] = $row["ID"];
        $response["SUBJECT"] = $row["SUBJECT"];
        $response["MEDIA"] = $row["MEDIA"];
        $response["PAGE"] = $row["PAGE"];
        $response["NUMBERS"] = $row["NUMBERS"];
        $response["UNTIL"] = $row["UNTIL"];
    } else {
        $response["success"] = 0;
        $response["message"] = mysqli_error($conn);
    }
    
} else {
    $response["success"] = 0;
    $response["message"] = "User does not exist or 'id' has not been provided!";
}

echo json_encode($response);

?>