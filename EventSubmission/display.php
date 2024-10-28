<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "event"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch events
$sql = "SELECT * FROM events ORDER BY created_at DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submitted Events</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <h1>Submitted Events</h1>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card">
                    <div class="card-header"><?php echo htmlspecialchars($row["event_name"]); ?></div>
                    <div class="card-content">
                        <img src="<?php echo htmlspecialchars($row["event_picture"]); ?>" alt="Event Picture">
                        <p><?php echo htmlspecialchars($row["event_description"]); ?></p>
                        <p><strong>Date:</strong> <?php echo date('F j, Y', strtotime($row["created_at"])); ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No events found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
