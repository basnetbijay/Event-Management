<?php
//require '../../includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - Event Management</title>
    <link rel="stylesheet" href="style.css">
    <style>
         body {
            background: url("../../images/app/back.jpg") no-repeat center center fixed;
            background-size: cover;
            position: relative;
            overflow: hidden;
            height: 100vh;
        }

    </style>
</head>
<body>
    <div class="bodylog">
    <div class="container">
        <div class="content-box">
            <div class="info-box">
                <img src="../../images/app/backgroundEvent.jpg" alt="loginsignupbanner" class="info-image">
                <p class="info-text">Welcome to Entertainment</p>
            </div>
            <div class="login-box">
                <div class="login-header">
                    <h2>Sign Up</h2>
                </div>
                <form action="signup_process.php" method="post">
                    <div class="textbox">
                        <input type="text" id="first_name" name="first_name" placeholder="First Name" required>
                    </div>
                    <div class="textbox">
                        <input type="text" id="last_name" name="last_name" placeholder="Last Name" required>
                    </div>
                    <div class="textbox">
                        <input type="email" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="textbox">
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>

                    <button type="submit" class="btn">Sign Up</button>
                    <?php
                        if (isset($_GET['error'])) {
                        echo '<div class="error-message">' . htmlspecialchars($_GET['error']) . '</div>';
                        }
                    ?>
                    <div class="links">
                        <p>Already have an account? </p><a href="login.php">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    
</body>
</html>