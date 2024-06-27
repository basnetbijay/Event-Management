<?php
require '../db/db.php';
require '../includes/header.php';
require '../utils/auth.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThriftIt - Home</title>
    <link rel="stylesheet" href="../includes/styles.css"> 
</head>
<body>
    <div class="container">
        <div class="category-list">
            <h3>Categories</h3>
            <ul>
                <?php
                $categories = ['Tops', 'Shoes', 'Pants', 'Bags', 'Skirts', 'Men Shirt', 'Accessories'];
                foreach ($categories as $category) {
                    echo '<li><a href="#">';
                    echo htmlspecialchars($category);
                    echo '</a></li>';
                }
                ?>
            </ul>
        </div>
        <div class="content">
            <h1>Welcome to ThriftIt</h1>
            <p>Add banner here?</p>
            <a href="../src/loginsignup/logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
