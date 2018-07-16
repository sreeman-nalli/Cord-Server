<?php
require_once "completeActivity.php";

/*Uses the object from completeActivity.php to end an activity when the user hits the
'END TASK' button*/

$actID = $_GET["id"];

$endIT = new completeActivity();

$result = $endIT->endActivity($actID);

if ($result === true) {
    $response["result"] = "SUCCESS";
} else {
    $response["result"] = "Failed to end task";
}

echo json_encode($response);