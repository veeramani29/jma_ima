<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class Homepagegraph extends AlaneeModal {
	
	public function getHomepageGraph(){
		$response = array();
		$sql = "SELECT * FROM homepage_graph order by id desc LIMIT 1";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			$response = $rs->fetch_assoc();
		} 
		return $response;
	}
}

?>