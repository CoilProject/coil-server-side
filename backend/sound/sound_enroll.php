<?php
include("../coil_util.php");
include("../db_insert_module.php");


if($value['build_version'] >= V1 && $value['build_version'] < V1_END){
	$db_insert = new InsertDB($conn);
	if($response['sound_enroll'] = $db_insert->insertUserSound($value['user_id'], $value['contents'], $value['type'])){
		$response['message'] = "문의사항이 정상 등록되었습니다";
	}else{
		$response['error_message'] = "문의사항 등록에 문제가 있습니다";
	}
}else{

}

echo json_encode($response);

?>