<?php

$print = false;
require_once __DIR__ . '/homework_user_exists.php';

$response = array();

if($user_exists) {
    include "../INCLUDE/sqllogin.php";
    
    $result;
    if(isset($_GET["all"])) {
        $result = mysqli_query($conn, "SELECT * FROM `_HOMEWORK_ENTRYS`;");
    } else {
        $result = mysqli_query($conn, "SELECT * FROM `_HOMEWORK_ENTRYS` WHERE ID NOT IN ( SELECT HOMEWORK_ID FROM `_HOMEWORK_ENTRYS_DONE` WHERE USER_ID = $user_id) AND CLASS_ID = $user_class_id;");
    }
    
    $response["entrys"] = array();
    while($row = mysqli_fetch_assoc($result)) {
        $entry = array();
        $entry["ID"] = $row["ID"];
        $entry["SUBJECT"] = $row["SUBJECT"];
        $entry["MEDIA"] = $row["MEDIA"];
        $entry["PAGE"] = $row["PAGE"];
        $entry["NUMBERS"] = $row["NUMBERS"];
        $entry["UNTIL"] = $row["UNTIL"];
        
        array_push($response["entrys"], $entry);
    }
    
    echo json_encode($response);
}

?>