<?php
include 'database.php'; // Connect to the database

// Set default values
$current_status = "To Watch"; 
$current_episode = 1; 
$id = isset($_GET['id']) ? intval($_GET['id']) : (isset($_POST['id']) ? intval($_POST['id']) : 0);

if ($id > 0) {
    // Fetch current series details
    $query = "SELECT status, episode FROM series_watchlist WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($fetched_status, $fetched_episode);
    
    if ($stmt->fetch()) {
        $current_status = $fetched_status;
        $current_episode = $fetched_episode;
    }
    
    $stmt->close();
}

// Handle both status and episode update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_series'])) {
    $new_status = $_POST['status'];
    $new_episode = intval($_POST['episode']);
    
    if ($id > 0) {
        $update_query = "UPDATE series_watchlist SET status = ?, episode = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sii", $new_status, $new_episode, $id);
        if ($stmt->execute()) {
            $stmt->close();
            // Redirect back to series_watchlist.php after update
            header("Location: series_watchlist.php");
            exit();
        } else {
            echo "Error updating record: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Series</title>
    <link rel="stylesheet" href="series-style.css">
</head>

<body>
<?php include 'navigation.php'; ?>
    <div class="update-series-container">
        <h2>Update Series</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>"> 

            <label for="status">Status:</label>
            <select name="status" required>
                <option value="To Watch" <?php if ($current_status === 'To Watch') echo 'selected'; ?>>To Watch</option>
                <option value="Watching" <?php if ($current_status === 'Watching') echo 'selected'; ?>>Watching</option>
                <option value="Watched" <?php if ($current_status === 'Watched') echo 'selected'; ?>>Watched</option>
            </select>

            <br>
            <label for="episode">Episode:</label>
            <input type="number" name="episode" value="<?php echo htmlspecialchars($current_episode); ?>" min="1" required>

            <button type="submit" name="update_series">Update</button>
        </form>
    </div>
</body>
</html>
