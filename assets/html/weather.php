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
?>
<div id="weather">
    <img src="/img/weather/<?php echo $weatherIcon; ?>.png" width="60" height="61" /><br />
    <?php echo ceil($temperature); ?>°
</div>