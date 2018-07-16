<?php
require_once "DbConnection.php";

/*Creates and object that returns an array of overdue activities (if any) that
is used by the server, which calls overdueTest.php to send warnings*/

class overdueCheckins {
    private $dbcon;
    private $rowCount;
    private $result;

    public function __construct()
    {
        $this->dbcon = new DbConnection();
    }

    public function queryOverDueCheckins()
    {
        $sqlStr = "SELECT * FROM checkin_setup WHERE end_time < NOW() 
                   AND completed = 0 AND warning_sent=0";
        $this->result = $this->dbcon->executeSelectQuery($sqlStr);
        $this->rowCount = $this->dbcon->getRowCount();
        return $this->result;
    }

    public function getRowNumber()
    {
        return $this->rowCount;
    }

    public function getResult()
    {
        return $this->result;
    }

}



