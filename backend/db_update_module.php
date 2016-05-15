<?php
class UpdateDB{
	private $conn = 0;
	
	function __construct($connection){
		$this->conn = $connection;
	}

	function updateGcmToken($user_id, $gcm_token){
		$sql = "UPDATE ".GCM_TABLE." SET gcm_token = '{$gcm_token}' WHERE user_id = '{$user_id}'";
		if(!mysqli_query($this->conn, $sql)){
			return false;
		}else{
			return true;
		}
	}
}
?>