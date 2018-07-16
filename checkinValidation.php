<?php
include_once "checkin_setup.php";

/*Uses the object from checkin_setup.php to create a check-in for an activity*/

$id = $_GET['id'];
$travelDuration = $_GET['duration'];
$latitude = $_GET['latitude'];
$longitude = $_GET['longitude'];

$checkin = new checkin_setup();

$result = $checkin->insertNewCheckIn($id, $travelDuration, $latitude, $longitude);

if ($result === true) {
    $response["result"] = "SUCCESS";
} else if ($result === false) {
    $response["result"] = "FAILURE to Insert Data due to Internal Issues";
} else {
    $response["result"] = "There is an on-going activity running at the present";
}

echo json_encode($response);