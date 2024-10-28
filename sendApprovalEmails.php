<?php
// Load Composer's autoloader for PHPMailer
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database connection (adjust your credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "";// Replace with your database password

try {
    // Create a new PDO instance for database connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to select users and event details for approved events
    $stmt = $pdo->prepare("
        SELECT u.email, e.event_name 
        FROM users u 
        JOIN events e ON u.user_id = e.user_id
        WHERE e.status = 'approved'
    ");
    $stmt->execute();
    
    // Fetch all approved events with user details
    $approvedUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // If there are approved events, send emails
    if ($approvedUsers) {
        foreach ($approvedUsers as $user) {
            sendApprovalEmail($user['email'], $user['event_name']);
        }
    } else {
        echo "No approved events found.";
    }

} catch (PDOException $e) {
    echo 'Database Error: ' . $e->getMessage();
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
        $mail->Password   = 'wildanimals@2021';          // Your email password
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
