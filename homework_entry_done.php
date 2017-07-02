<?php

$print = false;
require_once __DIR__ . '/homework_user_exists.php';

$response = array();

if($user_exists && isset($_GET["homework_id"])) {
    $homework_id = $_GET["homework_id"];
    include "../INCLUDE/sqllogin.php";
    
    if(mysqli_query($conn, "INSERT INTO d0238768.`_HOMEWORK_ENTRYS_DONE` (USER_ID, HOMEWORK_ID) VALUES ('$user_id', '$homework_id') ")) {
        $response["success"] = 1;
        $response["message"] = "User with ID '$user_id' has done homework with ID '$homework_id'!";
    }
} else {
    $response["success"] = 0;
    $response["message"] = "User does not exist or 'homework_id' has not been provided!";
}

echo json_encode($response);

?>