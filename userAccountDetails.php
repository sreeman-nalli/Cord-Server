<?php
include_once "userDetails.php";

/*Returns user information from the object in userDetails.php to display data on the client*/

$userId = $_GET['user_id'];

$user = new singleUserDetails();
$result = $user->selectSingleUserQuery("id", $userId);

if ($result == 1) {
    $response["firstName"] = $user->getFname();
    $response["lastName"] = $user->getLname();
    $response["email"] = $user->getEmailaddress();
    $response["cellNumber"] = $user->getCellnumber();
    $response["result"] = "SUCCESS";
} else {
    $response["result"] = "Failed to find user";
}

echo json_encode($response);