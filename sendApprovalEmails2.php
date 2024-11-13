<?php
// Load Composer's autoloader for PHPMailer
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database connection (adjust your credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event"; // Replace with your database name

try {
    // Create a new PDO instance for database connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to select approved events
    $eventStmt = $pdo->prepare("SELECT event_name FROM events WHERE status = 'approved'");
    $eventStmt->execute();
    $approvedEvents = $eventStmt->fetchAll(PDO::FETCH_ASSOC);

    // If there are approved events, notify all users
    if ($approvedEvents) {
        // Get all users
        $userStmt = $pdo->prepare("SELECT email FROM users");
        $userStmt->execute();
        $users = $userStmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $user) {
            foreach ($approvedEvents as $event) {
                // Check if notification has already been sent
                if (!notificationExists($pdo, $user['email'], $event['event_name'])) {
                    sendApprovalEmail($user['email'], $event['event_name']);
                    recordNotification($pdo, $user['email'], $event['event_name']);
                }
            }
        }
    } else {
        echo "No approved events found.";
    }

    // Query to select rejected events
    $rejectedStmt = $pdo->prepare("SELECT event_name, email FROM events WHERE status = 'rejected'");
    $rejectedStmt->execute();
    $rejectedEvents = $rejectedStmt->fetchAll(PDO::FETCH_ASSOC);

    // Notify users about rejected events
    foreach ($rejectedEvents as $event) {
        if (!notificationExists($pdo, $event['email'], $event['event_name'])) {
            sendRejectionEmail($event['email'], $event['event_name']);
            recordNotification($pdo, $event['email'], $event['event_name']);
        }
    }

} catch (PDOException $e) {
    echo 'Database Error: ' . $e->getMessage();
}

// Function to check if a notification has already been sent
function notificationExists($pdo, $email, $eventName) {
    $stmt = $pdo->prepare("SELECT * FROM event_notifications WHERE user_email = :email AND event_name = :eventName");
    $stmt->execute(['email' => $email, 'eventName' => $eventName]);
    return $stmt->fetch() !== false; // Return true if a record exists
}

// Function to record a notification in the database
function recordNotification($pdo, $email, $eventName) {
    $stmt = $pdo->prepare("INSERT INTO event_notifications (user_email, event_name) VALUES (:email, :eventName)");
    $stmt->execute(['email' => $email, 'eventName' => $eventName]);
}

// Function to send an approval email using PHPMailer
function sendApprovalEmail($email, $eventName) {
    $mail = new PHPMailer(true);

    try {
        // Server settings (using your college email SMTP configuration)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'bijay.077bca005@acem.edu.np';
        $mail->Password   = 'wildanimals@2021';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('bijay.077bca005@acem.edu.np', 'Event Management System');
        $mail->addAddress($email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'New Event Organized';
        $mail->Body    = "<p>New event <strong>{$eventName}</strong> is going to be organized. Please check the website for more details.</p>";
        $mail->AltBody = "New event '{$eventName}' is going to be organized. Please check the website for more details.";

        // Send the email
        $mail->send();
        echo "Email sent to {$email} for event '{$eventName}'.<br>";
    } catch (Exception $e) {
        echo "Email could not be sent to {$email}. Mailer Error: {$mail->ErrorInfo}<br>";
    }
}

// Function to send a rejection email
function sendRejectionEmail($email, $eventName) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'bijay.077bca005@acem.edu.np';
        $mail->Password   = 'wildanimals@2021';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('bijay.077bca005@acem.edu.np', 'Event Management System');
        $mail->addAddress($email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Event Rejection Notice';
        $mail->Body    = "<p>We regret to inform you that the event <strong>{$eventName}</strong> has been rejected. Please contact support for more information.</p>";
        $mail->AltBody = "We regret to inform you that the event '{$eventName}' has been rejected. Please contact support for more information.";

        // Send the email
        $mail->send();
        echo "Rejection email sent to {$email} for event '{$eventName}'.<br>";
    } catch (Exception $e) {
        echo "Email could not be sent to {$email}. Mailer Error: {$mail->ErrorInfo}<br>";
    }
}
// Redirect back to the admin page (you can modify this to fit your page structure)
//header("Location: /eventMgmt/admin/admin.php");