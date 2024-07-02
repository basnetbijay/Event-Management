<?php
require_once '../db/db.php';
require_once '../utils/auth.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isLoggedIn()) {
    header("Location: /src/loginsignup/login.php");
    exit();
}

$conn = getDB();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    $update_query = $conn->prepare("UPDATE Users SET email = ?, first_name = ?, last_name = ? WHERE user_id = ?");
    $update_query->bind_param("sssi", $email, $first_name, $last_name, $user['user_id']);

    if ($update_query->execute()) {
        $_SESSION['email'] = $email; // Update the email in session
        header("Location: profile.php?view=profile&success=1");
        exit();
    } else {
        $error = "Failed to update information.";
    }
}

$conn->close();
?>