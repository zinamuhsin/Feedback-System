<?php

$servername = "localhost";
$username = "root";
$password = "1221"; 
$dbname = "feedback_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . mysqli_connect_error()]));
}
?>