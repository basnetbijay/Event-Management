<?php
define('DB_HOST', 'localhost');  
define('DB_USER', 'root');        
define('DB_PASS', 'rootAdmin');     
define('DB_NAME', 'thriftit'); 
function getDB() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if(mysqli_connect_error()){
        echo mysqli_connect_error();
        exit;
    }
    return $conn;
}
?>
