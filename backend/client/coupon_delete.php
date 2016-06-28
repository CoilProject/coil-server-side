<?php
include("../coil_util.php");
include("../db_delete_module.php");

if($value['build_version'] >= V1 && $value['build_version'] < V1_END){
	$db_delete = new DeleteDB($conn);
	$db_delete->setUserId($value['user_id']);
	if($response['delete_state'] = $db_delete->deleteRow(COUPON_TABLE, "coupon_id", $value['coupon_id'])){
		$response['message'] = "쿠폰이 정상적으로 삭제되었습니다";
	}else{
		$response['error_message'] = "쿠폰 삭제가 취소되었습니다";
	}
}else{

}

echo json_encode($response);

?>