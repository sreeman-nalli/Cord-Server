<?php
require_once "fcmSqlInsert.php";

/*Uses the object created in fcmSqlInsert.php to change the Firebase FCM token associated with
a user. This ensures that one user can have only one FCM token.*/

$fcm_token = $_GET["fcm_token"];
$user_id = $_GET["user_id"];

$insertion = new fcmSqlInsert();

$alreadyInserted = $insertion->fcmSelection($fcm_token);
if ($alreadyInserted === 1) {
    $result = $insertion->fcmUpdate($user_id, $fcm_token);
    if ($result === false) {
        $response["result"] = "UPDATE FAIL";
    } else {
        $response["result"] = "UPDATE SUCCESS";
    }
} else {
    $result = $insertion->fcmInsertion($user_id, $fcm_token);
    if ($result == false) {
        $response["result"] = "INSERT FAIL";
    } else {
        $response["result"] = "INSERT SUCCESS";
    }
}

echo json_encode($response);
