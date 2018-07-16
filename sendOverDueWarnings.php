<?php
require_once "DbConnection.php";
require_once "sendOverduePushNotification.php";

/*Create an object that sends warnings via the three methods (Push notification, email, SMS)
NOTE: SMS is not implemented due to scope and emails, although sent, do not get delivered due
to the CORD server not being authenticated and the blocks that stop spam emails*/

class sendOverDueWarnings {
    private $dbcon;
    private $toBeWanred;
    private $numberToNotify; //Used to send SMS notifications
    private $emailToNotify;
    private $userToNotify;
    private $userID;

    public function __construct($toBeWarned)
    {
        $this->dbcon = new DbConnection();
        $this->toBeWanred = $toBeWarned;
        $this->sendWarning();
    }

    function sendWarning()
    {
        foreach ($this->toBeWanred as $user) {
            $this->userID = $user["user_id"];
            $this->getEmail();

        }
    }

    function getEmail()
    {
        $sqlStr = "SELECT person_to_notify_email FROM who_to_contact WHERE user_id='".$this->userID."'";
        $result = $this->dbcon->executeSelectQuery($sqlStr);
        $this->emailToNotify = $result[0]["person_to_notify_email"];
        $this->sendEmail();
        $this->getPushNotificationKey();
        $this->sendSMSNotificatoin();
    }

    function sendEmail()
    {
        if ($this->emailToNotify === null) {
            //echo "This user has no email address for a person to notify. <br>";
        } else {
            $msg = "This is a automated message to send a warning that user " . $this->userID . "was late for a checking";
            $msg = wordwrap($msg, 70);
            //mail("$emailAddress", "CORD WARNING", $msg);
            mail("blah@gmail.com", "CORD WARNING", $msg);
        }
    }

    function getPushNotificationKey()
    {
        $sqlStr = "SELECT person_to_notify_id FROM who_to_contact WHERE user_id='".$this->userID."'";
        $result = $this->dbcon->executeSelectQuery($sqlStr);
        $this->userToNotify = $result[0]["person_to_notify_id"];

        if ($this->userToNotify !== null) {
            $sqlStr = "SELECT fcm_token FROM fcm_token WHERE user_id='".$this->userToNotify."'";
            $result = $this->dbcon->executeSelectQuery($sqlStr);
            $token = $result[0]["fcm_token"];
            //echo "sending notification <br>";
            $sendNotification = new sendOverduePushNotification($token);
            $sendNotification->sendNotification();
            //echo "DONE sending <br>";

        } else {
            //echo "No fcm token <br>";
        }
    }

    function sendSMSNotificatoin()
    {

    }
}