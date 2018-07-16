<?php

/*Creates an object that takes the FCM token and sends a push notification
to the device registered with the token*/

class sendOverduePushNotification {
    private $fcm_token;

    public function __construct($token)
    {
        $this->fcm_token = $token;
    }

    public function sendNotification()
    {
        //define('API_ACCESS_KEY','$key')
        define('API_ACCESS_KEY','AIzaSyAdFKnFQ4j2HTlJTYA7QXVKiT9U45GAiVA');
        $registrationIds = [$this->fcm_token];
        $msg = ['title' => 'CORD WARNING', 'body' => 'USER FAILED TO CHECKIN'];
        $fields = ['registration_ids' => $registrationIds, 'notification' => $msg];
        $headers = ['Authorization: key=' . API_ACCESS_KEY, 'Content-Type: application/json'];
        $fields = json_encode( $fields );
        $ch = curl_init();

        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, $fields );
        $result = curl_exec($ch );
        curl_close( $ch );
        echo $result;
    }
}
