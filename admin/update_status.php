<?php
require_once '/xampp/htdocs/eventMgmt/db/db.php';
$conn= getDB();
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

    //check if the status is  rejected or not 
    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        if ($new_status === 'rejected') {
            // Fetch the host's email from the event
            $query = "SELECT u.email 
                      FROM users u
                      JOIN events e ON u.id = e.user_id 
                      WHERE e.id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('i', $event_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $host_email = $row['email'];
                $subject = "Event Rejected Notification";
                $message = "Dear host,\n\nWe regret to inform you that your event has been rejected.\n\nRegards,\nEvent Management Team";
                $headers = "From: bijay.077bca005@acem.edu.np"; // Replace with your system's email

                // Send email to the host
                mail($host_email, $subject, $message, $headers);
            }
        }

        // Redirect back to the previous page or admin panel
        header("Location: admin_panel.php?status_updated=1");

        echo "Event status updated successfully!";
    } else {
        echo "Error updating status: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
}

// Close the connection
$conn->close();

// Redirect back to the admin page (you can modify this to fit your page structure)
header("Location: admin.php");
exit();
?>
