<?php
require '../../db/db.php';
require '../../utils/getFuncs.php';
$conn = getDB();

if (isset($_POST['email'])) {
    $user= getUser($conn, $_POST['email']);
    if ($user) {
        $user_id = $user['user_id'];
        $email = $user['email'];
        $first_name=$user['first_name'];
        $last_name=$user['last_name'];
        $password_hash=$user['password_hash'];
    }
    else{
        die("User not found");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (password_verify($password, $password_hash)) {
        session_start();
        $_SESSION['is_logged_in'] = true;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['email'] = $email;
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        header("Location: ../index.php");
        exit();
    } else {
        echo "Incorrect password";
    }

    $stmt->close();
    $conn->close();
}
?>
