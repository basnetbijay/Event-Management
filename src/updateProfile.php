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

$user_id = $_SESSION['user_id'];
$conn = getDB();
$query = $conn->prepare("SELECT email, first_name, last_name FROM Users WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    $update_query = $conn->prepare("UPDATE Users SET email = ?, first_name = ?, last_name = ? WHERE user_id = ?");
    $update_query->bind_param("sssi", $email, $first_name, $last_name, $user_id);

    if ($update_query->execute()) {
        header("Location: profile.php?success=1");
        exit();
    } else {
        $error = "Failed to update information.";
    }
}
?>