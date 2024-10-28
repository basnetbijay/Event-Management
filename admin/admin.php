<?php
require '/xampp/htdocs/eventMgmt/db/db.php';
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


// Fetch event data from the database
$sql = "SELECT e.id, e.event_name, e.event_description, e.event_picture, e.created_at, e.status, e.user_id, e.email, v.venue_name, e.category
        FROM events e
        LEFT JOIN venues v ON e.venue_id = v.id";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Events</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f4f6f9; /* Light background to blend with content */
            padding: 10px 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
            /* box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); Subtle shadow */
        }

        .navbar h1 {
            margin:0;
            margin-right: 200px;
            color: #333;
     /* Dark text color */
        }

        .nav-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-add-venue,.btn-add-category,
        .btn-logout {
            background-color: #007bff; 
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            border: none; 
        }

        .btn-add-venue:hover,.btn-add-category:hover
        .btn-logout:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px; /* Space from the navbar */
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        .btn-venue {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
        }
        .btn-add-category {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
        }

        .btn-disabled {
            color: grey;
        }
        #category{
            margin-left: -200px;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <div class="nav-buttons">
            <a href="add_venue.php" class="btn-add-venue">Add Venue</a>
        </div>
        <div class="nav-buttons">
            <a href="http://localhost:8080/eventMgmt/admin/add_category.php"  id="category" class="btn-add-venue">Add Category</a>
        </div>
        <h1>Event Management</h1>
        <div class="nav-buttons">
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Event Name</th>
                <th>Description</th>
                <th>Picture</th>
                <th>Created At</th>
                <th>Status</th>
                <th>User ID</th>
                <th>Email</th>
                <th>Venue</th>
                <th>Category</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['event_name'] . "</td>";
                    echo "<td>" . $row['event_description'] . "</td>";
                    echo "<td><img src='/eventMgmt/EventSubmission/" . $row['event_picture'] . "' alt='Event Picture' width='100'></td>";
                    echo "<td>" . $row['created_at'] . "</td>";


                    // Status Dropdown
                    echo "<td>";
                    echo "<form method='post' action='update_status.php'>";
                    echo "<input type='hidden' name='event_id' value='" . $row['id'] . "'>";
                    echo "<select name='status'>";
                    echo "<option value='pending' " . ($row['status'] == 'pending' ? "selected" : "") . ">Pending</option>";
                    echo "<option value='approved' " . ($row['status'] == 'approved' ? "selected" : "") . ">Approved</option>";
                    echo "<option value='rejected' " . ($row['status'] == 'rejected' ? "selected" : "") . ">Rejected</option>";
                    echo "</select>";
                    echo "<form action='sendApprovalEmails2.php' method='POST'>
                    <button type='submit'>Update</button>
                  </form>";
            
                    echo "</form>";
                    echo "</td>";

                    echo "<td>" . $row['user_id'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";

                    // Display Venue Name or Assign Venue Button
                    if (is_null($row['venue_name'])) {
                        if ($row['status'] == 'approved') {
                            echo "<td><a href='assign_venue.php?event_id=" . $row['id'] . "' class='btn-venue'>Assign Venue</a></td>";
                        } else {
                            echo "<td><span class='btn-disabled'>Assign Venue (Status not approved)</span></td>";
                        }
                    } else {
                        echo "<td>" . $row['venue_name'] . "</td>";
                    }
                    
                    echo "<td>" . $row['category'] . "</td>"; // Make sure this matches the alias in the SQL query
                    echo "</tr>";

                }
            } else {
                echo "<tr><td colspan='9'>No events found</td></tr>";
            }
            ?>
<!-- sending the notification on rejection -->



        </tbody>
    </table>
</body>

</html>

<?php
$conn->close();
?>
