<?php
require '../db/db.php';
require '../includes/header.php';
require '../utils/auth.php';
session_start();
if ($_SESSION['is_logged_in']) {
    echo 'you are logged in';
}else{
    echo 'you are not logged in';
}
?>
<h1>hello this is home page</h1>
<p>add banner here?</p>
<a href="../src/loginsignup/logout.php">Logout</a>