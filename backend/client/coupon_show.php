<?php
include("../coil_util.php");
include("../db_select_module.php");


if($value['build_version'] >= V1 && $value['build_version'] < V1_END){
	$db_select = new SelectDB($conn);
	$result = $db_select->findUserByUserId(COUPON_TABLE, $value['user_id']); // 결과를 모두 뽑느다
	$response['coupon_list'] = array();
	$cnt = 0;
	while($row2 = mysqli_fetch_assoc($result)){
		$obj = new CouponInfo;
		$row = $db_select->findStoreInfoByCouponId($row2['coupon_id']);
		$obj->coupon_id = $row['coupon_id'];
		$obj->store_id = $row['store_id'];
		$obj->store_name = $row['store_name'];
		$obj->current_stamp = $row['current_stamp'];
		$obj->max_stamp = $row['max_stamp'];
		$obj->created = $row['created'];
		array_push($response['coupon_list'], $obj);
		$cnt = $cnt + 1;
	}
	$response['coupon_count'] = $cnt;
}else{

}

class CouponInfo{
	public $coupon_id, $store_id, $store_name, $current_stamp, $max_stamp, $created;
}

echo json_encode($response);

?>