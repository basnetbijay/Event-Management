<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$status = isset($_GET['status']) ? $_GET['status'] : '';

// Fetch the latest event details
$sql = "SELECT event_name, event_description, event_picture FROM events ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);
$event = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Event Idea</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Submit Your Event Idea</h1>
        <?php if ($status == 'success'): ?>
            <div class="message success">Your event has been submitted successfully!</div>
        <?php elseif ($status == 'error'): ?>
            <div class="message error">There was an error submitting your event. Please try again.</div>
        <?php endif; ?>
        
        <form action="submiti.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="event-name">Event Name:</label>
                <input type="text" id="event-name" name="eventName" required>
            </div>
            <div class="form-group">
                <label for="event-description">Event Description:</label>
                <textarea id="event-description" name="eventDescription" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="event-picture">Upload Event Picture:</label>
                <input type="file" id="event-picture" name="eventPicture" accept="image/*" required>
            </div>
            <button type="submit">Submit Idea</button>
        </form>
    </div>

    <?php if ($event): ?>
        <div class="container">
            <div class="card">
                <div class="card-header"><?php echo htmlspecialchars($event['event_name']); ?></div>
                <div class="card-content">
                    <img src="<?php echo htmlspecialchars($event['event_picture']); ?>" alt="Event Picture">
                    <p><?php echo nl2br(htmlspecialchars($event['event_description'])); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</body>
</html>
