<?php
class UpdateDB extends CoilDB{
	private $conn = 0;
	
	function __construct($connection){
		$this->conn = $connection;
	}
	// GcmToken 을 새로 업데이트 해주는 작업
	function updateGcmToken($user_id, $gcm_token){
		$sql = "UPDATE ".GCM_TABLE." SET gcm_token = '{$gcm_token}' WHERE user_id = '{$user_id}'";
		if(!mysqli_query($this->conn, $sql)){
			//parent::doLogging($this->conn, GCM_TABLE, $user_id, "Gcm Token Update", false);
			return false;
		}else{
			//parent::doLogging($this->conn, GCM_TABLE, $user_id, "Gcm Token Update", true);
			return true;
		}
	}
	function updateTable($table_name, $set_col, $set_value, $where_col, $where_value){
		$sql = "UPDATE {$table_name} SET {$set_col} = '{$set_value}' WHERE {$where_col} = '{$where_value}'";
		return mysqli_query($this->conn, $sql);
	}
	// 도장의 개수를 업데이트 하는 함수
	function stampUpdate($user_id, $coupon_id, $stamp_num){
		$sql = "UPDATE ".COUPON_TABLE." SET current_stamp = current_stamp + {$stamp_num} WHERE coupon_id = {$coupon_id}";
		if(mysqli_query($this->conn, $sql)){
			parent::doLogging($this->conn, COUPON_TABLE, $user_id, "Stamp Num Change : {$stamp_num}", true);
			return true;
		}else{
			parent::doLogging($this->conn, COUPON_TABLE, $user_id, "Stamp Num Change : {$stamp_num}", false);
			return false;
		}
	}
	// 가게 입장에서 본인 쿠폰을 다운받은 유저의 수를 바꾸는 작업
	function changeUserDown($store_id, $num){
		$sql = "UPDATE ".STORE_TABLE." SET user_down = user_down + {$num} WHERE store_id = {$store_id}";
		if(mysqli_query($this->conn, $sql)){
			parent::doLogging($this->conn, STORE_TABLE, $store_id, "User Down Change : {$num}", true);
			return true;
		}else{
			parent::doLogging($this->conn, STORE_TABLE, $store_id, "User Down Change : {$num}", false);
			return false;
		}
	}
	// 본인 도장을 선물하는 작업
	function presentStamp($source_coupon_id, $dest_coupon_id, $stamp_num){
		$sql = "UPDATE ".COUPON_TABLE." SET current_stamp = current_stamp - {$stamp_num} WHERE coupon_id = {$source_coupon_id}";
		if(mysqli_query($this->conn, $sql)){
			$sql = "UPDATE ".COUPON_TABLE." SET current_stamp = current_stamp + {$stamp_num} WHERE coupon_id = {$dest_coupon_id}";
			if(mysqli_query($this->conn, $sql)){

			}else{

			}
		}else{

		}
	}
}
?>