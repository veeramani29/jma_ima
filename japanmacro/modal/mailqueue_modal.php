<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class Mailqueue extends AlaneeModal{
	
	public function addToQueue($mail_type,$mail_to,$mail_from,$data){
		try {
				$sql = "INSERT INTO `mail_queue`(`mail_type`,`mail_to`,`mail_from`,`data`) VALUES('{$mail_type}','{$mail_to}','{$mail_from}','{$data}')";
				return $this->insertQuery($sql);
		}catch (Exception $ex){
			throw new Exception('Mail Queue : Database error..', 9999);
		}
		
		
	}
	
	public function getAllMailQueue(){
		try {
			$result = array();
			$sql = "SELECT * FROM `mail_queue` LIMIT 100";
			$rs = $this->executeQuery($sql);
			if($rs->num_rows>0) {
				while ($rw = $rs->fetch_assoc()) {
					$result[] = $rw;
				}
			}
			return $result;
	
		}catch (Exception $ex){
			throw new Exception('Database error..', 9999);
		}
	}
	
	public function getMailQueueByType($mail_type){
		try {
			$result = array();
			$sql = "SELECT * FROM `mail_queue` WHERE `mail_type` = '$mail_type'";
			$rs = $this->executeQuery($sql);
			if($rs->num_rows>0) {
				while ($rw = $rs->fetch_assoc()) {
					$result[] = $rw;
				}
			}
			return $result;
				
		}catch (Exception $ex){
			throw new Exception('Database error..', 9999);
		}
	}
	
	public function deleteThisMailQueue($id){
		$response = false;
		try{
			$sql = "DELETE FROM `mail_queue` WHERE `id`={$id}";
			if($this->executeQuery($sql)) {
				$response = true;
			}
			else {
				throw new Exception('Database error..', 9999);
			}
		}catch (Exception $ex) {
			throw new Exception($ex->getMessage(), $ex->getCode());
		}		
			return $response;
	}
	
}

?>