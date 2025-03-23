<?php
include 'database.php';

// Fetch all places from the database
$result = $conn->query("SELECT * FROM places");
$places = [];

while ($row = $result->fetch_assoc()) {
    $places[] = $row;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Places to Visit</title>
    <link rel="stylesheet" href="places-style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
</head>
<body>

    
        <?php include 'navigation.php'; ?>
    
        <div class="container">
            <h2>Pinned Locations</h2>
        <div id="map" style="height: 500px;"></div>


        <div class="add">
            <a href="add_place.php">Add a New Place</a>
        </div>
    </div>
    
<!-- JavaScript   -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([14.52, 121], 9); // Initial location

        // Load OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var places = <?php echo json_encode($places); ?>;

        // Define a custom icon
        var customIcon = L.icon({
            iconUrl: 'images/location-pin.png',  // Change to your icon URL
            iconSize: [30, 30],  // Size of the icon
            iconAnchor: [20, 40],  // Point where the icon is anchored
            popupAnchor: [0, -40]  // Where the popup appears relative to the icon
        });

        // Add a marker with the custom icon
        places.forEach(place => {
        var marker = L.marker([place.latitude, place.longitude], { icon: customIcon })
            .addTo(map)
            .bindPopup(`<b>${place.name}</b><br>${place.description}<br><img src="${place.image_url}" width="100">`);
        });

    </script>
</body>
</html>