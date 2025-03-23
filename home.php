<?php 
include 'database.php';

    // GET NEXT DATE
    $query = "SELECT date FROM monthsary ORDER BY date ASC LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $nextMonthsary = $row ? $row['date'] : 'No monthsary has been set.';

    // SET NEXT MONTHSARY DATE
    $nextMonthsary = "2025-04-17";

    // GET TODAY'S DATE
    $today = date('Y-m-d');

    // CALCULATE COUNTDOWN
    $diff = strtotime($nextMonthsary) - strtotime($today);
    $daysLeft = floor($diff / (60 * 60 * 24)); // Corrected division
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Monthsary </title>
        <link rel="stylesheet" href="http://localhost/youmi/home-style.css" type="text/css">
    </head>
    <body>
        <?php include 'navigation.php'; ?>

        <div class="container">
            <p>Our next monthsary is on <br>
                <strong> 
                    <div class="nextMonthsary">
                        <!-- <?php echo $nextMonthsary; ?> -->
                         <?php echo date("F j, Y", strtotime($nextMonthsary)); ?>
                        
                         <!-- 
                         strtotime($nextMonthsary): Converts the string "2025-03-17" into a timestamp.
                            date("F j, Y", ...): Formats it as "March 17, 2025".
                            F → Full month name (March)
                            j → Day without leading zero (17)
                            Y → Full year (2025)
                         -->
                    </div>
                </strong>
            </p>        
        </div>

<h2> 
    <div id="countdown-wrapper">
        <div class="countdown-container">
            <div class="countdown-circle"><span id="days">00</span></div>
            <div class="countdown-label">Days</div>
        </div>
        <div class="colon">:</div>
        <div class="countdown-container">
            <div class="countdown-circle"><span id="hours">00</span></div>
            <div class="countdown-label">Hours</div>
        </div>
        <div class="colon">:</div>
        <div class="countdown-container">
            <div class="countdown-circle"><span id="minutes">00</span></div>
            <div class="countdown-label">Minutes</div>
        </div>
        <div class="colon">:</div>
        <div class="countdown-container">
            <div class="countdown-circle"><span id="seconds">00</span></div>
            <div class="countdown-label">Seconds</div>
        </div>
    </div>
</h2>

        <script src="home-script.js"></script>
    </body>
</html>