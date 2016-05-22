<?php
include("../coil_util.php");
include("../db_select_module.php");
include("../db_update_module.php");
include("../db_insert_module.php");
$db_select = new SelectDB($conn);
$db_update = new UpdateDB($conn);
$db_insert = new InsertDB($conn);
$row = $db_select->findRowByRecently(COUPON_TABLE, "user_id","test@test", 1);
//$row = $db_select->findStoreInfoByCouponId(1);
print_r($row);
// print_r($row);

// $result = $db_select->getTable(USER_TABLE);
// while($row = mysqli_fetch_assoc($result)){
// 	print_r($row);
// }

// while($row = mysqli_fetch_assoc($result)){
// 	echo $row['store_name'];
// }

?>