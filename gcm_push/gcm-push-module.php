<?php
/*
    Class to send push notifications using Google Cloud Messaging for Android
 
    Example usage
    -----------------------
    $an = new GCMPushMessage($apiKey, $is_notification);
    $an->setDevices($devices);
    $response = $an->send($message);
    -----------------------
     
    $apiKey Your GCM api key
    $devices An array or string of registered device tokens
    $message The mesasge you want to push out
 
    @author Matt Grundy, Brian Lee
 
    Adapted from the code available at:
    http://stackoverflow.com/questions/11242743/gcm-with-php-google-cloud-messaging
 
*/
class GCMPushMessage {
 
    private $url = 'https://android.googleapis.com/gcm/send';
    private $serverApiKey = "";
    private $devices = array();
    private $notification_type;
 
    function GCMPushMessage($apiKeyIn, $is_notification){
        $this->serverApiKey = $apiKeyIn;
        $this->notification_type = $is_notification;
    }
 
    function setDevices($deviceIds){
 
        if(is_array($deviceIds)){
            $this->devices = $deviceIds;
        } else {
            $this->devices = array($deviceIds);
        }
 
    }
 
    function send($title, $message, $extra){
 
        if(!is_array($this->devices) || count($this->devices) == 0){
            $this->error("No devices set");
        }
 
        if(strlen($this->serverApiKey) < 8){
            $this->error("Server API Key not set");
        }
 
 
        $fields = array(
            'registration_ids'  => $this->devices,
            'data'              => array( 'title' => $title, 'message' => $message, 'notification_type' => $this->notification_type, 'extra' => $extra ),
        ); 
 
 
        //echo json_encode($fields);
        //exit;
 
 
        $headers = array( 
            'Authorization: key=' . $this->serverApiKey,
            'Content-Type: application/json'
        );
 
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt( $ch, CURLOPT_URL, $this->url );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
 
        // Execute post
        $result = curl_exec($ch);
 
        // Close connection
        curl_close($ch);
 
        return $result;
    }
 
    function error($msg){
        echo "Android send notification failed with error:";
        echo "\t" . $msg;
        exit(1);
    }
}
 
?>