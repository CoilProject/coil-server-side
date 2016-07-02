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
	function loginCheck($table_name, $id_col, $id_value, $pw_col, $pw_value){
		$sql = "SELECT * FROM {$table_name} where {$id_col} = '{$id_value}' and {$pw_col} = '{$pw_value}'";
		$result = mysqli_query($this->conn, $sql);
		$row = mysqli_fetch_assoc($result);
		if(is_null($row)){
			return false;
		}else{
			parent::doLogging($this->conn, USER_TABLE, $id_value, "로그인",true);
			return true;
		}
	}
	// 조건이 하나 있는데, 테이블의 row 를 찾는경우
	// $type = 0 : all (default)
	// $type = 1 : 1 row
	function findRowByCondition($table_name, $where_col, $where_value, $type = 0){
		$sql = "SELECT * FROM {$table_name} WHERE {$where_col} = '{$where_value}'";
		if($result = mysqli_query($this->conn, $sql)){
			if($type == 0){
				return $result;
			}else if($type ==1){
				return mysqli_fetch_assoc($result);
			}
		}else{
			return false;
		}
	}
	// 회원아이디로 테이블의 검색결과를 찾는 함수
	// 기본적으로는 $result 를 넘기고, 특별하게 1을 요규하는 애들만 row를 하나 뽑아내준다
	// row_num 이 1 이면 한개 row 만, 아니라면 result 값 그대로 뽑아낸다
	function findUserByUserId($table_name, $target_id, $row_num = 0){
		$sql = "SELECT * FROM {$table_name} where user_id = '{$target_id}'";
		if($result = mysqli_query($this->conn, $sql)){
			if($row_num == 1){
				$row = mysqli_fetch_assoc($result);
				parent::doLogging($this->conn, USER_TABLE, $target_id, "row : {$row}" ,true);
				return $row;
			}else{
				parent::doLogging($this->conn, USER_TABLE, $target_id, "result : {$result}",true);
				return $result;
			}
		}else{
			parent::doLogging($this->conn, USER_TABLE, $target_id, "row_num : {$row_num}", false);
			return false;
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
	// 두개의 테이블을 합쳐서 조건에 맞는 rows 를 반환
	// (table_A.col = value) && (table_B.col = value)
	// row_count = 0 : all -> $result 반환 : default
	// row_count = 1 : 1개의 row 만 반환 -> $row 반환
	function findRowByTwoTable($table_name_a, $table_name_b, $col_a, $col_b, $value_ab, $row_count = 0){
		$sql = "SELECT * FROM {$table_name_a}, {$table_name_b} WHERE {$table_name_a}.{$col_a} = '{$value_ab}' and {$table_name_b}.{$col_b} = '{$value_ab}'";
		if($result = mysqli_query($this->conn, $sql)){
			if($row_count == 0)
				return $result;
			else if($row_count == 1)
				return mysqli_fetch_assoc($result);
		}else{
			return false;
		}

	}
}
?>