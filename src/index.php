<?php
require '../db/db.php';
require '../includes/header.php';
require '../utils/auth.php';
session_start();
print_r($_SESSION) ;
if ($_SESSION['is_logged_in']) {
    echo 'you are logged in';
}else{
    echo 'you are not logged in';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThriftIt - Home</title>
</head>
<body>
    <h1>hello this is home page</h1>
    <p>add banner here?</p>
    <a href="../src/loginsignup/logout.php">Logout</a>
</body>
</html>
