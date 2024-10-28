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

// Check if user is logged in and event ID is provided
if (!isset($_SESSION['user_id']) || !isset($_GET['event_id'])) {
    echo "Unauthorized access.";
    exit;
}

$userId = $_SESSION['user_id'];
$eventId = $_GET['event_id'];

// Fetch event details and chat messages
$sql = "SELECT e.event_name, u.first_name, u.last_name 
        FROM events e 
        JOIN event_member em ON e.id = em.event_id 
        JOIN users u ON em.id = u.user_id 
        WHERE e.id = ? AND em.id = ? OR e.user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $eventId, $userId, $userId);
$stmt->execute();
$result = $stmt->get_result();
$eventDetails = $result->fetch_assoc();

if (!$eventDetails) {
    echo "Event not found.";
    exit;
}

$eventName = htmlspecialchars($eventDetails['event_name']);
//fetching the data which is chat from the database
$chatSql = "SELECT DISTINCT c.message, u.first_name, u.last_name 
            FROM chats c 
            JOIN event_member em ON c.user_id = em.id 
            JOIN users u ON em.id = u.user_id
            WHERE c.event_id = ? 
            ORDER BY c.created_at ASC";

$chatStmt = $conn->prepare($chatSql);
$chatStmt->bind_param("i", $eventId);
$chatStmt->execute();
$chats = $chatStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $eventName; ?> Chat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="chat-container">
        <h2>Chat for <?php echo $eventName; ?></h2>
        <div id="chatBox" class="chat-box">
            <?php while ($chat = $chats->fetch_assoc()): ?>
                <div class="chat-message">
                    <strong><?php echo htmlspecialchars($chat['first_name'] . ' ' . $chat['last_name']); ?></strong>: 
                    <?php echo htmlspecialchars($chat['message']); ?>
                </div>
            <?php endwhile; ?>
        </div>

        <form action="send_message.php" method="POST">
            <input type="hidden" name="event_id" value="<?php echo $eventId; ?>">
            <input type="hidden" name="event_member_id" value="<?php echo $userId; ?>">
            <input type="text" name="message" placeholder="Type your message..." required>
            <button type="submit">Send</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
