<?php

$response = array();

$user_exists = false;
$user_id = 0;
$user_class_id = 0;

if(isset($_GET["user"]) && isset($_GET["pass"])) {
    $username = $_GET["user"];
    $password = $_GET["pass"];
    
    require_once '../INCLUDE/sqllogin.php';
    
    $result = mysqli_query($conn, "SELECT * FROM `_HOMEWORK_USERS` WHERE username = '$username' AND password = '$password';");
    
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        $user_exists = true;
        $user_id = $row["ID"];
        $user_class_id = $row["CLASS_ID"];
        
        $response["ID"] = $user_id;
        $response["CLASS_ID"] = $user_class_id;
        
        //provide SCHOOL and CLASS
        $result = mysqli_query($conn, "SELECT * FROM `_HOMEWORK_USERS_CLASS` WHERE id = $user_class_id;");
        $row = mysqli_fetch_assoc($result);
        
        $response["SCHOOL"] = $row["SCHOOL"];
        $response["CLASS"] = $row["CLASS"];
        
        $response["success"] = 1;
        $response["message"] = "The user exists!";
    } else {
        //mysqli_num_rows($result) == 0
        $response["success"] = 0;
        $response["message"] = "The user does not exist!";
    }
    
} else {
    $response["success"] = 0;
    $response["message"] = "Parameter 'user' or 'pass' is not set!";
}

if(!isset($print) || $print == true) {
    echo json_encode($response);
}

?>