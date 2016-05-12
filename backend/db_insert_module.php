<?php
class InsertDB{
	private $conn = 0;
	
	function __construct($connection){
		$this->conn = $connection;
	}

	// function getUserTable(){
	// 	$sql = "SELECT * FROM ".USER_TABLE;
	// 	if(!$result = mysqli_query($this->conn, $sql)){
	// 		return NULL;
	// 	}
	// 	return $result;
	// }

	function insertNewMember($target_id, $target_pw){
		$sql = "INSERT INTO ".USER_TABLE." values (null, '{$target_id}', '{$target_pw}')";
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