<?php
include("../coil_util.php");
include("../db_select_module.php");
include("../db_insert_module.php");

if($value['build_version'] >= V1 && $value['build_version'] < V1_END){
	$db_select = new SelectDB($conn);
	if(!$db_select->findUserByUserId(USER_TABLE, $value['user_id'], 1)){
		// 유저를 찾을 수 없다 -> 가입 가능하다
		$response['join'] = true;
		$db_insert = new InsertDB($conn);
		if($response['join'] = $db_insert->insertNewMember($value['user_id'], $value['user_pw'])){
			$response['message'] = "회원가입에 성공하였습니다";
		}else{
			$response['error_message'] = "회원가입이 실패하였습니다";
		}
	}else{
		// 유저를 찾을 수 있다 -> 가입 불가능하다
		$response['join'] = false;
		$response['error_message'] = "동일한 계정이 이미 존재합니다";
	}
}else{

}

echo json_encode($response);

?>