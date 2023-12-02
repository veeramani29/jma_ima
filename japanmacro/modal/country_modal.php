<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class Country extends AlaneeModal {
	
	public function getCountryDatabase() {
		$response = array();
		$sql = "SELECT * FROM `country` ORDER BY country_name ASC";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			//$response = $rs->fetch_all(true);
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		}
		return $response;	
	}
	public function getCountryDatabaseAsArray() {
		$response = array();
		$sql = "SELECT * FROM `country` ORDER BY country_name ASC";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			//$response = $rs->fetch_all(true);
			while ($rw = $rs->fetch_assoc()) {
				$response[$rw['country_id']] = $rw['country_name'];
			}
		}
		return $response;	
	}
	
}

?>