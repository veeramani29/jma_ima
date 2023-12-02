<?php
namespace App\Model;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model;
class Graphdetails extends Model {
	protected $table = TBL_GRAPH_DETAILS;
	
	public function getGraphDetailsForTheseComaseperatedGids($gids) {
		$response = array();
		$sql = "select gid, title,source from graph_details where gid in ($gids)";
		$rs = DB::select($sql);
		
		if(count($rs)>0) {
			 foreach ($rs as $rw) {
				$response[] = $rw;
			}	
		} 
		return $response;
	}
	
	
	public function getMapGraphDetailsForTheseComaseperatedGids($gids) {
		$response = array();
		$sql = "select gid, title,source from mapgraph_details where gid in ($gids)";
		$rs = DB::select($sql);
		if(count($rs)>0) {
			//$response = $rs->fetch_all(true);
			foreach ($rs as $rw) {
				$response[] = $rw;
			}	
		} 
		return $response;
	}
	
	public function getMapDetailsForTheseComaseperatedGids($gids) {
		$response = array();
		//$sql = "SELECT DISTINCT(x_value) FROM map_values WHERE gid IN ($gids)";
		
		$sql = "SELECT CONCAT('01','-',SUBSTRING(x_value, -2),'-',SUBSTRING(x_value, 1,4)) AS x_value  FROM map_values WHERE gid IN ($gids) GROUP BY x_value";
		$rs = DB::select($sql);
		if(count($rs)>0) {
			//$response = $rs->fetch_all(true);
			foreach ($rs as $rw) {
				$response[] = $rw;
			}	
		} 
		return $response;
	}
	
	
	public function getMapDataDetailsForGids($gids) {
		$response = array();
		$sql = "SELECT y_sub_value FROM map_values WHERE gid IN  ($gids) ORDER BY vid LIMIT 0,35";
		$rs = DB::select($sql);
		if(count($rs)>0) {
			//$response = $rs->fetch_all(true);
			foreach ($rs as $rw) {
				$response[] = $rw;
			}	
		}
		return $response;
	}
	
	public function getmapmaxValueGids($gids) {
		
		$responseArr = "";
		$sql = "SELECT y_sub_value FROM map_values WHERE gid IN  ($gids) ORDER BY vid LIMIT 0,35";
		$rs = DB::select($sql);
		if(count($rs)>0) {
			foreach ($rs as $rw) {
				$responseArr.= $rw['y_sub_value'].",";
			}	
		}
		$statesReg =  str_replace(",","','",$responseArr);
		$stateVal = trim($statesReg,",'"); //"'".$statesReg; 
		$newStateRange = "'".$stateVal."'"; 
		
		$response = array();
		
		
		$sql = "SELECT mv.value AS max_val FROM map_values AS mv WHERE gid= '$gids' AND y_sub_value IN ($newStateRange)  AND x_value = (SELECT MAX(x_value) AS latestYear FROM map_values AS mv WHERE gid= '$gids')ORDER BY FIELD(y_sub_value,$newStateRange)";
		


        /* $sql = "SELECT MAX(mv.value) AS max_val FROM map_values AS mv WHERE gid= '$gids' AND y_sub_value IN ($newStateRange) GROUP BY y_sub_value ORDER BY FIELD(y_sub_value,$newStateRange)"; */
		
		
		//echo $sql = "SELECT m1.value AS max_val FROM map_values m1 LEFT JOIN map_values m2 ON (m1.y_sub_value = m2.y_sub_value AND m1.vid < m2.vid  AND m2.y_sub_value IN ($newStateRange) AND m2.gid= '$gids') WHERE m1.gid = '$gids' AND m2.vid IS NULL ORDER BY FIELD(m2.y_sub_value,$newStateRange)";
		
		/* $sql = "SELECT m1.value AS max_val ,m1.y_sub_value FROM map_values m1 LEFT JOIN map_values m2 
		ON (m1.y_sub_value = m2.y_sub_value AND m1.vid < m2.vid AND m2.y_sub_value IN ($newStateRange) AND m2.gid= '$gids') WHERE m1.gid = '$gids' AND m2.vid IS NULL ORDER BY FIELD(m1.y_sub_value,$newStateRange)"; */
		$rs = DB::select($sql);
		if(count($rs)>0) {
			//$response = $rs->fetch_all(true);
			foreach ($rs as $rw) {
				$response[]['max_value'] = $rw['max_val'];
			}	
		}
		return $response;
	}
	
	
	public function getMaxValueOfCurrentYear($gids) {
		
		$responseArr = "";
		$sql = "SELECT value FROM map_values AS mv WHERE gid= '$gids' AND x_value = (SELECT MAX(x_value) AS latestYear FROM map_values AS mv WHERE gid= '$gids') ORDER BY CAST(mv.value AS DECIMAL(18,2)) DESC";
		$rs = DB::select($sql);
		$response = array();
		if(count($rs)>0) {
			//$response = $rs->fetch_all(true);
			foreach ($rs as $rw) {
				$response[] = $rw;
			}
		} 
		return $response;
		
		
	}
	 
	public function getMapDetailsForJsonDataAll($gids) {
		
		$responseArr = "";
		$sql = "SELECT y_sub_value FROM map_values WHERE gid IN  ($gids) ORDER BY vid LIMIT 0,35";
		$rs = DB::select($sql);
		if(count($rs)>0) {
			foreach ($rs as $rw) {
				$responseArr.= $rw['y_sub_value'].",";
			}	
		}
		$statesReg =  str_replace(",","','",$responseArr);
		$stateVal = trim($statesReg,",'"); //"'".$statesReg; 
		$newStateRange = "'".$stateVal."'"; 
		
		$response = array();
		$sql = "SELECT mv.x_value,mv.value FROM map_values AS mv WHERE gid = '$gids' AND  y_sub_value IN ($newStateRange) GROUP BY y_sub_value,x_value ORDER BY FIELD(y_sub_value,$newStateRange),x_value";
		$rs = DB::select($sql);
		if(count($rs)>0) {
			//$response = $rs->fetch_all(true);
			foreach ($rs as $rw) {
				$response[] = $rw;
			}	
		}
		return $response;
	}
	
	public function checkIsPremiumForTheseComaseperatedGids($gids) {
		$result = '';
		$sql = "select gid, title, isPremium from graph_details where gid in ($gids) AND isPremium = 'y'";
		$rs = DB::select($sql);
		if(count($rs)>0) {
			$result = true;
		} 
		else {
			$result = false;
		}
		return $result;
	}
	
	public function getGraphSourceForTheseComaseperatedGids($gids){
		$response = array();
		$sql = "select source FROM graph_details where gid in ($gids)";
		$rs = DB::select($sql);
		if(count($rs)>0) {
			//$response = $rs->fetch_all(true);
			foreach ($rs as $rw) {
				$sources = explode(',',$rw['source']);
				foreach($sources as $source_ky) {
					$source = trim($source_ky);
					if(!in_array($source,$response)){
						$response[] = $source;
					}
				}
			}
		}
		return implode(', ',$response);
	}
	
	public function getMapSourceForTheseComaseperatedGids($gids){
		$response = array();
		$sql = "select source FROM mapgraph_details where gid in ($gids)";
		$rs = DB::select($sql);
		if(count($rs)>0) {
			//$response = $rs->fetch_all(true);
			foreach ($rs as $rw) {
				$sources = explode(',',$rw['source']);
				foreach($sources as $source_ky) {
					$source = trim($source_ky);
					if(!in_array($source,$response)){
						$response[] = $source;
					}
				}
			}
		}
		return implode(', ',$response);
	}
	
	public function getFilepathForTheseComaseperatedGids($gids) {
		$response = array();
		$sql = "select gid, filepath from graph_details where gid in ($gids)";
		$rs = DB::select($sql);
		if(count($rs)>0) {
			//$response = $rs->fetch_all(true);
			foreach ($rs as $rw) {
				$response[] = $rw;
			}
		} 
		return $response;
	}
	
}
?>