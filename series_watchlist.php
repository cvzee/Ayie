<?php
include 'database.php'; // Connect to the database

// Handle series submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $poster = trim($_POST['poster']);
    $genre = trim($_POST['genre']);
    $episode = intval($_POST['episode']);

    if (!empty($title)) {
        $stmt = $conn->prepare("INSERT INTO series_watchlist (title, poster_url, genre, status, episode) VALUES (?, ?, ?, 'To Watch', ?)");
        $stmt->bind_param("sssi", $title, $poster, $genre, $episode);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch all series
$result = $conn->query("SELECT * FROM series_watchlist ORDER BY added_at DESC");

// List of common series genres
$genres = [
    "Action", "Adventure", "Animation", "Comedy", "Crime", "Documentary", "Drama",
    "Fantasy", "Historical", "Horror", "Musical", "Mystery", "Romance", "Sci-Fi",
    "Thriller", "War", "Western"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Series Watchlist</title>
    <link rel="stylesheet" href="series-style.css">
</head>
<body>
    <?php include 'navigation.php'; ?>

    <div class="series-container">
        <h2>Series Watchlist</h2>

        <form method="POST" action="">
            <input type="text" name="title" placeholder="Series Title" required>
            <input type="text" name="poster" placeholder="Poster URL (Optional)">
            
            <select name="genre" required>
                <option value="" disabled selected>Select Genre</option>
                <?php foreach ($genres as $genre): ?>
                    <option value="<?php echo htmlspecialchars($genre); ?>"><?php echo htmlspecialchars($genre); ?></option>
                <?php endforeach; ?>
            </select>
            
            <input type="number" name="episode" placeholder="Episode Number" min="1">
            <button type="submit">Add Series</button>
        </form>

        <hr>

        <div class="series-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="series">
                    <img src="<?php echo !empty($row['poster_url']) ? htmlspecialchars($row['poster_url']) : 'default-poster.jpg'; ?>" alt="Series Poster">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p><?php echo htmlspecialchars($row['genre']); ?></p>
                    <p>Status: <strong><?php echo htmlspecialchars($row['status']); ?></strong></p>
                    <p>📺 Episode: <strong><?php echo htmlspecialchars($row['episode']); ?></strong></p>
                    
                    <form method="POST" action="update_series.php">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="toggle_status" class="toggle-status">Toggle Status</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>