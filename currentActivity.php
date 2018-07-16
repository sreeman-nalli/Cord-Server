<?php
include_once "ongoingActivityObject.php";
require_once "setupWhoToContact.php";

/*Uses the object from ongoingActivityObject.php to retrieve data associated
to the current activity as well as who to contact*/

$user_id = $_GET['user_id'];

$currentActivity = new ongoingActivityObject();
$result = $currentActivity->selectSingleActivityQuery($user_id);

$userContacts = new setupWhoToContact($user_id, "", "", "");
$selectResult = $userContacts->getPersonToNotifyUsername();

if ($selectResult === false) {
    $response["personToNotify"] = "Not setup";
} else {
    $response["personToNotify"] = $selectResult;
}

if ($result === 1) {
    $response["activity_id"] = $currentActivity->getActivityID();
    $response["start_time"] = $currentActivity->getStartTime();
    $response["end_time"] = $currentActivity->getEndTime();
    $response["lat"] = $currentActivity->getStartLocationLatitude();
    $response["lng"] = $currentActivity->getStartLocationLongitude();
    $response["result"] = "SUCCESS";
} else {
    $response["result"] = "Failure";
}

echo json_encode($response);