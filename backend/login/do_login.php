<?php
include("../coil_util.php");
include("../db_select_module.php");


if($value['build_version'] >= V1 && $value['build_version'] < V1_END){

	$db_select = new SelectDB($conn);
	if($db_select->loginCheck($value['user_id'], $value['user_pw'])){
		$response['login'] = true;
	}else{
		$response['login'] = false;
	}
	
}else{

}

echo json_encode($response);


// $result = $db_select->getUserTable();
// $row = mysqli_fetch_assoc($result);
// echo $row['user_id'];

// $sql = "SELECT * FROM ".USER_TABLE;
// $result  = mysqli_query($conn, $sql);
// $row = mysqli_fetch_assoc($result);
// if(is_null($row)){
// 	echo "hh";
// }else{
// 	echo "qq";
// }


?>