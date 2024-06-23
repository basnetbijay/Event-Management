<?php
function getUser($conn, $email){
    $sql="SELECT * FROM Users WHERE email=?";
    $stmt=mysqli_prepare($conn, $sql);
    if ($stmt===false) {
        echo mysqli_error($conn);
    }else{
        mysqli_stmt_bind_param($stmt, "s", $email);
        if (mysqli_stmt_execute($stmt)) {
            $result=mysqli_stmt_get_result($stmt);
            return mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
    }
}
?>