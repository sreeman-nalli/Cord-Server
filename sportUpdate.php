<?php
include_once "DbConnection.php";

/*Creates an object that is used when a user updates they sports preferences on the client*/

class sportUpdate {
    private $dbcon;
    private $rowCount;

    public function __construct()
    {
        $this->dbcon = new DbConnection();
    }

    public function updateUserList($sportArray, $userId)
    {
        $sqlStr = "DELETE FROM users_sports WHERE user_id = '".$userId."'";
        $this->dbcon->executeInsertQuery($sqlStr);

        foreach ($sportArray as $value) {
            $sqlStr = "INSERT INTO users_sports VALUES ('".$userId."', '".$value."')";
            $this->dbcon->executeInsertQuery($sqlStr);
        }
    }

    public function selectUserList($userId)
    {
        $sqlStr = "SELECT * FROM users_sports WHERE user_id = '".$userId."'";
        $result = $this->dbcon->executeSelectQuery($sqlStr);

        $this->rowCount = $this->dbcon->getRowCount();
        //echo "ROWCOUNT: ".$rowCount;
        if ($this->rowCount > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }
}