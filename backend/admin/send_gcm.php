<?php
include("../coil_util.php");
include("../../gcm_push/gcm-push-module.php");
include("../db_select_module.php");


if($value['build_version'] >= V1 && $value['build_version'] < V1_END){
	
}else{

}

echo json_encode($response);

?>