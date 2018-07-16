<?php
include "DbConnection.php";

/*Create an object that can be used to add time to a currently active activity*/

class checkin_update {
    private $dbcon;
    private $currEndTime;
    private $checkinID;
    private $timeToAdd;

    public function __construct($givenCheckinID, $timeToAdd)
    {
        $this->dbcon = new DbConnection();
        $this->checkinID = $givenCheckinID;
        $this->timeToAdd = $timeToAdd;
    }

    public function updateEndTime()
    {
        $this->getEndTime();
        $this->createNewEndTime();
        $result = $this->insertNewEndTime();

        return $result;
    }

    function getEndTime()
    {
        $sqlStr = "SELECT * FROM checkin_setup WHERE id = '".$this->checkinID."'";
        $endTime = $this->dbcon->executeSelectQuery($sqlStr);
        $this->currEndTime = strtotime($endTime[0]["end_time"]);
    }

    function createNewEndTime()
    {
        $newEndTime = $this->currEndTime+(60*$this->timeToAdd);
        $this->currEndTime = date("Y-m-d H:i:s", $newEndTime);
    }

    function insertNewEndTime()
    {
        $sqlStr = "UPDATE checkin_setup SET end_time='".$this->currEndTime."' WHERE id='".$this->checkinID."'";
        $result = $this->dbcon->executeInsertQuery("$sqlStr");

        return $result;
    }
}