<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');

class Userstatuses extends AlaneeModal {
	
	public function getStatusIdForThisStatus($status){
		$response = '';
		$sql = "SELECT id FROM `user_statuses` WHERE `status_key` = '".$status."' LIMIT 1";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			$status_arr = $rs->fetch_assoc();
			$response = $status_arr['id'];
		}
		return $response;
	}
}

?>

