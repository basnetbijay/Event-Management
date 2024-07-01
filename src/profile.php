<?php
require_once '../db/db.php';
require_once '../utils/auth.php';
require_once '../utils/getFuncs.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isLoggedIn()) {
    header("Location: /src/loginsignup/login.php");
    exit();
}

$conn = getDB();
$user = getUser($conn, $_SESSION['email']);

// Fetch user's listings
$listings = getUserListings($conn, $user['user_id']); 

// Handle different views based on sidebar selection
$view = isset($_GET['view']) ? $_GET['view'] : 'profile'; 

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile - ThriftIt</title>
    <link rel="stylesheet" type="text/css" href="/includes/styles.css">
    <style>
        .sidebar {
            width: 250px;
            background-color: #f2f2f2;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            overflow-y: auto;
        }
        .content {
            margin-left: 270px;
            padding: 20px;
        }
        .listing {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <?php require_once '../includes/header.php'; ?>

    <div class="sidebar">
        <h2>Navigation</h2>
        <ul>
            <li><a href="?view=profile">My Profile</a></li>
            <li><a href="?view=my_listings">My Listings</a></li>
            <ul>
                <li><a href="?view=active_listings">Active Listings</a></li>
                <li><a href="?view=pending_listings">Pending Listings</a></li>
                <li><a href="?view=rejected_listings">Rejected Listings</a></li>
            </ul>
        </ul>
    </div>

    <div class="content">
        <?php if ($view === 'profile'): ?>
            <div class="profile-container">
                <div class="profile-box">
                    <h2>Your Profile</h2>
                    <form action="profile.php" method="post">
                        <div class="textbox">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                        <div class="textbox">
                            <label for="first_name">First Name:</label>
                            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                        </div>
                        <div class="textbox">
                            <label for="last_name">Last Name:</label>
                            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                        </div>
                        <button type="submit" class="btn">Update Profile</button>
                    </form>
                    <a href="/src/loginsignup/logout.php" class="logout-btn">Logout</a>
                </div>
            </div>
        <?php elseif ($view === 'my_listings'): ?>
            <h2>My Listings</h2>
            <?php if (!empty($listings)): ?>
                <?php foreach ($listings as $listing): ?>
                    <div class="listing">
                        <h3><?php echo htmlspecialchars($listing['item_name']); ?></h3>
                        <p><?php echo htmlspecialchars($listing['item_description']); ?></p>
                        <p>Condition: <?php echo htmlspecialchars($listing['item_condition']); ?></p>
                        <p>Price: <?php echo htmlspecialchars($listing['price']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No listings found.</p>
            <?php endif; ?>
        <?php elseif ($view === 'active_listings'): ?>
            <!-- Display active listings -->
        <?php elseif ($view === 'pending_listings'): ?>
            <!-- Display pending listings -->
        <?php elseif ($view === 'rejected_listings'): ?>
            <!-- Display rejected listings -->
        <?php endif; ?>
    </div>
</body>
</html>
