<?php
include 'database.php';

// Handles form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sender_name = isset($_POST['sender_name']) ? $_POST['sender_name'] : '';
    $message = trim($_POST['message']);

    if (!empty($sender_name) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO love_notes (sender_name, message) VALUES (?, ?)");
        $stmt->bind_param("ss", $sender_name, $message);
        $stmt->execute();
        $stmt->close();

        // Redirect to prevent duplicate submissions on refresh
        header("Location: love_notes.php");
        exit();
    }
}

// Fetch all love notes
$result = $conn->query("SELECT * FROM love_notes ORDER BY created_at DESC");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Love Notes</title>
    <link rel="stylesheet" href="love_notes-style.css">
</head>
<body>
    <?php include 'navigation.php'; ?>

    <div class="love-notes-container">

        <form method="POST" action="">
            <h2>Love Note</h2>
            <textarea name="message" placeholder="Write me something..." required></textarea>
            <select name="sender_name" required>
                <option value="" disabled selected>Select Sender</option>
                <option value="Zee">From Zee</option>
                <option value="Aye">From Ayie</option>
            </select>
            <button type="submit">Send</button>
        </form>

        <hr>

        <div class="notes-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="note">
                    <div class="sender">
                        <strong><?php echo htmlspecialchars($row['sender_name']); ?></strong>
                    </div>        
                    <div class="message">
                        <?php echo htmlspecialchars($row['message']); ?>
                    </div>
                    <div class="timestamp">
                        <small><?php echo date("F j, Y - g:i A", strtotime($row['created_at'])); ?></small>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

</body>
</html>

