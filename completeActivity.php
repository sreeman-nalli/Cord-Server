<?php
require_once "DbConnection.php";

/*Creates an object that allows the completion of a single activity*/

class completeActivity {
    private $dbcon;

    public function __construct()
    {
        $this->dbcon = new DbConnection();
    }

    public function endActivity($checkinID)
    {
        $sqlStr = "UPDATE checkin_setup SET completed_time=UTC_TIMESTAMP(), completed=1 WHERE id='".$checkinID."'";
        $result = $this->dbcon->executeInsertQuery($sqlStr);

        return $result;
    }
}