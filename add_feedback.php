<?php
header("Content-Type: application/json");
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    $sql = "INSERT INTO feedbacks (name, subject, message) VALUES ('$name', '$subject', '$message')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["status" => "success", "message" => "Feedback saved!"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}
?>