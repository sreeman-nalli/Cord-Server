<?php
include_once "checkin_update.php";

/*Uses the object in checkin_update.php to add time to an activity*/

$checkinID = $_GET["checkinID"];
$timeToAdd = $_GET["timeToAdd"];

$updateThis = new checkin_update($checkinID, $timeToAdd);
$result = $updateThis->updateEndTime();

if ($result === true) {
    $response["result"] = "SUCCESS";
} else {
    $response["result"] = "Failed to insert new end time";
}

echo json_encode($response);