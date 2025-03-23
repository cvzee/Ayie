<?php
include 'database.php'; // Connect to database

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Get the current status
    $query = "SELECT status FROM movies_watchlist WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($current_status);
    $stmt->fetch();
    $stmt->close();

    // Toggle status
    $new_status = ($current_status === 'To Watch') ? 'Watched' : 'To Watch';

    // Update status in database
    $update_query = "UPDATE movies_watchlist SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $new_status, $id);
    $stmt->execute();
    $stmt->close();

    // Redirect back to movies list
    header("Location: movies_watchlist.php");
    exit();
}
?>