<?php
include("../coil_util.php");
include("../../gcm_push/gcm-push-module.php");
include("../db_select_module.php");


if($value['build_version'] >= V1 && $value['build_version'] < V1_END){
	// TODO : 아이디를 이용해서 GCM정보를 찾아야한다.
	$db_select = new SelectDB($conn);
	if($result = $db_select->findUserByUserId(USER_TABLE, $value['user_id'], 1)){
		if($result['user_permission'] == P_SHOP){
			
		}
		$apiKey = 'AIzaSyCSZ1QWpj2gB6gvS_jYcJICgtOMzLizq2I';
		//array_push($devices, $_POST['gcm_token']);
		$title = $_POST['gcm_title'];
		$message = $_POST['gcm_message'];
		
		$pusher = new GCMPushMessage($apiKey, true);
		$pusher->setDevices($_POST['gcm_token']);
		$response = $pusher->send($title, $message, $extra);
	}else{

	}
	
}else{

}

echo json_encode($response);

?>