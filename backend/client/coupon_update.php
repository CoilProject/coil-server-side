<?php
include("../coil_util.php");
include("../db_select_module.php");
include("../db_update_module.php");
include("../db_insert_module.php");

if($value['build_version'] >= V1 && $value['build_version'] < V1_END){
	$db_select = new SelectDB($conn);
	if($row = $db_select->findStoreInfoByCouponId($value['coupon_id'])){
		if($row['is_full']){
			// 꽉찬 경우는 추가 업데이트를 하지 않는다
			$response['update_state'] = 0;
			$response['message'] = "가득찬 쿠폰입니다";
		}else{
			// 아직 꽉차지 않은 경우이다
			$db_update = new UpdateDB($conn);
			if($row['max_stamp'] > $row['current_stamp'] + $value['stamp_num']){

				if($db_update->stampUpdate($value['user_id'], $value['coupon_id'], $value['stamp_num'])){
					$response['update_state'] = 1; // all thing success
					$response['message'] = "도장 업데이트에 성공하였습니다";
				}else{
					$response['update_state'] = -1; // update fail
					$response['error_message'] = "도장 업데이트가 취소되었습니다";
				}
			}else{
				// 도장 최대 개수를 더 넘는 추가 도장 요청이 왔을 경우
				// 현재 쿠폰을 max만큼 채우고
				// 다른 쿠폰 하나를 더 생성해 그 속에 남은 도장을 넣어준다
				$diff = $row['max_stamp'] - $row['current_stamp'];
				$addi = $value['stamp_num'] - $diff;
				if($db_update->stampUpdate($value['user_id'], $value['coupon_id'], $diff)){
					$response['update_state'] = 3; // 쿠폰이 가득차고 추가로 쿠폰을 할당해서 나머지 차이만큼 도장을 찍어주기
					$response['message'] = "쿠폰이 가득찼습니다!";
					//  is_full -> true
					$db_update->updateTable(COUPON_TABLE, "is_full", true, "coupon_id", $value['coupon_id']);
					
					$db_insert = new InsertDB($conn);
					if($response['additional_enroll'] = $db_insert->downCoupon($value['user_id'], $row['store_id'])){
						// success
						$response['message2'] = "새로운 쿠폰이 자동으로 추가됩니다";
						$db_update->changeUserDown($row['store_id'], 1);
						$row2 = $db_select->findRowByRecently(COUPON_TABLE, "user_id", $value['user_id'], 1);
						if($db_update->stampUpdate($value['user_id'], $row2['coupon_id'], $addi)){
							$response['message3'] = "새로운 쿠폰 도장 업데이트에 성공하였습니다";
						}else{
							$response['error_message'] = "도장 업데이트가 취소되었습니다";
						}
					}else{
						// fail
						$response['error_message'] = "새로운쿠폰 다운로드에 오류가 발생했습니다";
					}
				}else{
					$response['update_state'] = -1; // update fail
					$response['error_message'] = "도장 업데이트가 취소되었습니다";
				}
			}
		}
	

	}else{
		// $row 를 찾지 못했을 경우
	}


}else{

}

echo json_encode($response);