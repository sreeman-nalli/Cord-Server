<?php
require_once "overdueCheckins.php";
require_once "sendOverDueWarnings.php";

/*This file is executed by the Crontab on the server. It uses the data from the overdueCheckins.php object and feeds that data
to sendOverDueWarnings.php, where warnings are sent*/

$overdue = new overdueCheckins();

$anyoverdue = $overdue->queryOverDueCheckins();
$rownum = $overdue->getRowNumber();

$needWARNING = $overdue->getResult();

$sendWarnings = new sendOverDueWarnings($needWARNING);




