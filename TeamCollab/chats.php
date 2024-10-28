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

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to view this page.";
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch events for which the user is a member
$stmt = $conn->prepare("SELECT events.id, events.event_name, events.event_description, events.event_picture 
                         FROM event_member 
                         JOIN events ON event_member.event_id = events.id 
                         WHERE event_member.id = ? ");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Events</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        ul {
    list-style-type: none; /* Remove default bullet points */
    padding: 0; /* Remove padding */
}

li {
    display: flex; /* Use flexbox for layout */
    align-items: center; /* Center items vertically */
    margin: 10px 0; /* Space between list items */
    padding: 10px; /* Padding for each chat item */
    border: 1px solid #ddd; /* Light border */
    border-radius: 8px; /* Rounded corners */
    background-color: #f9f9f9; /* Light background */
    transition: background-color 0.3s; /* Smooth transition */
    text-decoration: none; /* Remove underline */
    color: #333; /* Text color */
}

li:hover {
    background-color: #e7f3ff; /* Change background on hover */
}

li .chat-icon {
    font-size: 24px; /* Size of the chat icon */
    margin-right: 10px; /* Space between icon and text */
    color: #007BFF; /* Color of the chat icon */
}

li a {
    flex: 1; /* Allow text to take up remaining space */
    color: inherit; /* Inherit color from li */
    text-decoration: none; /* Remove underline from links */
}

li a:hover {
    text-decoration: underline; /* Underline on hover for better UX */
}

        </style>
</head>
<body>
    <div class="container">
        <h1>Your Events</h1>
        <ul id="teamList">
        <?php while ($event = $result->fetch_assoc()): ?>
            <li>
                <span class="chat-icon">💬</span>
                <a href="chatbox.php?event_id=<?php echo $event['id']; ?>">
                    <?php echo htmlspecialchars($event['event_name']); ?>
                </a>
            </li>
        <?php endwhile; ?>
    </ul>

    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
