<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "event"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventName = $_POST['eventName'];
    $eventDescription = $_POST['eventDescription'];
    $eventPicture = $_FILES['eventPicture'];

    // Upload picture
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($eventPicture["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($eventPicture["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($eventPicture["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // If everything is ok, try to upload file
    } else {
        if (move_uploaded_file($eventPicture["tmp_name"], $targetFile)) {
            echo "The file ". htmlspecialchars(basename($eventPicture["name"])). " has been uploaded.";
            $sql = "INSERT INTO events (event_name, event_description, event_picture) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $eventName, $eventDescription, $targetFile);

            if ($stmt->execute()) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$conn->close();
?>
