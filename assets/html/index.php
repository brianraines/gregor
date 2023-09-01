<html>
    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/css/style.css">
        <script type="text/javascript" src="js/app.js"></script>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <?php include 'weather.php'; ?>
                <div id="date">
                    <div id="date-label">
                        <span id="day-of-week">&nbsp;</span>
                        <span id="month">&nbsp;</span>
                        <span id="day-of-month">&nbsp;</span>
                    </div>
                </div>
                <?php include 'moon.php'; ?>
            </div>
            <div id="time">
                <div id="date-label">
                    <span id="hours-minutes">&nbsp;</span>
                    <span id="meridian" class="meridian">&nbsp;</span>
                </div>
            </div>
            <?php include 'onthisday.php'; ?>
        </div>
    </body>
</html>