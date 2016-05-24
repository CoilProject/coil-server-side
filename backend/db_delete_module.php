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

	function deleteRow($table_name, $where_col, $where_value){
		$sql = "DELETE FROM {$table_name} WHERE {$where_col} = '{$where_value}' LIMIT 1";
		if(mysqli_query($this->conn, $sql)){
			parent::doLogging($this->conn, $table_name, $this->user_id, "Delete Row : {$where_col} = {$where_value}", true);
			return true;
		}else{
			parent::doLogging($this->conn, $table_name, $this->user_id, "Delete Row : {$where_col} = {$where_value}", false);
			return false;
		}
	}
}
?>