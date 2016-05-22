<?php
include("../coil_util.php");
include("../db_select_module.php");

if($value['build_version'] >= V1 && $value['build_version'] < V1_END){
	$db_select = new SelectDB($conn);
	if(!$result = $db_select->getTable(STORE_TABLE)){
		$response['search_all'] = false;
		$response['error_message'] = "등록된 가게가 없습니다";
	}else{
		$response['search_all'] = true;
		$response['store_list'] = array();
		$cnt = 0;
		while($row = mysqli_fetch_assoc($result)){
			$object = new StoreInfo;
			$object->store_id = $row['store_id'];
			$object->store_name = $row['store_name'];
			$object->user_down = $row['user_down'];
			$object->max_stamp = $row['max_stamp'];
			$object->created = $row['created'];
			array_push($response['store_list'], $object);
			$cnt = $cnt+1;
		}
		$response['store_count'] = $cnt;
	}
	
}else{

}

class StoreInfo{
	public $store_id, $store_name, $user_down, $max_stamp, $created;
}

echo json_encode($response);
?>