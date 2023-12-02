<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class Media extends AlaneeModal {
	
	public function getLatestMedia($count = 5) {
		$response = array();
		$sql = "SELECT * FROM `media` where media_notice = 0 ORDER BY `media_sort`, media_date desc  LIMIT 0,$count";	
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			//$response = $rs->fetch_all(true);
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		}
		return $response;
	}
	
	public function getLatestMediaAsNotice($count = 5) {
		$response = array();
		$sql = "SELECT * FROM `media` where media_notice = 1 ORDER BY media_sort, media_date desc LIMIT 0,$count";	
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			//$response = $rs->fetch_all(true);
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		}
		return $response;
	}
}

?>