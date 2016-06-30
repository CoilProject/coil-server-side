<?php
// mysql
define("MYSQL_IP","localhost");
define("MAIN_DB","ljs93kr2");
define("DB_PASSWORD","wnddnjsQkd");
define("USE_DB","ljs93kr2");

// table define 
define("USER_TABLE", "coil_user_table");
define("STORE_TABLE", "coil_store_table");
define("COUPON_TABLE", "coil_coupon_table");
define("GCM_TABLE", "coil_gcm_table");
define("LOG_TABLE", "coil_log_table");
define("SOUND_TABLE", "coil_sound_table");

// user_permission
define("P_USER", 0); // 사용자
define("P_ADMIN", 1); // 관리자
define("P_SHOP", 2); // 업주
define("P_GUEST", 3); // 게스트

// version define
define("V1", 1);
define("V1_END", 99);

$response['db_error'] = false; 

function connect_mysqli($ip,$user,$password,$db){
	if(!$conn = mysqli_connect($ip,$user,$password)){
		//echo "mysql 연결실패<br />";
	}
	//mysql_query("SET NAMES UTF8");
	if(!mysqli_select_db($conn,$db)){
		//echo "db 선택 실패<br />";
	}
	
	return $conn;
}

// connection 흭득에 실패하면 더이상 스크립트를 진행하지 않음
if(!$conn = connect_mysqli(MYSQL_IP, MAIN_DB, DB_PASSWORD, USE_DB)){
	$response['db_error'] = true;
	echo json_encode($response);
	exit();
}

class CoilDB{
	function doLogging($conn, $table_name, $user_id, $act, $result){
		$sql = "INSERT INTO ".LOG_TABLE." values (null, '{$table_name}', '{$user_id}', '{$act}', {$result}, now())";
		return mysqli_query($conn, $sql);
	}
}

$value = json_decode(file_get_contents('php://input'), true);

/*
	$response 는 결론적으로 클라이언트에게 보내는 응답 
	$conn 이 db connection
	$value 가 json 형태의 post 형태 연관배열 데이터
	모든 데이터는 json 으로 encoding 해서 넘김
*/
?>