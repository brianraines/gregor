<?php
include_once 'vendor/autoload.php';

use Solaris\MoonPhase;

$moonPhase = new MoonPhase();
$moonPhaseName = $moonPhase->getPhaseName();
$moonImage = "/img/moon/" . strtolower(str_replace(' ', '-', $moonPhaseName)) . ".png";

$weatherApiKey = "7811916890e3cf69efc2b28022a6c4f3";
$latitude = "33.078715";
$longitude = "-96.808306";
$weatherUrl = "https://api.openweathermap.org/data/2.5/weather?lat=" . $latitude . "&lon=" . $longitude . "&units=imperial&appid=" . $weatherApiKey;

$client = new \GuzzleHttp\Client();
$response = $client->request('GET', $weatherUrl);

$weather = json_decode($response->getBody()->getContents(), true);
$temperature = $weather['main']['temp'];
$weatherIcon = $weather['weather'][0]['icon'];
?>
<html>
    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
        <div id="container">
            <div id="header">
                <div id="moon"><img src="<?php echo $moonImage; ?>" width="60" height="61" /></div>
                <div id="date">
                    <div id="date-label">
                        <span id="day-of-week"><?php echo date('D'); ?></span>
                        <span id="month"><?php echo date('F'); ?></span>
                        <span id="day-of-month"><?php echo date('j'); ?></span>
                    </div>
                </div>
                <div id="weather"><img src="/img/weather/<?php echo $weatherIcon; ?>.png" width="60" height="61" /><br />
                <?php echo $temperature; ?>°</div>
            </div>
            <div id="time">
                <div id="date-label">
                    <span class="meridian" style="color: #193d61;">pm</span>
                    <span id="hours-minutes">8:48</span>
                    <span id="meridian" class="meridian">pm</span>
                </div>
            </div>
        </div>
    </body>
</html>