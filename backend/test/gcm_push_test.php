<?php
include("../coil_util.php");
include("../db_select_module.php");
include("../../gcm_push/gcm-push-module.php");

$apiKey = 'AIzaSyCSZ1QWpj2gB6gvS_jYcJICgtOMzLizq2I';
//array_push($devices, $_POST['gcm_token']);
$title = 'Coil';
$message = 'Hello Coil';
$gcm_token = 'dr9LrStTGEY:APA91bEbcBrWC68cNtlJVQQtBYCZ5fxZhkkWQdbo56fQw8HsGvU-eFt7Xu1wo16M1ADfIYjIsJoB_I_EHU7fn5RaNK6HAXLjjzfWls3EStHRNhsyJFAtrUZIuxeEFpkdEZDvuYbUoOAO';

// $pusher = new GCMPushMessage($apiKey, true);
// $pusher->setDevices($gcm_token);
// $response = $pusher->send($title, $message, $extra);

// print_r($response);
$db_select = new SelectDB($conn);
if($result = $db_select->findUserByUserId(USER_TABLE, "shop1@shop", 1)){
	if($result['user_permission'] == P_SHOP){
			// 요청 주체가 업주일 경우
		$message = "업주입니다";
	}else if($result['user_permission'] == P_ADMIN){
			// 요청 주체가 관리자일 경우
		$message = "관리자입니다";
	}
	$pusher = new GCMPushMessage($apiKey, true);
	$pusher->setDevices($gcm_token);
	$response = $pusher->send($title, $message, $extra);
}else{

}
print_r($response);
?>