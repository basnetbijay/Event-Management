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
    $mail = new PHPMailer(true);  // Create a new instance of PHPMailer

    try {
        // Server settings (using your college email SMTP configuration)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';               // SMTP server (Gmail)
        $mail->SMTPAuth   = true;                           // Enable SMTP authentication
        $mail->Username   = 'bijay.077bca005@acem.edu.np'; // Your college email
        $mail->Password   = 'wildanimals@2021';             // Your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port       = 587;                            // TCP port (587 for TLS)

        // Recipients
        $mail->setFrom('bijay.077bca005@acem.edu.np', 'Event Management System'); // Sender's email and name
        $mail->addAddress($email);   // Add the recipient's email

        // Email content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'New Event Organized'; // Subject of the email
        $mail->Body    = "
            <p>New event <strong>{$eventName}</strong> is going to be organized. Please check the website for more details.</p>
        ";
        $mail->AltBody = "New event '{$eventName}' is going to be organized. Please check the website for more details.";

        // Send the email
        $mail->send();
        echo "Email sent to {$email} for event '{$eventName}'.<br>";
    } catch (Exception $e) {
        echo "Email could not be sent to {$email}. Mailer Error: {$mail->ErrorInfo}<br>";
    }
}
