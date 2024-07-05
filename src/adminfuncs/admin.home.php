<?php
require '../../db/db.php';
require '../../utils/auth.php';
require '../../utils/getFuncs.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isLoggedIn() || $_SESSION['email'] !== 'admin@gmail.com') {
    header("Location: ../loginsignup/login.php");
    exit();
}

$conn = getDB();

// Fetch all orders with category name
$sql = "SELECT Items.*, Categories.category_name FROM Items 
        LEFT JOIN Categories ON Items.category_id = Categories.category_id";
$result = $conn->query($sql);

$orders = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

// Update order status
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_id = $_POST['item_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE Items SET status = ? WHERE item_id = ?");
    $stmt->bind_param('si', $status, $item_id);
    $stmt->execute();
    $stmt->close();

    // Refresh the page to show updated data
    header("Location: admin.home.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Home - ThriftIt</title>
    <link rel="stylesheet" href="../../includes/styles.css">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 10px 20px;
            background-color: #000;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn:hover {
            background-color: #fff;
            color: #000;
            border: 1px solid #000;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Admin Dashboard</h1>
        <h2>All Orders</h2>
        <table>
            <tr>
                <th>Item ID</th>
                <th>Item Name</th>
                <th>Item Description</th>
                <th>Item Condition</th>
                <th>Price</th>
                <th>Date Listed</th>
                <th>Category</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['item_id']) ?></td>
                    <td><?= htmlspecialchars($order['item_name']) ?></td>
                    <td><?= htmlspecialchars($order['item_description']) ?></td>
                    <td><?= htmlspecialchars($order['item_condition']) ?></td>
                    <td><?= htmlspecialchars($order['price']) ?></td>
                    <td><?= htmlspecialchars($order['date_listed']) ?></td>
                    <td><?= htmlspecialchars($order['category_name']) ?></td>
                    <td><?= htmlspecialchars($order['status']) ?></td>
                    <td>
                        <form method="post" action="admin.home.php">
                            <input type="hidden" name="item_id" value="<?= htmlspecialchars($order['item_id']) ?>">
                            <select name="status" required>
                                <option value="Pending" <?= $order['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="Active" <?= $order['status'] == 'Active' ? 'selected' : '' ?>>Active</option>
                                <option value="Rejected" <?= $order['status'] == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                            </select>
                            <button type="submit" class="btn">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <a href="../loginsignup/logout.php">logout</a>
</body>
</html>
