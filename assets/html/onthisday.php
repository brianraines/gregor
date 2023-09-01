<?php
include_once 'vendor/autoload.php';

$client = new \GuzzleHttp\Client();
$url = 'https://api.wikimedia.org/feed/v1/wikipedia/en/onthisday/all/' . date( 'm/d' );
$response = $client->request('GET', $url);
$history = json_decode($response->getBody()->getContents(), true);

foreach ($history as $key => $events) {
    foreach ($events as $event) {
        unset($event['pages']);
    }
}
?>
<script type="text/javascript">
    var births = <?php echo json_encode($history['births']); ?>;
    var deaths = <?php echo json_encode($history['deaths']); ?>;
    var events = <?php echo json_encode($history['events']); ?>;
    var holidays = <?php echo json_encode($history['holidays']); ?>;
</script>
<div id="onthisday">
    <div id="onthisday-label">
        <span id="onthisday-title"><span id="event-type"></span>On This Day in <span id="event-year"></span></span>
    </div>
    <div id="onthisday-content">
        <span id="onthisday-event">&nbsp;</span>
    </div>
</div>