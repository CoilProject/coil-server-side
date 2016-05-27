<?php
class InsertDB extends CoilDB{
	private $conn = 0;
	
	function __construct($connection){
		$this->conn = $connection;
	}
	// 새로운 유저가 등록하는 함수
	function insertNewMember($target_id, $target_pw){
		$sql = "INSERT INTO ".USER_TABLE." values (null, '{$target_id}', '{$target_pw}', now())";
		if(!$result = mysqli_query($this->conn, $sql)){
			return false;
		}else{
			$sql = "INSERT INTO ".GCM_TABLE." values (null, '{$target_id}', '', now())";
			mysqli_query($this->conn, $sql);
			return true;
		}
	}
	// 유저가 가게 쿠폰을 다운로드 받는 행위
	function downCoupon($user_id, $store_id){
		$sql = "INSERT INTO ".COUPON_TABLE." values (null, '{$user_id}', {$store_id}, 0, false, now())";
		if(!$result = mysqli_query($this->conn, $sql)){
			parent::doLogging($this->conn, COUPON_TABLE, $user_id, "id : {$store_id} coupon down", false);
			return false;
		}else{
			parent::doLogging($this->conn, COUPON_TABLE, $user_id, "id : {$store_id} coupon down", true);
			return true;
		}
	}
	// 유저 건의사항 등록하는 작업
	function insertUserSound($user_id, $contents, $type){
		$sql = "INSERT INTO ".SOUND_TABLE." values (null, '{$user_id}', '{$contents}', $type, now())";
		if($result = mysqli_query($this->conn, $sql)){
			parent::doLogging($this->conn, SOUND_TABLE, $user_id, "Type : {$type} Sound Enroll", true);
		}else{
			parent::doLogging($this->conn, SOUND_TABLE, $user_id, "Type : {$type} Sound Enroll", false);
		}
		return $result;
	}


}
?>