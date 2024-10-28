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

// Check if a new user is logging in
if (isset($_POST['new_login'])) {
    // Clear the session data for the previous user
    session_unset(); 
    session_destroy(); 
    session_start(); // Start a new session
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$status = isset($_GET['status']) ? $_GET['status'] : '';

// Fetch the latest event details
$sql = "SELECT event_name, event_description, event_picture FROM events ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

$event = $result->fetch_assoc();

// If form is submitted, save the event idea
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventName = $_POST['eventName'];
    $eventDescription = $_POST['eventDescription'];
    $eventDate = $_POST['eventDate']; 
    $eventPicture = $_FILES['eventPicture']['name']; // Handle file uploads

    // Save the file to the 'uploads' folder
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["eventPicture"]["name"]);
    move_uploaded_file($_FILES["eventPicture"]["tmp_name"], $target_file);

    // Assume user_id is stored in session
    $user_id = $_SESSION['user_id'];

    // Insert into events table 
     $sql = "INSERT INTO events (user_id, event_name, event_description, event_date, picture, created_at, status) 
            VALUES (?, ?, ?, ?, ?, NOW(), 'pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $user_id, $eventName, $eventDescription, $eventDate, $eventPicture);

    if ($stmt->execute()) {
        header("Location: submit_event.php?status=success");
    } else {
        header("Location: submit_event.php?status=error");
    }

    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Event Idea</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <style>
        /* Inline CSS for quick reference, you can move this to a separate CSS file */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            padding: 20px;
            /* background-color:#6b824a; */
            background: linear-gradient(to right, #598249, #818149);
            color: white;

            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 50px;
        }

        h1 {
            text-align: center;
            color: #01FF70;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        textarea,
        input[type="file"] ,
        input[type="date" i]  {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="date" i] {
            width: 20%;
            padding: 10px;
            margin: 5px 0 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }


        button {
            display: block;
            width: 100%;
            background-color: #7e8049;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .card {
            background-color: #6b824a;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 20px;
        }

        .card-header {
            background-color: #6b824a;
            color: white;
            padding: 10px 20px;
            font-size: 20px;
            font-weight: bold;
        }

        .card-content {
            display: flex;
            align-items: center;
            gap: 20px; /* Space between image and description */
            padding: 20px;
        }

        .card-content img {
            max-width: 50%; /* Adjust this value to make the image smaller */
            height: auto;
            max-height: 300px; /* Adjust this value as needed */
            border-radius: 10px;
        }

        .card-content p {
            color: #333;
            max-width: 50%; /* Ensure the description doesn’t exceed half of the card's width */
            margin: 0;
        }

        .message {
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

       #event-category  {
    
    width: 20%;
            padding: 10px;
            margin: 5px 0 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
}
    </style>
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
    <label for="event-date">Event Date:</label>
    <input type="date" id="event-date" name="eventDate" required>
</div>

            <div class="form-group">
        <label for="event-category">Event Category:</label>
        <select id="event-category" name="eventCategory" required>
    <?php
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'event'); // Update with your database credentials

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch categories from the database
    $sql = "SELECT category_name FROM categories";
    $result = $conn->query($sql);

    // Check if there are categories
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo '<option value="' . htmlspecialchars($row['category_name']) . '">' . htmlspecialchars($row['category_name']) . '</option>';
        }
    } else {
        echo '<option value="">No categories available</option>';
    }

    // Close connection
    $conn->close();
    ?>
</select>

    </div>
            <div class="form-group">
                <label for="event-picture">Upload Event Picture:</label>
                <input type="file" id="event-picture" name="eventPicture" accept="image/*" required>
            </div>
            <button type="submit" >Submit Idea</button>
        </form>
    </div>

    
</body>
</html>
