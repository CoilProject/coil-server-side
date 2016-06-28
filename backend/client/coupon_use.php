<?php
include("../coil_util.php");
include("../db_select_module.php");
include("../db_delete_module.php");

define("TYPE_COUPON_USE", 1);

if($value['build_version'] >= V1 && $value['build_version'] < V1_END){
	$db_select = new SelectDB($conn);
	if($row = $db_select->findRowByCondition(COUPON_TABLE, "coupon_id", $value['coupon_id'], 1)){
		if($row['is_full']){
			$db_delete = new DeleteDB($conn);
			$db_delete->setUserId($value['user_id']);
			if($db_delete->deleteRow(COUPON_TABLE, "coupon_id", $value['coupon_id'], TYPE_COUPON_USE)){
				$response['coupon_use'] = true;
				$response['message'] = "쿠폰 사용이 정상처리 되었습니다";
			}else{
				$response['coupon_use'] = false;
				$response['error_message'] = "쿠폰 사용처리에 오류가 있습니다";
			}
		}else{
			$response['coupon_use'] = false;
			$response['error_message'] = "쿠폰을 아직 사용할 수 없습니다";
		}
	}else{
		$response['coupon_use'] = false;
		$response['error_message'] = "적절하지 않은 쿠폰ID 입니다";
	}
}else{

}

echo json_encode($response);

?>