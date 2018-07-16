<?php
include_once "sportUpdate.php";

/*Uses the object in sportsUpdate.php to change data in the database if the
user should change their sports preferences*/

$userID = $_GET["user_id"];
$sportsArray = $_GET["sportsArray"];

$sportsArray = json_decode($sportsArray);

$updateVar = new sportUpdate();
$updateVar->updateUserList($sportsArray, $userID);
$response["result"] = "SUCCESS";

echo json_encode($response);