<?php

$print = false;
require_once __DIR__ . '/homework_user_exists.php';

$response = array();

if($user_exists && isset($_GET["subject"]) && isset($_GET["media"]) && isset($_GET["page"]) && isset($_GET["numbers"]) && isset($_GET["until"]) && isset($_GET["class_id"])) {
    $homework_id = $_GET["homework_id"];
    include "../INCLUDE/sqllogin.php";
    
    $subject = $_GET["subject"];
    $media = $_GET["media"];
    $numbers = $_GET["numbers"];
    $page = $_GET["page"];
    $until = $_GET["until"];
    $class_id = $_GET["class_id"];
    
    if(mysqli_query($conn, "INSERT INTO d0238768.`_HOMEWORK_ENTRYS` (SUBJECT, MEDIA, NUMBERS, PAGE, `UNTIL`, CLASS_ID) VALUES ('$subject', '$media', '$numbers', '$page', '$until', '$class_id')")) {
        $response["success"] = 1;
        $response["message"] = "Entry has been successfully created!";
    } else {
        $response["success"] = 0;
        $response["message"] = "An mysql-error occured!";
    }
} else {
    $response["success"] = 0;
    $response["message"] = "User does not exist or 'subject', 'media', 'page, 'numbers', 'until', or 'class_id' is not set!";
}

echo json_encode($response);

?>