<?php
require_once "DbConnection.php";
require_once "userDetails.php";

/*Creates an object that allows the insertion of data into the database linked to who the user would like warnings
to be sent to if they should fail to check back in from an activity*/

class setupWhoToContact {
    private $dbcon;
    private $userID;
    private $result;
    private $newIDForNotification;
    private $newContactEmailNotification;
    private $newCellNumNotification;
    private $currentPersonToNofityID;
    private $currentPersonToNotifyEmail;
    private $currentPersonToNotifyCellNum;

    public function __construct($userID, $anotherID, $emailAddress, $cellnumber)
    {
        $this->dbcon = new DbConnection();

        $this->userID = $userID;
        $this->newIDForNotification = $anotherID;
        $this->newContactEmailNotification = $emailAddress;
        $this->newCellNumNotification = $cellnumber;

    }

    public function insertContact ()
    {
        $sqlInsertStr = "INSERT INTO who_to_contact VALUES ('" . $this->userID . "',NULL, NULL, NULL)";
        $result = $this->dbcon->executeInsertQuery($sqlInsertStr);

        return $result;
    }

    public function getPersonToNotifyUsername()
    {
        $sqlStr = "SELECT * FROM who_to_contact WHERE user_id='".$this->userID."'";
        $this->result = $this->dbcon->executeSelectQuery($sqlStr);

        $rowcount = $this->dbcon->getRowCount();
        if ($rowcount === 1) {
            $this->currentPersonToNofityID = $this->result[0]["person_to_notify_id"];
            if ($this->currentPersonToNofityID === "null") {
                return false;
            } else {
                $contactUser = new singleUserDetails();
                $contactUser->selectSingleUserQuery("id", $this->currentPersonToNofityID);
                if ($contactUser->getRowCount() === 1) {
                    return $contactUser->getUsername();
                } else {
                    return false;
                }
            }
        }
    }

    public function setupContacts()
    {
        $sqlStr = "SELECT * FROM who_to_contact WHERE user_id='".$this->userID."'";
        $this->result = $this->dbcon->executeSelectQuery($sqlStr);
        if ($this->result) {
            $rowcount = $this->dbcon->getRowCount();
            if ($rowcount === 1) {
                $this->currentPersonToNofityID = $this->result[0]["person_to_notify_id"];
                $this->currentPersonToNotifyEmail = $this->result[0]["person_to_notify_email"];
                $this->currentPersonToNotifyCellNum = $this->result[0]["person_to_notify_cellnum"];
                $contactResult = $this->contactAnotherUser();
                if ($contactResult === false) {
                    return false;
                } else if ($contactResult === "Doesn't Exist") {
                    return $contactResult;
                }

                //There are no checks because SMS and Email is not yet setup
                $this->contactEmail();
                $this->contactCellNumber();
                return true;

            }else  if ($rowcount === 0) {
                $contactUser = new singleUserDetails();
                $contactUser->selectSingleUserQuery("username", $this->newIDForNotification);
                if ($contactUser->getRowCount() === 1) {
                    $id = $contactUser->getId();
                    $sqlInsertStr = "INSERT INTO who_to_contact VALUES ('" . $this->userID . "','" . $id . "','" . $this->newCellNumNotification . "','" . $this->newContactEmailNotification . "')";
                    $result = $this->dbcon->executeInsertQuery($sqlInsertStr);

                    //return $result;
                } else {
                    //echo " rowcount = 0";
                    //return false;
                }
            } else {
                //echo "Error: Multiple users exist with the same ID";
                //return "Error: Multiple users exist with the same ID";
            }
        } else {
            //echo "User does not exist";
            //return false;
        }
    }

    function contactAnotherUser()
    {
        $contactUser = new singleUserDetails();
        $contactUser->selectSingleUserQuery("username", $this->newIDForNotification);
        if ($contactUser->getRowCount() === 1) {
            //echo "user exists <br>";
            $userToContactID = $contactUser->getId();
            //echo "user to contact ID = ".$userToContactID."<br>";
            if ($this->currentPersonToNofityID === $userToContactID) {
                return false;
                //echo "Error: user is already set to be contacted <br>";
            } else {
                //echo "Updating user to contact <br>";
                $result = $contactUser->updateAnotherUserToContact($this->userID, $userToContactID);
                if ($result) {
                    //echo "Update complete <br>";
                    return true;
                } else {
                    return false;
                    //echo "Update failed <br>";
                }
            }
        } else {
            return "Doesn't Exist";
            //echo "User to contact does not exist <br>";
        }
    }

    function contactEmail()
    {
        if ($this->currentPersonToNotifyEmail === $this->newContactEmailNotification) {
            //return false;
            //echo "Email already set <br>";
        } else {
            //echo "Updating email <br>";
            $sqlStr = "UPDATE who_to_contact SET person_to_notify_email='".$this->newContactEmailNotification."' WHERE user_id='".$this->userID."'";
            //echo "UPDATE 1";
            $result = $this->dbcon->executeInsertQuery($sqlStr);
            if ($result) {
                //return true;
                //echo "email update complete <br>";
            } else {
                //return false;
                //echo "email update failure <br>";
            }
        }
    }

    function contactCellNumber()
    {
        if ($this->currentPersonToNotifyCellNum === $this->newCellNumNotification) {
            //return false;
            //echo "The contact number is already set <br>";
        } else {
            //echo "Updating contact number <br>";
            $sqlStr = "UPDATE who_to_contact SET person_to_notify_cellnum='".$this->newCellNumNotification."' WHERE user_id='".$this->userID."'";
            echo "UPDATE 2";
            $result = $this->dbcon->executeInsertQuery($sqlStr);
            if ($result) {
                //return true;
                //echo "Number update complete <br>";
            } else {
                //return false;
                //echo "Number update failure <br>";
            }
        }
    }

}