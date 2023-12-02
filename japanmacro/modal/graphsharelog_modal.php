<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class Graphsharelog extends AlaneeModal {
	
	public function logGraphShare($details) {
		$sql = 'INSERT INTO share_graph_log(datetime,from_email,to_email,link,message,key_verification,verified,client_ip) VALUES
		 (now(),"'.$details['from_email'].'","'.$details['to_email'].'",
		 "'.$details['link'].'",
		 "'.mb_convert_encoding($details['message'],'UTF-8').'",
		 "'.$details['key_verification'].'",'.$details['verified'].',"'.$_SERVER['SERVER_ADDR'].'")';
			if($this->executeQuery($sql)) {
				return true;
			} else {
				return false;
			}

	}
	
	public function getGraphShareLogForThisKey($key_verify) {
		$response = array();
		$sql = 'SELECT * FROM share_graph_log WHERE `key_verification` = "'.$key_verify.'"';
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			//$response = $rs->fetch_all(true);
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		} 
		return $response;	
	}
	
	public function setGraphShareVerificationStatusAsVerified($key_verify) {
		$sql_update = 'UPDATE `share_graph_log` SET `verified` = 1 WHERE `key_verification` = "'.$key_verify.'"';
		if($this->executeQuery($sql_update)) {
			return true;
		} else {
			return false;
		}
	}

}
?>