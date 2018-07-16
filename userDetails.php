<?php
include_once "DbConnection.php";

/*Creates an object that can be used to create a new user in the database when a new user registers.
Allows data in the database to be modified when the user changes their personal details or who to contact.
Allows the data in the database to be returned to the client for display purposes*/

class singleUserDetails {

    private $dbcon;
    private $result;
    private $rowCount;

    public function __construct()
    {
        $this->dbcon = new DbConnection();
    }

    //Takes:
    //1)  a string of filed name eg. id or username or cellnumber
    //2) another string of data eg. dylanNZ or 0210231234
    public function selectSingleUserQuery($field, $data)
    {
        $sqlStr = "select * from users where ".$field." = "."'$data'";

        $this->result = $this->dbcon->executeSelectQuery($sqlStr);
        $this->rowCount = $this->dbcon->getRowCount();

        return $this->rowCount;
    }

    public function insertSingleUserQuery($username, $email, $pwd)
    {
        //Checking if this user already exists.
        // If False, it inserts the new user, else returns false;
        $testUser = new singleUserDetails();
        $testResult = $testUser->selectSingleUserQuery("username", $username);
        if ($testResult === 0) {
                $sqlStr = "insert into users values (NULL, '".$username."', '".$pwd."', NULL, NULL, '".$email."', NULL)";
                $insertResult = $this->dbcon->executeInsertQuery($sqlStr);
                $this->rowCount = $this->dbcon->getRowCount();

                if ($insertResult === true) {

                    //The select method below updates the user details in this object for future use
                    $this->selectSingleUserQuery("username", $username);
                    return true;
                } else {
                    //Here, it doesn't seem to insert the new user for some random reason.
                    //Internal Reasons.
                    return 'Internal Error';
                }
        } else {
            return false;
        }
    }

    public function updateSingleUserDetails($user_id, $firstName, $lastName, $cellNumber, $email)
    {
        $sqlStr = "UPDATE users SET fname = '".$firstName."', lname = '".$lastName."', cellnumber = '".$cellNumber."', emailaddress = '".$email."' WHERE id = ".$user_id;

        $updateResult = $this->dbcon->executeInsertQuery($sqlStr);

        if ($updateResult === true) {
            $this->selectSingleUserQuery("id", $user_id);
            return true;
        } else {
            return false;
        }
    }

    public function updateAnotherUserToContact($userID, $anotherUserID)
    {
        $sqlStr = "UPDATE who_to_contact SET person_to_notify_id='".$anotherUserID."' WHERE user_id='".$userID."'";
        $result = $this->dbcon->executeInsertQuery($sqlStr);
        if($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        if ($this->result == false) {
            return false;
        }
        return $this->result[0]['id'];
    }

    public function getUsername()
    {
        if ($this->result == false) {
            return false;
        }
        return $this->result[0]['username'];
    }

    public function getPassword()
    {
        if ($this->result == false) {
            return false;
        }
        return $this->result[0]['password'];
    }

    public function getFname()
    {
        if ($this->result == false) {
            return false;
        }
        return $this->result[0]['fname'];
    }

    public function getLname()
    {
        if ($this->result == false) {
            return false;
        }
        return $this->result[0]['lname'];
    }

    public function getEmailaddress()
    {
        if ($this->result == false) {
            return false;
        }
        return $this->result[0]['emailaddress'];
    }

    public function getCellnumber()
    {
        if ($this->result == false) {
            return false;
        }
        return $this->result[0]['cellnumber'];
    }

    //Returns all rows of Information
    public function getResult()
    {
        if ($this->result == false) {
            return false;
        }
        return $this->result;
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }
}