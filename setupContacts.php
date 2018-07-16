<?php
require_once "setupWhoToContact.php";

/*Uses the object created in setupWhoToContact.php to allow the user to designate who they would
like get warnings if they should not return from an activity*/

$userID = $_GET["user_ID"];
$anotherUser = $_GET["anotherUser"];
$contactNumber = $_GET["contactNumber"];
$contactEmail = $_GET["contactEmail"];

$userContacts = new setupWhoToContact($userID, $anotherUser, $contactEmail, $contactNumber);
$result = $userContacts->setupContacts();

if ($result === true) {
    $response["result"] = "SUCCESS";
} else if ($result === false) {
    $response["result"] = "This user has already been set to be notified";
} else {
    $response["result"] = "User doesn't Exist";
}

echo json_encode($response);
