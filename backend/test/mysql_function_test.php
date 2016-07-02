<?php
include("../coil_util.php");
include("../db_select_module.php");
include("../db_update_module.php");
include("../db_insert_module.php");
$db_select = new SelectDB($conn);
$db_update = new UpdateDB($conn);
$db_insert = new InsertDB($conn);

if($row = $db_select->findRowByTwoTable(USER_TABLE, GCM_TABLE, "user_id", "user_id", "chan9@naver.com", 1)){
	echo $row['user_permission']."<br>";
	echo $row['gcm_token']."<br>";
}
?>