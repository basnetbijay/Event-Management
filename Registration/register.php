<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//die("hello this is me");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $event = $_POST['event'];
    $comments = $_POST['comments'];

    // Prepare an SQL statement
    $stmt = $conn->prepare("INSERT INTO registrations (full_name, email, phone, event, comments, created_at) 
                            VALUES (?, ?, ?, ?, ?, NOW())");
    
    // Check if preparation is successful
    if ($stmt === false) {
        die('Error preparing the statement: ' . $conn->error);
    }

    // Bind parameters (s = string, i = integer, d = double, b = blob)
    $stmt->bind_param('sssss', $name, $email, $phone, $event, $comments);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        // Print the error if it fails
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

$conn->close();
?>
