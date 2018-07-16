<?php

/*Create a object that creates a connection with the database.
This is a critical file and is used in most other files*/

class DbConnection {
    private $dbConnection;
    private $tableResult;
    private $rowCount;

    public function __construct()
    {
        $this->dbConnection = mysqli_connect('HOST_NAME','LOGIN_ID','PASSWORD','DATABASE_NAME');
        if (mysqli_connect_error()) {
            echo "Connection to Server Failed.";
            exit(60);
        }
    }

    public function executeSelectQuery($sqlString) {
        $dbResult = mysqli_query($this->dbConnection, $sqlString);

        if (is_object($dbResult)) {
            $this->tableResult = array();
            $this->rowCount = 0;
            while ($row = $dbResult->fetch_assoc()) {
                $this->tableResult[$this->rowCount] = $row;
                ++$this->rowCount;
            }

            return $this->tableResult;
        } else {
            return false;
        }
    }

    public function executeInsertQuery($sqlString) {
        $dbResult = mysqli_query($this->dbConnection, $sqlString);

        if ($dbResult === true) {
            return true;
        } else {
            return false;
        }
    }


    public function getRowCount()
    {
        return $this->rowCount;
    }
}