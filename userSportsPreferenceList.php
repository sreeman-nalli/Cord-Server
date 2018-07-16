<?php
include_once "sportUpdate.php";

/*Uses the object from sportUpdate.php to return data to the client to
display the users selected sports preferences*/

$userID = $_GET["user_id"];

$updateVar = new sportUpdate();
$result = $updateVar->selectUserList($userID);

if ($result === false) {
    $response["result"] = "Failed to get data OR SPorts preferences not choosen";
} else {
    $response["result"] = "SUCCESS";
    $response["sportsPreferenceList"] = $result;
}

echo json_encode($response);