<?php
require_once '../db/db.php';
require_once '../utils/auth.php';
require_once '../utils/getFuncs.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isLoggedIn()) {
    header("Location: /src/loginsignup/login.php");
    exit();
}

$conn = getDB();
$user = getUser($conn, $_SESSION['email']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    $update_query = $conn->prepare("UPDATE Users SET email = ?, first_name = ?, last_name = ? WHERE user_id = ?");
    $update_query->bind_param("sssi", $email, $first_name, $last_name, $user['user_id']);

    if ($update_query->execute()) {
        $_SESSION['email'] = $email; // Update the email in session
        header("Location: profile.php?success=1");
        exit();
    } else {
        $error = "Failed to update information.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile - ThriftIt</title>
    <link rel="stylesheet" type="text/css" href="/includes/styles.css">
    <style>
        body {
            background: url('/images/app/backgroundlogin.jpg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
            overflow: hidden;
            height: 100vh;
        }
    </style>
</head>

<body>
    <?php require_once '../includes/header.php'; ?>
    <div class="profile-container">
        <div class="profile-box">
            <h2>Your Profile</h2>
            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <?php if (isset($_GET['success'])): ?>
                <div class="success-message">Profile updated successfully.</div>
            <?php endif; ?>
            <div class="profile-content">
                <div class="profile-picture">
                    <img src="/images/app/default-profile.svg" alt="User Profile Picture">
                    <button class="btn upload-btn">Upload New Picture</button>
                </div>
                <div class="profile-form">
                    <form action="profile.php" method="post">
                        <div class="textbox">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                        <div class="textbox">
                            <label for="first_name">First Name:</label>
                            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                        </div>
                        <div class="textbox">
                            <label for="last_name">Last Name:</label>
                            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                        </div>
                        <button type="submit" class="btn">Update Profile</button>
                    </form>
                    <a href="/src/loginsignup/logout.php" class="logout-btn">Logout</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
