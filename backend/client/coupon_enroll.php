<?php
include("../coil_util.php");
include("../db_insert_module.php");
include("../db_update_module.php");

if($value['build_version'] >= V1 && $value['build_version'] < V1_END){
	$db_insert = new InsertDB($conn);
	if($response['enroll'] = $db_insert->downCoupon($value['user_id'], $value['store_id'])){
		// success
		$response['message'] = "쿠폰이 다운로드 되었습니다";
		$db_update = new UpdateDB($conn);
		$db_update->changeUserDown($value['store_id'], 1);
		

	}else{
		// fail
		$response['error_message'] = "쿠폰 다운로드에 오류가 발생했습니다";
	}
}else{

}

echo json_encode($response);

?>