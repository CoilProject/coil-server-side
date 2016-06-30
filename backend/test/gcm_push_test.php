<?php
include("../../gcm_push/gcm-push-module.php");

$apiKey = 'AIzaSyCSZ1QWpj2gB6gvS_jYcJICgtOMzLizq2I';
//array_push($devices, $_POST['gcm_token']);
$title = 'Coil';
$message = 'Hello Coil';
$gcm_token = 'dr9LrStTGEY:APA91bEbcBrWC68cNtlJVQQtBYCZ5fxZhkkWQdbo56fQw8HsGvU-eFt7Xu1wo16M1ADfIYjIsJoB_I_EHU7fn5RaNK6HAXLjjzfWls3EStHRNhsyJFAtrUZIuxeEFpkdEZDvuYbUoOAO';

$pusher = new GCMPushMessage($apiKey, true);
$pusher->setDevices($gcm_token);
$response = $pusher->send($title, $message, $extra);

print_r($response);
?>