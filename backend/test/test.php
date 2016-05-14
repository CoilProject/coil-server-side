<?php
include("../coil_util.php");
include("../db_select_module.php");

$db_select = new SelectDB($conn);
$result = $db_select->getStoreTable();
while($row = mysqli_fetch_assoc($result)){
	echo $row['store_name'];
}

?>