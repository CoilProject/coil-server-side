<?php
include("../coil_util.php");
include("../db_select_module.php");

if($value['build_version'] >= V1 && $value['build_version'] < V1_END){

	$db_select = new SelectDB($conn);
	if($db_select->loginCheck($value['user_id'], $value['user_pw'])){
		$response['login'] = true;
		$response['message'] = "환영합니다";
	}else{
		$response['login'] = false;
		$response['error_message'] = "이메일 또는 비밀번호가 잘못되었습니다";
	}
	
}else{

}

echo json_encode($response);


// $result = $db_select->getUserTable();
// $row = mysqli_fetch_assoc($result);
// echo $row['user_id'];

// $sql = "SELECT * FROM ".USER_TABLE;
// $result  = mysqli_query($conn, $sql);
// $row = mysqli_fetch_assoc($result);
// if(is_null($row)){
// 	echo "hh";
// }else{
// 	echo "qq";
// }


?>