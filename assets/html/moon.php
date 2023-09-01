<?php
include_once 'vendor/autoload.php';

use Solaris\MoonPhase;

$moonPhase = new MoonPhase();
$moonPhaseName = $moonPhase->getPhaseName();
$moonImage = "/img/moon/" . strtolower(str_replace(' ', '-', $moonPhaseName)) . ".png";

?>
<div id="moon">
    <img src="<?php echo $moonImage; ?>" width="60" height="61" />
    <?php echo $moonPhaseName; ?>
</div>