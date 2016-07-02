<?php
include("../coil_util.php");
include("../db_select_module.php");
include("../../gcm_push/gcm-push-module.php");

$apiKey = 'AIzaSyCSZ1QWpj2gB6gvS_jYcJICgtOMzLizq2I';
//array_push($devices, $_POST['gcm_token']);
$title = 'Coil';
//$message = 'Hello Coil';
//$gcm_token = 'emKN3NqUj8I:APA91bHEp4QDjfYEWrH1JLdhSUD6zsqlqv8iL6fA319DKauPV7UNIFBfirC56XF1qVhhbe6bDjvyh6cxw51S_o9kWfElw_7KtIhS38C8lKx3zroH2cwrdmdevmf8CjEN-Fj1msAg1gvT';

// $pusher = new GCMPushMessage($apiKey, true);
// $pusher->setDevices($gcm_token);
// $response = $pusher->send($title, $message, $extra);

// print_r($response);
$db_select = new SelectDB($conn);
if($result = $db_select->findRowByTwoTable(USER_TABLE, GCM_TABLE, "user_id", "user_id", $_GET['user_id'])){
	$pusher = new GCMPushMessage($apiKey, true);
	$token_array = array();
	while($row = mysqli_fetch_assoc($result)){
		if($row['user_permission'] == P_SHOP){
			// 요청 주체가 업주일 경우
			$message = "업주입니다";
		}else if($row['user_permission'] == P_ADMIN){
			// 요청 주체가 관리자일 경우
			$message = "관리자입니다";
		}else{
			$message = "찬규 힘내라!ㅋㅋ";
		}
		array_push($token_array, $row['gcm_token']);
	}
	$pusher->setDevices($token_array);
	$response = $pusher->send($title, $message, $extra);
}else{

}
print_r($response);
?>