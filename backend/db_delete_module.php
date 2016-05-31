<?php
class DeleteDB extends CoilDB{
	private $conn = 0;
	private $user_id;
	
	function __construct($connection){
		$this->conn = $connection;
	}

	function setUserId($user_id){
		$this->user_id = $user_id;
	}
	// 한개 row 없애기
	// type = 0 : default
	// type = 1 : coupon_use 
	// setUserId 선행 필요
	function deleteRow($table_name, $where_col, $where_value, $type = 0){
		$sql = "DELETE FROM {$table_name} WHERE {$where_col} = '{$where_value}' LIMIT 1";
		if(mysqli_query($this->conn, $sql)){
			if($type == 0){
				parent::doLogging($this->conn, $table_name, $this->user_id, "Delete Row : {$where_col} = {$where_value}", true);
			}else if($type == 1){
				parent::doLogging($this->conn, $table_name, $this->user_id, "Using Coupon : {$where_col} = {$where_value}", true);
			}
			return true;
		}else{
			if($type == 0){
				parent::doLogging($this->conn, $table_name, $this->user_id, "Delete Row : {$where_col} = {$where_value}", false);
			}else if($type == 1){
				parent::doLogging($this->conn, $table_name, $this->user_id, "Using Coupon : {$where_col} = {$where_value}", false);
			}
			
			return false;
		}
	}
}
?>