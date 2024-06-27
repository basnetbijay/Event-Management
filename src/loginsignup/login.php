<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - ThriftIt</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="content-box">
            <div class="info-box">
                <img src="path/to/your/image.jpg" alt="loginsignupbanner" class="info-image">
                <p class="info-text">Welcome to ThriftIt</p>
            </div>
            <div class="login-box">
                <div class="login-header">
                    <h2>Login</h2>
                </div>
                <form action="login_process.php" method="post">
                    <div class="textbox">
                        <input type="email" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="textbox">
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn">Login</button>
                    <div class="links">
                        <p>Don't have an account? </p><a href="signup.php">Sign Up</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

