<?php
include_once "userDetails.php";
require_once "setupWhoToContact.php";

/*Registers a new user and returns any error messages.*/

$username = $_GET['username'];
$email = $_GET['email'];
$hashPwd = $_GET['password'];

$user = new singleUserDetails();
$result = $user->insertSingleUserQuery($username, $email, $hashPwd);

if ($result === false) {
    $response["result"] = "Exists";
} else {
    $userContacts = new setupWhoToContact($user->getId(), "", "", "");
    $result = $userContacts->insertContact();
    if ($result) {
        $response["result"] = "SUCCESS";
        $response["user_id"] = $user->getId();
    }else {
        $response["result"] = "Failed to Register User";
    }
}

echo json_encode($response);