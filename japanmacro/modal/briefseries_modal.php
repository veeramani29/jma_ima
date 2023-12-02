<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class Briefseries extends AlaneeModal {
	
	public function getAllBriefseries() {
		$response = array();
		$sql = "SELECT * FROM `briefseries`  ORDER BY briefseries_id DESC  limit 0,5";
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