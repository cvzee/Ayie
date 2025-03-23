<?php
include 'database.php';

// Handle movie submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $poster = trim($_POST['poster']);
    $genre = trim($_POST['genre']);

    if (!empty($title)) {
        $stmt = $conn->prepare("INSERT INTO movies_watchlist (title, poster_url, genre, status) VALUES (?, ?, ?, 'To Watch')");
        $stmt->bind_param("sss", $title, $poster, $genre);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch all movies
$result = $conn->query("SELECT * FROM movies_watchlist ORDER BY added_at DESC");

// List of common movie genres
$genres = [
    "Action", "Adventure", "Animation", "Comedy", "Crime", "Documentary", "Drama",
    "Fantasy", "Historical", "Horror", "Musical", "Mystery", "Romance", "Sci-Fi",
    "Sports", "Thriller", "War", "Western"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies Watchlist</title>
    <link rel="stylesheet" href="movies-style.css">
</head>
<body>
    <?php include 'navigation.php'; ?>

    <div class="movies-container">
        <h2>Movies Watchlist</h2>

        <form method="POST" action="">
            <input type="text" name="title" placeholder="Movie Title" required>
            <input type="text" name="poster" placeholder="Poster URL (Optional)">
        
            <select name="genre" required>
                <option value="" disabled selected>Select Genre</option>
                <?php foreach ($genres as $genre): ?>
                    <option value="<?php echo htmlspecialchars($genre); ?>"><?php echo htmlspecialchars($genre); ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Add Movie</button>
        </form>

        <hr>

        <div class="movies-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="movie">
                    <img src="<?php echo !empty($row['poster_url']) ? htmlspecialchars($row['poster_url']) : 'default-poster.jpg'; ?>" alt="Movie Poster">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p><?php echo htmlspecialchars($row['genre']); ?></p>
                    <p>Status: <strong><?php echo htmlspecialchars($row['status']); ?></strong></p>
                    <a href="update_movie.php?id=<?php echo $row['id']; ?>" class="toggle-status">Toggle Status</a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>