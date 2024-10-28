<?php
session_start(); // Start the session

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection parameters
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "event"; // Replace with your database name

// Check if user has submitted an event idea
$email = $_SESSION['email'];
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user has submitted an event
$sql = "SELECT * FROM events WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $email);
$stmt->execute();
$result = $stmt->get_result();

// If the user hasn't submitted an event, redirect to an error or access denied page
if ($result->num_rows === 0) {
    header("Location: access_denied.php"); // Redirect to an appropriate error page
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management Team Collaboration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Event Management Team Collaboration</h1>

        <!-- Team Overview Section -->
        <div class="team-section">
            <h2>Team Members</h2>
            <ul id="teamList"></ul> <!-- This will be populated dynamically -->
        </div>

        <!-- Task Management Section -->
        <div class="task-section">
            <h2>Task Management</h2>
            <ul id="taskList">
                <!-- Tasks can be dynamically updated -->
            </ul>
            <form id="taskForm" method="POST" action="add_task.php">
                <input type="text" id="taskInput" name="task" placeholder="New task..." required>
                <button type="submit">Add Task</button>
            </form>
        </div>

        <!-- Chat Box Section -->
        <div class="chat-section">
            <h2>Team Chat</h2>
            <div id="chatBox" class="chat-box">
                <!-- Chat messages will appear here -->
            </div>
            <form id="chatForm" method="POST" action="send_message.php">
                <input type="text" id="chatInput" name="message" placeholder="Type a message..." required>
                <button type="submit">Send</button>
            </form>
        </div>
    </div>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const event_id = urlParams.get('event_id');

        // Fetch and display team members
        function fetchTeamMembers() {
            fetch(`add_member.php?event_id=${event_id}`)
            .then(response => response.json())
            .then(data => {
                let teamList = document.getElementById('teamList');
                teamList.innerHTML = ''; // Clear existing members
                data.forEach(member => {
                    let listItem = document.createElement('li');
                    listItem.innerHTML = `<strong>${member.fname} ${member.lname}</strong> - ${member.role}`;
                    teamList.appendChild(listItem);
                });
            });
        }

        // Call this function on page load
        window.onload = fetchTeamMembers;

        // Chat Auto-Refresh Logic (You can customize the timing)
        function fetchMessages() {
            fetch(`fetch_messages.php?event_id=${event_id}`)
            .then(response => response.json())
            .then(data => {
                let chatBox = document.getElementById('chatBox');
                chatBox.innerHTML = ''; // Clear chat box
                data.forEach(message => {
                    let chatMessage = document.createElement('div');
                    chatMessage.innerHTML = `<strong>${message.sender}</strong>: ${message.text}`;
                    chatBox.appendChild(chatMessage);
                });
            });
        }

        // Call fetchMessages on load and set an interval for refreshing chat
        window.onload = function() {
            fetchTeamMembers();
            fetchMessages();
            setInterval(fetchMessages, 5000); // Refresh chat every 5 seconds
        };
    </script>
</body>
</html>
