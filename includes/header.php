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
            <a href="sell.php" class="nav-link sell">Sell for Free</a>
            <span class="divider">|</span>
            <a href="/src/loginsignup/signup.php" class="nav-link signup">Sign Up</a>
        </div>
    </div>
</body>
</html>
