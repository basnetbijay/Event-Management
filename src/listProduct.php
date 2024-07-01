
<?php
require '../includes/header.php';
require_once '../db/db.php';

$conn = getDB();

function fetchCategories($conn) {
    $sql = "SELECT category_id, category_name FROM Categories";
    $result = mysqli_query($conn, $sql);
    $categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
    return $categories;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $itemName = $_POST['item_name'];
    $itemDescription = $_POST['item_description'];
    $itemCondition = $_POST['item_condition'];
    $price = $_POST['price'];
    $categoryId = $_POST['category_id'];
    $listedBy = $_SESSION['user_id']; 
    // Handle file upload
    $imageUrl = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../images/items/';
        $imageUrl = $uploadDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imageUrl);
    }

    $sql = "INSERT INTO Items (item_name, image_url, item_description, item_condition, listed_by, price, category_id, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssidi", $itemName, $imageUrl, $itemDescription, $itemCondition, $listedBy, $price, $categoryId);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$categories = fetchCategories($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List an Item</title>
    <link rel="stylesheet" href="../includes/styles.css">
    <style>
        body {
            background: url('/images/app/backgroundlogin.jpg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
            height: 100vh;
        }
    </style>
</head>
<body>
    <div class="listcontainer">
        <h1>List an Item</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="textbox">
                <label for="item_name">Item Name</label>
                <input type="text" name="item_name" id="item_name" required>
            </div>
            <div class="textbox">
                <label for="image">Image</label>
                <input type="file" name="image" id="image">
            </div>
            <div class="textbox">
                <label for="item_description">Item Description</label>
                <textarea name="item_description" id="item_description" required></textarea>
            </div>
            <div class="textbox-group">
                <div class="textbox">
                    <label for="item_condition">Condition</label>
                    <select name="item_condition" id="item_condition" required>
                        <option value="" disabled selected>Select Condition</option>
                        <option value="New">New</option>
                        <option value="Like New">Like New</option>
                        <option value="Good">Good</option>
                        <option value="Fair">Fair</option>
                        <option value="Poor">Poor</option>
                    </select>
                </div>
                <div class="textbox">
                    <label for="category_id">Category</label>
                    <select name="category_id" id="category_id" required>
                        <option value="" disabled selected>Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['category_id'] ?>"><?= htmlspecialchars($category['category_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="textbox">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" step="0.01" required>
            </div>
            <button type="submit" class="btn">List Item</button>
        </form>
    </div>
</body>
</html>
