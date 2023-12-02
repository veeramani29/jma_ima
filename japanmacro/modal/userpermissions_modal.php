<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');

class Userpermissions extends AlaneeModal {
	
	public function getPermissionArrayForThisUserTypeAndStatus($user_type_id,$user_status_id){
		$response = array();
		$sql = "SELECT permission FROM `user_permissions` WHERE `user_type_id` = $user_type_id AND user_status_id = $user_status_id LIMIT 1";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			$permissions = $rs->fetch_assoc();
			$response = json_decode($permissions['permission'],true);
		}
		return $response;
	}
}

?>

