<?php
include_once "userDetails.php";

/*Validates the username exists and returns the hashed and salted password if it exists.
The client side then validates the passwords match to allow access to the application*/

$name = $_GET['name'];

$user = new singleUserDetails();
$result = $user->selectSingleUserQuery("username", $name);

if ($result === false) {
    $response["result"] = "FAILURE to get Data from DATABASE";
} else {
    if ($user->getUsername() === $name && $user->getRowCount() === 1) {

        $response["result"] = "SUCCESS";
        $response["user_id"] = $user->getId();
        $response["hashedPassword"] = $user->getPassword();
    } else {
        $response["result"] = "Invalid username or password";
    }
}

echo json_encode($response);


