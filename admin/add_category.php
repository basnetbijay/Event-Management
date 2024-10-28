<?php
require_once '/xampp/htdocs/eventMgmt/db/db.php';
$conn = getDB();
session_start();
if ($_SESSION['email'] !== 'admin@gmail.com') {
    header("Location: ../src/loginsignup/login.php");
    exit();
}

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name'];

    // Prepare and bind an SQL statement to insert a new category
    $stmt = $conn->prepare("INSERT INTO categories (category_name) VALUES (?)");
    $stmt->bind_param("s", $category_name);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        echo "New category added successfully!";
    } else {
        echo "Error adding category: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();

    // Redirect back to the admin page (optional)
    header("Location: admin.php");
    exit();
}

// Close the connection after use
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Category</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1 {
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 450px;
        }

        input[type="text"] {
            width: 95%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-button {
            margin-top: 10px;
            text-decoration: none;
            color: #007bff;
        }
        .button-group {
    display: flex;
    justify-content: space-around; /* Adjust as needed to space out buttons */
    width: 100%;
}

.form-button, .back-button {
    background-color: #007bff;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 48%; /* Adjust width to fit side-by-side */
    text-align: center;
    text-decoration: none; /* To make the link look like a button */
    display: block; /* Needed to apply width and centering */
}

.form-button:hover, .back-button:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
    <h1>Add New Category</h1>

    <!-- Form to add a new category -->
   <!-- Form to add a new category -->
<form method="post">
    <label for="category_name">Category Name:</label>
    <input type="text" name="category_name" id="category_name" required>

    <div class="button-group">
        <button type="submit" class="form-button">Add Category</button>
        <button type="submit" class="form-button" ><a href="admin.php" style="text-decoration: none;  color:white;" >Back to Admin Page</a></button>
        <!--  -->
    </div>
</form>

</body>
</html>
