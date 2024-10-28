
<?php
    session_start();

    unset($_SESSION["is_logged_in"]);
   unset($_SESSION["email"]);
   session_destroy();

    header("Location: http://localhost:8080/eventMgmt/src/loginsignup/login.php");
?>