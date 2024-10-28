<?php
require '/xampp/htdocs/eventMgmt/db/db.php';
require_once '/xampp/htdocs/eventMgmt/utils/auth.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/includes/styles.css">
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background-color: #fff;
    color: #000;
}

.header {
    position: sticky;
    top: 0;
    z-index: 1000;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    background-color: #000;
    color: #fff;
}

.logo a {
    display: flex;
    align-items: center;
    text-decoration: none;
}

.logo img {
    max-height: 50px;
}

.search-bar form {
    display: flex;
}

.search-bar input[type="text"] {
    padding: 10px;
    border: none;
    border-radius: 4px;
    width: 600px; /* Increased width for the search bar */
}

.nav-links {
    display: flex;
    gap: 20px;
}

.nav-link {
    margin-left: 10px;
    padding: 10px 20px;
    text-decoration: none;
    color: #fff;
    border: 1px solid #fff;
    border-radius: 5px;
    transition: background-color 0.3s, color 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 40px; 
    box-sizing: border-box;

}

.nav-link.sell {
    background-color: #fff;
    color: #000;
    border: 2px solid #fff;
    position: relative; 
}


.nav-link.sell:hover {
    background-color: #000;
    color: #fff;
}

.nav-link.signup {
    background-color: transparent;
    color: #fff;
    border: 2px solid #fff;
}

.nav-link.signup:hover {
    background-color: #fff;
    color: #000;
}
.divider {
    font-size: 30px;
    color: #fff; 
    margin: 0 10px; 
}
.profile-icon {
    width: 35px;
    height: 35px;
    border-radius: 50%;
}
    </style>
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
                <a href="/src/profile.php?view=profile" class="nav-link profile">
                    <img src="/images/app/usericon.svg" alt="User Profile Icon" class="profile-icon">
                </a>
            <?php else: ?>
                <a href="/src/loginsignup/signup.php" class="nav-link signup">Sign Up</a>
            <?php endif;?>
        </div>
    </div>
</body>
</html>
