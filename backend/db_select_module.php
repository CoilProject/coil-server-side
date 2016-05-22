<?php
class SelectDB extends CoilDB{
	private $conn = 0;
	
	function __construct($connection){
		$this->conn = $connection;
	}
	// TABLE 안의 데이터를 모두 가져오는 함수
	function getTable($table_name){
		$sql = "SELECT * FROM {$table_name}";
		return mysqli_query($this->conn, $sql);
		
	}
	// 로그인 성공을 체크하는 함수
	function loginCheck($target_id, $target_pw){
		$sql = "SELECT * FROM ".USER_TABLE." where user_id = '{$target_id}' and user_pw = '{$target_pw}'";
		$result = mysqli_query($this->conn, $sql);
		$row = mysqli_fetch_assoc($result);
		if(is_null($row)){
			return false;
		}else{
			parent::doLogging($this->conn, USER_TABLE, $target_id, "로그인",true);
			return true;
		}
	}
	// 회원아이디로 테이블의 검색결과를 찾는 함수
	// 기본적으로는 $result 를 넘기고, 특별하게 1을 요규하는 애들만 row를 하나 뽑아내준다
	// row_num 이 1 이면 한개 row 만, 아니라면 result 값 그대로 뽑아낸다
	function findUserByUserId($table_name, $target_id, $row_num = 0){
		$sql = "SELECT * FROM {$table_name} where user_id = '{$target_id}'";
		$result = mysqli_query($this->conn, $sql);
		if($row_num == 1){
			$row = mysqli_fetch_assoc($result);
			return $row;
		}else{
			return $result;
		}
	}
	// coupon_id 와 매칭되는 storeInfo 를 리턴하는 함수다
	// $row 로 넘겨주므로, 연관배열로 바로 접근할 수 있다
	// storeInfo 는 하나의 $row 이다
	function findStoreInfoByCouponId($coupon_id){
		$coupon_table = COUPON_TABLE;
		$store_table = STORE_TABLE;
		$sql = "SELECT * FROM {$coupon_table}, {$store_table} WHERE {$coupon_table}.store_id = {$store_table}.store_id and {$coupon_table}.coupon_id = {$coupon_id}";
		$result = mysqli_query($this->conn, $sql); 
		return mysqli_fetch_assoc($result);
		
	}
	// 테이블의 타겟중에 최신순으로 결과를 반환하는 함수
	// type = 0 : all  -> $result 반환
	// type = 1 : 1개의 row -> $row 반환
	function findRowByRecently($table_name, $col_name, $col_value, $type = 0){
		$sql = "SELECT * FROM {$table_name} WHERE {$col_name} = '{$col_value}' ORDER BY created DESC";
		if($result = mysqli_query($this->conn, $sql)){
			if($type == 0){
				// all
				return $result;
			}else if($type == 1){
				// 1 row
				return mysqli_fetch_assoc($result);
			}
		}else{
			return false;
		}
	}
}
?>