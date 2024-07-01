<?php
require_once '/ShwetaProgramming/Thrift_It/db/db.php';
require_once '/ShwetaProgramming/Thrift_It/utils/auth.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/includes/styles.css">
</head>
<body>
    <div class="header">
        <div class="logo">
            <a href="/src/index.php">
                <img src="/images/app/ThriftIt.svg" alt="Thrift Store Logo">
            </a>
        </div>
        <div class="search-bar">
            <form action="search.php" method="get">
                <input type="text" name="query" placeholder="Search for items...">
            </form>
        </div>
        <div class="nav-links">
            <?php if (isLoggedIn()): ?>
                <a href="../src/listProduct.php" class="nav-link sell">Sell for Free</a>
            <?php else: ?>
                <a href="/src/loginsignup/login.php" class="nav-link sell">Sell for Free</a>
            <?php endif;?>
            <span class="divider">|</span>
            <?php if (isLoggedIn()): ?>
                <a href="/src/profile.php" class="nav-link profile">
                    <img src="/images/app/usericon.svg" alt="User Profile Icon" class="profile-icon">
                </a>
            <?php else: ?>
                <a href="/src/loginsignup/signup.php" class="nav-link signup">Sign Up</a>
            <?php endif;?>
        </div>
    </div>
</body>
</html>
