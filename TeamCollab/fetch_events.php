<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit();
}

$userId = $_SESSION['user_id'];

// Debugging: Check the user ID
error_log("User ID: " . $userId);

// Fetch events for the logged-in user
$sql = "SELECT id, event_name FROM events WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

// Debugging: Check the fetched events
error_log(print_r($events, true));

echo json_encode($events);
$conn->close();
?>
