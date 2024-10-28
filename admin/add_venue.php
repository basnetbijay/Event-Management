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
    $venue_name = $_POST['venue_name'];
    $capacity = $_POST['capacity'];
    $location = $_POST['location'];
    $category = $_POST['category'];

    // Prepare and bind an SQL statement to insert a new venue
    $stmt = $conn->prepare("INSERT INTO venues (venue_name, capacity, location, category) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $venue_name, $capacity, $location, $category);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        echo "New venue added successfully!";
    } else {
        echo "Error adding venue: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Fetch categories from the database
$category_sql = "SELECT DISTINCT category_name FROM categories";
$category_result = $conn->query($category_sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Venue</title>
    <link rel="stylesheet" href="venuStyle.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <style>
        #map {
            height: 400px;
            /* Adjust height as needed */
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <h1>Add New Venue</h1>

    <form method="post">
        <label for="venue_name">Venue Name:</label>
        <input type="text" name="venue_name" id="venue_name" required>
        <br>

        <label for="capacity">Capacity:</label>
        <input type="number" name="capacity" id="capacity" required>
        <br>

        <label for="location">Location:</label>
        <input type="hidden" name="location" id="location" required>
        <input type="hidden" name="latitude" id="latitude" required>
        <input type="hidden" name="longitude" id="longitude" required>
        <p id="location_namep" style="border: 1px solid #ccc; padding: 10px; background-color: #f9f9f9; font-size: 16px; max-width: 100%; word-wrap: break-word;">N/A</p>

        <div id="map"></div>

        <label for="category">Category:</label>
        <select name="category" id="category" required>
            <option value="">Select a category</option>
            <?php
            if ($category_result->num_rows > 0) {
                while ($row = $category_result->fetch_assoc()) {
                    echo '<option value="' . $row['category_name'] . '">' . $row['category_name'] . '</option>';
                }
            } else {
                echo '<option value="">No categories available</option>';
            }
            ?>
        </select>
        <br>

        <button type="submit">Add Venue</button>
        <br><br>
        <button type="button" onclick="window.location.href='admin.php'">Back to Admin Page</button>
    </form>

    <<script src="https://unpkg.com/leaflet/dist/leaflet.js">
        </script>
        <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
        <script>
            let map, marker;

            // Initialize map and marker
            function initMap() {
                const defaultLocation = [27.7172, 85.3240]; // Kathmandu as default

                // Create the map
                map = L.map('map').setView(defaultLocation, 13);

                // Load and display tile layers from OpenStreetMap
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap'
                }).addTo(map);

                // Add a draggable marker to the map
                marker = L.marker(defaultLocation, {
                    draggable: true
                }).addTo(map);

                // Update lat/lng and address when the marker is dragged
                marker.on('dragend', function() {
                    const position = marker.getLatLng();
                    document.getElementById('latitude').value = position.lat;
                    document.getElementById('longitude').value = position.lng;
                    updateLocationName(position.lat, position.lng);
                });

                // Update marker position and address when map is clicked
                map.on('click', function(event) {
                    marker.setLatLng(event.latlng);
                    document.getElementById('latitude').value = event.latlng.lat;
                    document.getElementById('longitude').value = event.latlng.lng;
                    updateLocationName(event.latlng.lat, event.latlng.lng);
                });

                // Add a geocoder control to search for locations
                const geocoder = L.Control.geocoder({
                    defaultMarkGeocode: true
                }).on('markgeocode', function(e) {
                    const bbox = e.geocode.bbox;
                    map.fitBounds(bbox);

                    // Move the marker to the searched location
                    marker.setLatLng(e.geocode.center);
                    document.getElementById('latitude').value = e.geocode.center.lat;
                    document.getElementById('longitude').value = e.geocode.center.lng;
                    updateLocationName(e.geocode.center.lat, e.geocode.center.lng);
                }).addTo(map);
            }

            // Function to reverse geocode latitude and longitude to a location name
            function updateLocationName(lat, lng) {
                // Use the Nominatim reverse geocoding service to get the location's name
                fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.display_name) {
                            document.getElementById('location').value = data.display_name;
                            document.getElementById('location_namep').textContent = data.display_name; // Update the display field
                        } else {
                            document.getElementById('location').value = "Unknown Location";
                            document.getElementById('location_namep').textContent = "Unknown Location"; // Display "Unknown Location"
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching location:', error);
                        document.getElementById('location_namep').textContent = "Error fetching location";
                    });
            }

            // Initialize the map when the page loads
            window.onload = initMap;
        </script>

</body>

</html>