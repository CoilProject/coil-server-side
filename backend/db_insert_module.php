<?php
class InsertDB{
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
		$sql = "INSERT INTO ".COUPON_TABLE." values (null, '{$user_id}', '{$store_id}', 0, now())";
		if(!$result = mysqli_query($this->conn, $sql)){
			return false;
		}else{
			return true;
		}
	}

}
?>