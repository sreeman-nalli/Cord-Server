<?php
require_once "DbConnection.php";

/*Create an object that inserts one location ping (longitude and latitude) and the current time into the database*/

class onePing {
    private $dbcon;
    private $timeStamp;

    public function __construct()
    {
        $this->dbcon = new DbConnection();
        $this->timeStamp = date('Y-m-d H:i:s');
    }

    public function submitPing($checkinID, $lat, $long)
    {
        $sqlStr = "INSERT INTO user_location_ping VALUES (NULL, '".$checkinID."','".$this->timeStamp."','".$lat."', '".$long."')";
        $result = $this->dbcon->executeInsertQuery($sqlStr);

        return $result;
    }
}