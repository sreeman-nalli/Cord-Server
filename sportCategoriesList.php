<?php
include_once "DbConnection.php";

/*Returns a list of all the activity categories that are currently available in the database*/

$dbcon = new DbConnection();
$sqlStr = "SELECT * FROM sport_categories";

$result = $dbcon->executeSelectQuery($sqlStr);
$rowCount = $dbcon->getRowCount();

if ($rowCount > 0) {
    $response ["sports"] = $result;
    $response ["result"] = "SUCCESS";
} else {
    $response["result"] = "No categories in the database";
}

echo json_encode($response);