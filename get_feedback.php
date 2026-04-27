<?php
header("Content-Type: application/json");
include 'db.php';

// Fetch all feedbacks from the database
$sql = "SELECT * FROM feedbacks ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

$feedbacks = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $feedbacks[] = $row;
    }
}

// Return the data as JSON [cite: 18, 30]
echo json_encode($feedbacks);
?>