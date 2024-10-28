<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in and message is set
if (!isset($_SESSION['user_id']) || !isset($_POST['message'], $_POST['event_id'])) {
    echo "Unauthorized access.";
    exit;
}

$userId = $_SESSION['user_id'];
$eventId = $_POST['event_id'];
$message = htmlspecialchars($_POST['message']);

// Insert chat message into the database
$sql = "INSERT INTO chats (user_id, event_id, message) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $userId, $eventId, $message);

if ($stmt->execute()) {
    header("Location: chatbox.php?event_id=" . $eventId);
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>
