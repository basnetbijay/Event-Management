<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['event_id'], $_POST['user_email'], $_POST['role'], $_POST['responsibilities'])) {
        $event_id = $_POST['event_id'];
        $user_email = $_POST['user_email'];
        $role = $_POST['role'];
        $responsibilities = $_POST['responsibilities'];

        // Check if user exists in the 'users' table
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $user_email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if ($user) {
            $user_id = $user['user_id'];
            $stmt = $conn->prepare("INSERT INTO event_member (event_id, email, id, role, responsibility) VALUES (?, ?, ?, ?,?)");
            $stmt->bind_param("isiss", $event_id, $user_email, $user_id, $role, $responsibilities);
            if ($stmt->execute()) {
                $message = "Member added successfully!";
            } else {
                $message = "Error adding member.";
            }
        } else {
            $message = "User not found!";
        }
    }
}

// Fetch events for the logged-in user

$userId = $_SESSION['user_id'];
$sql = "SELECT id, event_name FROM events WHERE user_id = ? && status = 'approved'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$events = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Member</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
    <div class="container">
        <h1>Add Members</h1>
        <?php if (isset($message)) : ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <form id="addMemberForm" method="POST">
            <select name="event_id" id="event_id" required>
                <option value="" disabled selected>Select Event</option>
                <?php foreach ($events as $event) : ?>
                    <option value="<?php echo $event['id']; ?>"><?php echo htmlspecialchars($event['event_name']); ?></option>
                <?php endforeach; ?>
            </select>
            <input type="email" name="user_email" placeholder="Member Email" required>
            <select name="role" required>
                <option value="" disabled selected>Role</option>
                <option value="Manager">Manager</option>
                <option value="Assistant">Assistant</option>
                <option value="Member">Member</option>
            </select>
            <textarea name="responsibilities" placeholder="Responsibilities" rows="4" required></textarea>
            <button type="submit">Add Member</button>
        </form>

    </div>
</body>
</html>
