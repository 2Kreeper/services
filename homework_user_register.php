<?php

$print = false;
require_once __DIR__ . '/homework_user_exists.php';

$response = array();

if(isset($_GET["school"]) && isset($_GET["class"])) { // 'user' and 'password' is already checked by homework_user_exists.php
    $username = $_GET["user"];
    $password = $_GET["pass"];
    $school = $_GET["school"];
    $class = $_GET["class"];
    
    if(!$user_exists) {
        //check if class exists
        include '../INCLUDE/sqllogin.php';
        $result = mysqli_query($conn, "SELECT * FROM `_HOMEWORK_USERS_CLASS` WHERE school = '$school' AND `class` = '$class';");
        if(mysqli_num_rows($result) > 0) {
            //class exists
            $row = mysqli_fetch_assoc($result);
            
            if(create_user($username, $password, $row["ID"])) {
                //success
                $response["success"] = 1;
                $response["message"] = "The user has been created. No need to create a new class.";
            } else {
                //mysqli_error
                $response["success"] = 0;
                $response["message"] = "An mysqli_error occured while creating the user.";
            }
        } else {
            //class does not exist
            if(create_class($school, $class)) {
                //class has been created
                if(create_user($username, $password, get_class_id($school, $class))) {
                    //success
                    $response["success"] = 1;
                    $response["message"] = "The user has been created. Also created a new class.";
                } else {
                    //mysqli_error
                    $response["success"] = 0;
                    $response["message"] = "An mysqli_error occured while creating the user.";
                }
            } else {
                //class has NOT been created
                $response["success"] = 0;
                $response["message"] = "An mysqli_error occured while creating the class.";
            }
        }
    } else {
        $response["success"] = 0;
        $response["message"] = "The user already exists!";
    }
} else {
    $response["success"] = 0;
    $response["message"] = "Parameter 'school' or 'class' is not set!";
}

echo json_encode($response);

function create_user($user, $pass, $class_id) {
    include '../INCLUDE/sqllogin.php';
    $result = mysqli_query($conn, "INSERT INTO `_HOMEWORK_USERS` (USERNAME, PASSWORD, CLASS_ID) VALUES ('$user', '$pass', $class_id)");
    
    return !mysqli_errno($conn);
}

function create_class($scl, $cls) {
    include '../INCLUDE/sqllogin.php';
    $result = mysqli_query($conn, "INSERT INTO d0238768.`_HOMEWORK_USERS_CLASS` (SCHOOL, `CLASS`) VALUES ('$scl', '$cls')");
    
    return !mysqli_errno($conn);
}

function get_class_id($scl, $cls) {
    include '../INCLUDE/sqllogin.php';
    $result = mysqli_query($conn, "SELECT * FROM `_HOMEWORK_USERS_CLASS` WHERE school = '$scl' AND `class` = '$cls';");
    
    if(mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result)["ID"];
    } else {
        return 0;
    }
}

?>