<?php
class SelectDB{
	private $conn = 0;
	
	function __construct($connection){
		$this->conn = $connection;
	}
	// USER_TABLE 안의 데이터를 모두 가져오는 함수
	// mysqli_fetch_assoc()로 추가 작업이 필요하다
	function getUserTable(){
		$sql = "SELECT * FROM ".USER_TABLE;
		if(!$result = mysqli_query($this->conn, $sql)){
			return NULL;
		}
		return $result;
	}
	function getStoreTable(){
		$sql = "SELECT * FROM ".STORE_TABLE;
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
			return true;
		}
	}
	// 아이디로 회원을 찾는 함수
	function findUserById($target_id){
		$sql = "SELECT * FROM ".USER_TABLE." where user_id = '{$target_id}'";
		$result = mysqli_query($this->conn, $sql);
		$row = mysqli_fetch_assoc($result);
		return $row;
	}
}
?>