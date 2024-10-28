<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get user categories based on their registrations
function getUserEventCategories($conn, $email) {
    $categories = [];
    $sql = "SELECT e.category FROM registrations r JOIN events e ON r.event = e.id WHERE r.email = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row['category'];
    }
    
    $stmt->close();
    return array_unique($categories);
}

// Function to get events by category, excluding those already registered
function getEventsByCategory($conn, $email, $categories) {
    $recommendations = [];
    
    // Prepare a placeholder string for the IN clause
    $placeholders = implode(',', array_fill(0, count($categories), '?'));
    
    // Query to fetch recommended events
    $sql = "SELECT id, event_name FROM events WHERE category IN ($placeholders) AND id NOT IN (
                SELECT event FROM registrations WHERE email = ?
            )";
    
    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    $types = str_repeat('s', count($categories)) . 's'; // e.g., 'sss'
    $params = array_merge($categories, [$email]);
    $stmt->bind_param($types, ...$params);
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $recommendations[] = $row;
    }
    
    $stmt->close();
    return $recommendations;
}

// Example usage
$email = 'bijay@gmail.com'; // Replace with the user's email
$user_categories = getUserEventCategories($conn, $email);
$recommended_events = getEventsByCategory($conn, $email, $user_categories);

// Display recommendations
if (!empty($recommended_events)) {
    echo "<h2>Recommended Events:</h2><ul>";
    foreach ($recommended_events as $event) {
        echo "<li>" . htmlspecialchars($event['event_name']) . "</li>";
    }
    echo "</ul>";
} else {
    echo "No recommendations available.";
}

// Close the database connection
$conn->close();
?>
