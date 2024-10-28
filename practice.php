

<?php

require_once '/xampp/htdocs/eventMgmt/db/db.php';
$conn=getDB();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if event_id is set in the URL
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Fetch venues from the database
    $venue_sql = "SELECT id, venue_name, capacity, location FROM venues";
    $venue_result = $conn->query($venue_sql);

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

    <!-- Form to assign venue -->
    <form method="post">
        <label for="venue_id">Select Venue:</label>
        <select name="venue_id" id="venue_id" required>
            <option value="">-- Select a Venue --</option>
            <?php
            // Populate the dropdown with venue options
            if ($venue_result->num_rows > 0) {
                while ($venue = $venue_result->fetch_assoc()) {
                    echo "<option value='" . $venue['id'] . "'>";
                    echo $venue['venue_name'] . " (Capacity: " . $venue['capacity'] . ", Location: " . $venue['location'] . ")";
                    echo "</option>";
                }
            } else {
                echo "<option value=''>No venues available</option>";
            }
            ?>
        </select>
        <button type="submit">Assign Venue</button>
        <br> <br>
        
        <button type="button" onclick="window.location.href='http://localhost:8080/eventMgmt/admin/admin.php'">Back to Admin Page</button>
   
        <!-- <p class="back-to-admin"><a href="admin.php">Back to Admin Page</a></p> -->
    </form>

   

</body>
</html>
