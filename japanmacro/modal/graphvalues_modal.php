<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class Graphvalues extends AlaneeModal {
	
	public function getYAndYSubForThisGid($gid) {
		$response = array();
		$sql = "SELECT y_value, y_sub_value, min(vid) FROM graph_values where gid = '".$gid."' GROUP BY y_value, y_sub_value order by min(vid)";
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