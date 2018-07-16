<?php
require_once "DbConnection.php";

/*Create an object that can be used to change the FCM token associated with a user.
This means there ensures that user ID's and FCM tokens are unique in the database table fcm_token*/

class fcmSqlInsert {
    private $dbcon;
    private $result;
    private $rowCount;

    public function __construct()
    {
        $this->dbcon = new DbConnection();
    }

    public function fcmSelection($token)
    {
        $sqlStr = "Select * from fcm_token where fcm_token = '".$token."'";

        $this->result = $this->dbcon->executeSelectQuery($sqlStr);
        $this->rowCount = $this->dbcon->getRowCount();

        return $this->rowCount;
    }

    public function fcmInsertion($userID, $token)
    {
        $sqlStr = "INSERT INTO fcm_token VALUES('".$userID."', '".$token."')";
        $this->result = $this->dbcon->executeInsertQuery($sqlStr);

        return $this->result;
    }

    public function fcmUpdate($userID, $token)
    {
          $sqlStr = "DELETE FROM fcm_token WHERE fcm_token = '".$token."' OR user_id = '".$userID."'";
          $result = $this->dbcon->executeInsertQuery($sqlStr);
          if($result === true){
              $this->result = $this->fcmInsertion($userID, $token);
              return $this->result;
          } else {
              return false;
          }
    }

    public function getResult()
    {
        return $this->result;
    }
}