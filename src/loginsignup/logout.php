<?php
session_start();
session_unset();
$_SESSION['is_logged_in']=false;
header("Location: ../index.php");
?>