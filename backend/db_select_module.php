<?php
class SelectDB{
	private $conn = 0;
	
	function __construct($connection){
		$this->conn = $connection;
	}

	function getUserTable(){
		$sql = "SELECT * FROM ".USER_TABLE;
		if(!$result = mysqli_query($this->conn, $sql)){
			return NULL;
		}
		return $result;
	}

	function loginCheck($target_id, $target_pw){
		$sql = "SELECT * FROM ".USER_TABLE." where user_id = '{$target_id}' and user_pw = '{$target_pw}'";
		$result = mysqli_query($this->conn, $sql);
		$row = mysqli_fetch_assoc($result);
		if(is_null($row)){
			return false;
		}else{
			return true;
		}
	}
}
?>