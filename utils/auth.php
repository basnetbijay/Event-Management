<?php
function isLoggedIn(){
    session_start();
    return isset($_SESSION['is_logged_in'])&& $_SESSION['is_logged_in'];
}
?>