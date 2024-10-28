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
    echo "You must be logged in to view messages.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['event_id'])) {
        $event_id = $_GET['event_id'];
        $stmt = $pdo->prepare("SELECT users.fname, users.lname, messages.message 
                               FROM messages 
                               JOIN users ON messages.user_id = users.id 
                               WHERE messages.event_id = ? 
                               ORDER BY messages.created_at ASC");
        $stmt->execute([$event_id]);
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($messages);
    }
}
?>
