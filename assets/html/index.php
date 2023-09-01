<?php
include_once 'vendor/autoload.php';

$weatherApiKey = "7811916890e3cf69efc2b28022a6c4f3";
$latitude = "33.078715";
$longitude = "-96.808306";
$weatherUrl = "https://api.openweathermap.org/data/2.5/weather?lat=" . $latitude . "&lon=" . $longitude . "&units=imperial&appid=" . $weatherApiKey;

$client = new \GuzzleHttp\Client();
$response = $client->request('GET', $weatherUrl);

$weather = json_decode($response->getBody()->getContents(), true);
$temperature = $weather['main']['temp'];
$weatherIcon = $weather['weather'][0]['icon'];

$url = 'https://api.wikimedia.org/feed/v1/wikipedia/en/onthisday/all/' . date( 'm/d' );
$onthisdayRequest = $client->request('GET', $url);
$history = json_decode($onthisdayRequest->getBody()->getContents(), true);


foreach ($history as $key => $events) {
    foreach ($events as $event) {
        unset($event['pages']);

       // $history[$key][] = $event;
    }
}
?>
<html>
    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/css/style.css">
        <script type="text/javascript">

                window.onload = function() {
                    startTime();
                    setOnThisDay();
                }

                function startTime() {
                    var today = new Date();
                    // get the month name in long format
                    var month = today.toLocaleDateString('en-US', { month: 'long' });
                    // get the day of the month
                    var day = today.getDate();
                    // get the short day of the week
                    var dayOfWeek = today.toLocaleDateString('en-US', { weekday: 'short' });
                    // get hours in 12h format
                    var hours = today.getHours() % 12 || 12;
                    var m = today.getMinutes();
                    m = checkTime(m);
                    // get meridian
                    var meridian = today.getHours() >= 12 ? 'pm' : 'am';

                    var time = hours + ":" + m;

                    document.getElementById('day-of-week').innerHTML = dayOfWeek;
                    document.getElementById('month').innerHTML = month;
                    document.getElementById('day-of-month').innerHTML = day;
                    document.getElementById('hours-minutes').innerHTML = time;
                    document.getElementById('meridian').innerHTML = meridian;

                    setTimeout(startTime, 1000);
                }

                function checkTime(i) {
                    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
                    return i;
                }

                var births = <?php echo json_encode($history['births']); ?>;
                var deaths = <?php echo json_encode($history['deaths']); ?>;
                var events = <?php echo json_encode($history['events']); ?>;
                var holidays = <?php echo json_encode($history['holidays']); ?>;

                function getRandom(events = []) {
                    return events[Math.floor(Math.random() * events.length)];
                }

                function setOnThisDay() {
                    // get a random number between 0 and 3
                    var type = '';
                    var random = Math.floor(Math.random() * 4);
                    if (random == 0) {
                        var event = getRandom(births);
                        type = 'birth';
                    } else if (random == 1) {
                        var event = getRandom(deaths);
                        type = 'death';
                    } else {
                        var event = getRandom(events);
                        type = 'event';
                    }

                    setEvent(type, event);

                    setTimeout(setOnThisDay, 60000);
                }

                function setEvent(type, event) {

                    var title = '';
                    if (type == "birth") {
                        title = 'Born ';
                    } else if (type == "death") {
                        title = 'Died ';
                    }

                    if (event.text.length > 73 && event.text.length < 153) {
                        document.getElementById('time').style.marginBottom = '21px';
                    } else if (event.text.length >= 153 && event.text.length < 223) {
                        document.getElementById('time').style.marginBottom = '2px';
                    } else if (event.text.length >= 223) {
                        document.getElementById('time').style.marginBottom = '-18px';
                    } else {
                        document.getElementById('time').style.marginBottom = '42px';
                    }

                    document.getElementById('event-type').innerHTML = title;
                    document.getElementById('event-year').innerHTML = event.year;
                    document.getElementById('onthisday-event').innerHTML = event.text;
                }


        </script>
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
            <div id="onthisday">
                <div id="onthisday-label">
                    <span id="onthisday-title"><span id="event-type"></span>On This Day in <span id="event-year"></span></span>
                </div>
                <div id="onthisday-content">
                    <span id="onthisday-event">&nbsp;</span>
                </div>
            </div>
        </div>
    </body>
</html>