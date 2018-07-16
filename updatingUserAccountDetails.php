<?php
include_once "userDetails.php";

/*Uses the object from userDetails.php to update the database when a user changes
their personal information on the client.*/

$userId = $_GET['user_id'];

$user = new singleUserDetails();
$result = $user->updateSingleUserDetails($_GET['user_id'], $_GET['firstName'], $_GET['lastName'], $_GET['cellNumber'], $_GET['email']);

if ($result === true) {
    $response["result"] = "SUCCESS";
} else {
    $response["result"] = "Failed to update user details";
}

echo json_encode($response);
