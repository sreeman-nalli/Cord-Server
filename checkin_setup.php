<?php
include_once "DbConnection.php";
include_once "ongoingActivityObject.php";

/*Create an object that allows the insertion of one check-in into the database*/

class checkin_setup {
    private $dbcon;
    private $timeStamped;
    private $startTime;
    private $endTime;

    //Create a DbcConnection
    public function __construct()
    {
        $this->dbcon = new DbConnection();
    }

    //Insert a new checkin from a user
    public function insertNewCheckIn($userId, $minsToAdd, $startLocLat, $startLocLon)
    {
        //Checking if the user has another on-going activity;
        $ongoingActivity = new ongoingActivityObject();

        //Returns the number of current activities stated by the user
        $rowCount = $ongoingActivity->selectSingleActivityQuery($userId);

        if ($rowCount === 1) {
            return "On-Going Activity";
        }else if ($rowCount < 1) {
            //Create times
            $this->timeStamped = $_SERVER['REQUEST_TIME'];
            $this->createEndTime($minsToAdd);

            //Create sqlQuery string and attempt insert
            $sqlStr = "INSERT INTO checkin_setup VALUES (NULL, '".$userId."', '".$this->startTime."', '".$this->endTime."',NULL,'".$startLocLat."', '".$startLocLon."',0,0)";
            $insertResult = $this->dbcon->executeInsertQuery($sqlStr);

            //Check insertion was successful
            if ($insertResult === true) {
                return true;
            } else {
                return false;
            }
        }
    }

    //Create the end time based on the current server time + the amount of time the user has stipulated
    private function createEndTime($timeToAdd)
    {
        //Current dateTime
        $this->startTime = date('Y-m-d H:i:s');
        //echo "startTime: " . $this->startTime. "<br>";

        //Future dateTime Calc
        $currentDate = strtotime($this->startTime);
        $futureDate = $currentDate+(60*$timeToAdd);

        //Future dateTime
        $this->endTime = date("Y-m-d H:i:s", $futureDate);
    }
}