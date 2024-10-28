<?php

require_once '/xampp/htdocs/eventMgmt/db/db.php';
$conn = getDB();
session_start();
if ($_SESSION['email'] !== 'admin@gmail.com') {
    header("Location: ../src/loginsignup/login.php");
    exit();
}
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if event_id is set in the URL
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Fetch event category
    // Fetch event date for the current event
$event_sql = "SELECT category, event_date FROM events WHERE id = ?";
$stmt_event = $conn->prepare($event_sql);
$stmt_event->bind_param("i", $event_id);
$stmt_event->execute();
$stmt_event->bind_result($event_category, $event_date);
$stmt_event->fetch();
$stmt_event->close();

// Fetch venues that match the event category and are available on the event date
$venue_sql = "
    SELECT v.id, v.venue_name, v.capacity, v.location 
    FROM venues v
    WHERE v.category = ? 
    AND NOT EXISTS (
        SELECT 1 
        FROM events e 
        WHERE e.venue_id = v.id 
        AND e.event_date = ?
    )
    ORDER BY v.capacity DESC, v.location ASC"; // Sort by capacity first, then location
$stmt_venues = $conn->prepare($venue_sql);
$stmt_venues->bind_param("ss", $event_category, $event_date); // Bind both category and event_date
$stmt_venues->execute();
$venue_result = $stmt_venues->get_result();


    // Greedy algorithm to recommend the best venue
    $recommended_venue = null;
    if ($venue_result->num_rows > 0) {
        while ($venue = $venue_result->fetch_assoc()) {
            // If no venue has been assigned yet or if the current venue is better
            if ($recommended_venue === null || $venue['capacity'] > $recommended_venue['capacity']) {
                $recommended_venue = $venue;
            }
        }
    }

    // Check if the form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $venue_id = $_POST['venue_id']; // Get the selected venue_id from the form

        // Prepare and bind an SQL statement to update the venue_id for the event
        $stmt = $conn->prepare("UPDATE events SET venue_id = ? WHERE id = ?");
        $stmt->bind_param("ii", $venue_id, $event_id);

        // Execute the query and check if it was successful
        if ($stmt->execute()) {
            echo "Venue assigned successfully!";
        } else {
            echo "Error assigning venue: " . $conn->error;
        }

        // Close the statement and connection
        $stmt->close();

        // Redirect back to the admin page (optional)
        header("Location: admin.php");
        exit();
    }
} else {
    echo "No event ID provided.";
}

// Close the connection after use
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Venue</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Assign Venue to Event</h1>

    <!-- Recommended Venue Display -->
    <?php if ($recommended_venue): ?>
        <h2>Recommended Venue:</h2>
        <p><?php echo htmlspecialchars($recommended_venue['venue_name']); ?> 
            (Capacity: <?php echo htmlspecialchars($recommended_venue['capacity']); ?>, 
            Location: <?php echo htmlspecialchars($recommended_venue['location']); ?>)
        </p>
    <?php endif; ?>

    <!-- Form to assign venue -->
    <form method="post">
        <label for="venue_id">Select Venue:</label>
        <select name="venue_id" id="venue_id" required>
            <option value="">-- Select a Venue --</option>
            <?php
            // Reset the result pointer and populate the dropdown with venue options based on category
            $venue_result->data_seek(0); // Reset the result set
            if ($venue_result->num_rows > 0) {
                while ($venue = $venue_result->fetch_assoc()) {
                    echo "<option value='" . $venue['id'] . "'>";
                    echo $venue['venue_name'] . " (Capacity: " . $venue['capacity'] . ", Location: " . $venue['location'] . ")";
                    echo "</option>";
                }
            } else {
                echo "<option value=''>No suitable venues available</option>";
            }
            ?>
        </select>
        <button type="submit">Assign Venue</button>
        <br><br>
        
        <button type="button" onclick="window.location.href='http://localhost:8080/eventMgmt/admin/admin.php'">Back to Admin Page</button>
    </form>
</body>
</html>
