<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class Unsubscribe extends AlaneeModal {
	
	public function addUnsubscribeRequest($user_id, $code) {
		$response = false;
		$sql = "INSERT INTO `unsubscribe` (`user_id`, `unsubscribe_code`, `unsubscribe_date`) VALUES ('$user_id', '$code', '".date('Y-m-d')."');";
		if($this->executeQuery($sql)) {
			$response = true;
		}
		return $response;
	}
	
	public function getUnsubscribeRequestByCode($code) {
		$response = array();
		$sql = "SELECT `unsubscribe_id`,`user_id` FROM `unsubscribe` WHERE `unsubscribe_code`='$code'";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			$response = $rs->fetch_assoc();
		}
		return $response;
	}
	
	public function deleteThisEntry($usId) {
		$response = false;
		$sql = "DELETE FROM `unsubscribe` WHERE  `unsubscribe_id` = '$usId'";
		if($this->executeQuery($sql)) {
			$response = true;
		}
		return $response;	
	}
	
}

?>