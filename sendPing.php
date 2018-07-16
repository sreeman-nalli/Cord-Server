<?php
require_once "onePing.php";

/*Uses the object in onePing.php to send the server a single ping for an ongoing activity*/

$checkinID = $_GET["checkinID"];
$lat = $_GET["lat"];
$long = $_GET["long"];

$createPing = new onePing();
$result = $createPing->submitPing($checkinID, $lat, $long);

if ($result === true) {
    $response["result"] = "SUCCESS";
} else {
    $response["result"] = "Failed to send ping";
}

echo json_encode($response);