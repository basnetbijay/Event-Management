<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$userId = $_SESSION['user_id'] ?? null; // Use null coalescing operator to avoid undefined variable notice

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

// Fetch user email from session
$user_id = $_SESSION['user_id'];
$userEmail = $_SESSION['email'] ?? null;
if (!$userEmail) {
    // Redirect if the email isn't set
    header("Location: login.php"); // Change to your login page
    exit();
}

if ($_POST) {
    $eventName = htmlspecialchars($_POST['eventName']);
    $eventCategory = htmlspecialchars($_POST['eventCategory']);
    $eventDescription = htmlspecialchars($_POST['eventDescription']);
    $eventDate = $_POST['eventDate']; 
    $eventPicture = $_FILES['eventPicture'];

    // Validate inputs
    if (empty($eventName) || empty($eventDescription) || empty($eventCategory) || empty($eventPicture['name'])) {
        header("Location: index.php?status=error&msg=Invalid input");
        exit();
    }

    // File upload handling
    $targetDir = "uploads/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    $targetFile = $targetDir . basename($eventPicture["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a real image
    $check = getimagesize($eventPicture["tmp_name"]);
    if ($check === false) {
        $uploadOk = 0;
    }

    // Check file size
    if ($eventPicture["size"] > 500000) { // 500KB
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        $uploadOk = 0;
    }

    // Check if upload is allowed
    if ($uploadOk == 0) {
        header("Location: index.php?status=error&msg=File upload failed");
        exit();
    } else {
        // Move file to target directory
        if (move_uploaded_file($eventPicture["tmp_name"], $targetFile)) {
            // Insert the event details into the events table
            $sql = "INSERT INTO events (user_id, event_name, email, event_description, event_date, category, event_picture, created_at, status) 
            VALUES (?, ?, ?, ?, ?,?, ?, NOW(), 'pending')";
            $stmt = $conn->prepare($sql);
            
            // Use only the file name here, not the entire array
            $eventPictureName = 'uploads/' . $eventPicture['name'];
            $stmt->bind_param("issssss", $user_id, $eventName, $userEmail, $eventDescription, $eventDate, $eventCategory, $eventPictureName);

            if (!$stmt->execute()) {
                // Fetch error for debugging
                header("Location: index.php?status=error&msg=" . $stmt->error);
                exit();
            } else {
                // Get the event ID of the newly inserted event
                $eventId = $stmt->insert_id;
               
                // Insert the user as the host in the event_member table
                $sql_member = "INSERT INTO event_member (id, event_id, email, role, responsibility) VALUES (?, ?, ?, 'Host', ?)";
                $stmt_member = $conn->prepare($sql_member);
                $responsibility = "Host of the Event"; // Set the responsibility as needed
                $stmt_member->bind_param("iiss", $userId, $eventId, $userEmail, $responsibility); 
        
                if (!$stmt_member->execute()) {
                    // Handle error if the insert fails
                    header("Location: index.php?status=error&msg=" . $stmt_member->error);
                    exit();
                }
        
                // Close the statement for event_member
                $stmt_member->close();
        
                // Redirect to the landing page after successful insertion
                header("Location: http://localhost:8080/eventMgmt/landing/index.php?status=success");
                exit();
            }
        } else {
            header("Location: index.php?status=error&msg=Failed to move uploaded file");
            exit();
        }
    }
}

$conn->close();

?>
