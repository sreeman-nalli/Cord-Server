<?php
include_once "DbConnection.php";

/*Creates an object that can return data associated with a ongoing activity to be displayed on the client*/

class ongoingActivityObject {
    private $dbcon;
    private $result;
    private $rowCount;


    public function __construct()
    {
        $this->dbcon = new DbConnection();
    }

    public function selectSingleActivityQuery($id)
    {
        $sqlStr = "select * from checkin_setup where user_id = "."'$id' AND completed = '0'";

        $this->result = $this->dbcon->executeSelectQuery($sqlStr);
        $this->rowCount = $this->dbcon->getRowCount();

        return $this->rowCount;
    }

    /** if needed to diaplay all past history activities     */
    public function selectAllPastActivityQuery($id)
    {

    }

    public function getActivityID()
    {
        return $this->result[0]['id'];
    }

    public function getStartTime()
    {
        return $this->result[0]['start_time'];
    }
    public function getEndTime()
    {
        return $this->result[0]['end_time'];
    }

    public function getStartLocationLatitude()
    {
        return $this->result[0]['start_location_lat'];
    }
    public function getStartLocationLongitude()
    {
        return $this->result[0]['start_location_long'];
    }

    public function getWarningSent()
    {
        return $this->result[0]['warning_sent'];
    }

    public function getActivityStatus()
    {
        if ($this->result[0]['completed'] === 1) {
            return true;
        } else {
            return false;
        }
    }
}