<?php
require_once '/xampp/htdocs/eventMgmt/db/db.php';
 // Include the file for sending approval emails
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

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_id = $_POST['event_id']; // Get the event ID from the form
    $status = $_POST['status'];     // Get the selected status from the form

    // Prepare and bind an SQL statement to update the status
    $stmt = $conn->prepare("UPDATE events SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $event_id);
    $stmt->execute();

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
         echo "Event status updated successfully!";
         require '/xampp/htdocs/eventMgmt/sendApprovalEmails2.php';
    } else {
        echo "Error updating status: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
}




$conn->close();


exit();
?>
