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

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to send messages.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['event_id'], $_POST['message'])) {
        $event_id = $_POST['event_id'];
        $user_id = $_SESSION['user_id'];
        $message = $_POST['message'];

        $stmt = $pdo->prepare("INSERT INTO messages (event_id, user_id, message) VALUES (?, ?, ?)");
        $stmt->execute([$event_id, $user_id, $message]);

        echo "Message sent!";
    }
}
?>
