    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" contennt="">
    <link rel="stylesheet" href="http://localhost/youmi/nav-style.css" type="text/css">

    <header>
        <nav>
            <div class="navigation-bar">
            <div class="menu-toggle">☰</div>
                <ul class="navig">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="love_notes.php">Letters</a></li>
                    <li><a href="places.php">Places to Visit</a></li>
                    <li><a href="movies_watchlist.php">Movies Watchlist</a></li>
                    <li><a href="series_watchlist.php">Series Watchlist</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.querySelector(".menu-toggle");
    const navig = document.querySelector(".navig");

    menuToggle.addEventListener("click", function () {
        navig.classList.toggle("active");
    });
});

    </script>