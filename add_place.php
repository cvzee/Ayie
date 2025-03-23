<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];

    $stmt = $conn->prepare("INSERT INTO places (name, latitude, longitude, description, image_url) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sddss", $name, $latitude, $longitude, $description, $image_url);
    $stmt->execute();
    $stmt->close();

    header("Location: places.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a Place</title>
    <link rel="stylesheet" href="add-place.css">
</head>
<body>
    <?php include 'navigation.php'; ?>

    <h2>Add a Place</h2>
    
    <form method="POST">
        <label>Place Name:</label>
        <input type="text" name="name" required><br>

        <label>Latitude:</label>
        <input type="text" name="latitude" required><br>

        <label>Longitude:</label>
        <input type="text" name="longitude" required><br>

        <label>Description:</label>
        <textarea name="description"></textarea><br>

        <label>Image URL:</label>
        <input type="text" name="image_url"><br>

        <button type="submit">Add Place</button>
    </form>
</body>
</html>