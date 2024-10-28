<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
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

// Fetch events from the database
$sql = "SELECT id, event_name FROM events";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch form inputs
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $event = $_POST['event'];
    $comments = $_POST['comments'];

    // Debugging: Check if form data is being captured
    // echo "<pre>";
    // echo "Form Data:\n";
    // print_r($_POST);
    // echo "</pre>";
    // die();

    // Check if any field is empty
    if (empty($name) || empty($email) || empty($phone) || empty($event) || empty($comments)) {
        echo "Error: All fields are required!";
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO registrations (full_name, email, phone, event, comments, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        
        if (!$stmt) {
            // Debugging: Check if the prepared statement failed
            echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        } else {
            // Bind parameters
            $stmt->bind_param("sssss", $name, $email, $phone, $event, $comments);
            
            // Debugging: Check if bind_param worked correctly
            if ($stmt->error) {
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            
            // Execute the statement
            if ($stmt->execute()) {
                echo "Registration successful!";
            } else {
                // Debugging: Check the SQL execution result
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Participation</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Event Registration</h1>
        <form id="registrationForm"  method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required>
                <small>Phone number should be exactly 10 digits</small>
            </div>
            <div class="form-group">
                <label for="event">Event</label>
                <select id="event" name="event" required>
                    <option value="">Select an event</option>
                    <?php
                    // Check if there are results from the events query
                    if ($result->num_rows > 0) {
                        // Output data for each event
                        while($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['id'] . '">' . $row['event_name'] . '</option>';
                        }
                    } else {
                        echo '<option value="">No events available</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="comments">Share Your Interest</label>
                <textarea id="comments" name="comments" rows="4"></textarea>
            </div>
            <button type="submit">Participate</button>
        </form>
        <p id="message"></p>
    </div>
    <!-- <script src="scripts.js"></script> -->
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
