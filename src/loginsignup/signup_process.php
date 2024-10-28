<?php
require '../../db/db.php';
$conn = getDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    try {
        // Prepare and execute the SQL statement
        $stmt = $conn->prepare("INSERT INTO Users (email, password_hash, first_name, last_name) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $email, $password, $first_name, $last_name);
        
        if ($stmt->execute()) {
            // Redirect to index page on successful signup
            header("Location: /eventMgmt/src/loginsignup/login.php");
            
            exit();
        } else {
            throw new Exception("Failed to execute statement.");
        }
    } catch (mysqli_sql_exception $e) {
        //this is for when user already exist
        $error = "User already exists";
        header("Location: signup.php?error=" . urlencode($error));
        exit();
    } catch (Exception $e) {
        //this is for other exceptions
        $error = "An error occurred: " . $e->getMessage();
        header("Location: signup.php?error=" . urlencode($error));
        exit();
    } finally {
        $stmt->close();
        $conn->close();
    }
}
?>
