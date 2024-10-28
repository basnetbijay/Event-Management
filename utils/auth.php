<?php
function isLoggedIn() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'];
}
//this is authorization part 
?>