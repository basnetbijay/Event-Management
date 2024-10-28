<?php
// Step 1: Establish Database Connection
$servername = "localhost";
$username = "root";   // Your database username
$password = "";       // Your database password
$dbname = "event"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Specify the table name
$table_name = "users"; // Replace with the name of the table you want to query

// Step 3: Write the SQL query to get the CREATE TABLE statement
$sql = "SHOW CREATE TABLE $table_name";

// Step 4: Execute the query
$result = $conn->query($sql);

// Step 5: Fetch and display the result
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "CREATE TABLE statement for '$table_name':<br><br>";
    echo "<pre>" . $row['Create Table'] . "</pre>"; // 'Create Table' column holds the CREATE query
} else {
    echo "No results found for table '$table_name'.";
}

// Step 6: Close the connection
$conn->close();
?>
