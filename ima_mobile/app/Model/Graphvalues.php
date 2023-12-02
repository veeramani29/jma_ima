<?php
namespace App\Model;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model;
use DB;
class Graphvalues extends Model {
	protected $table = TBL_GRAPH_VALUES;
	
	public function getYAndYSubForThisGid($gid) {
		$response = array();
		$sql = "SELECT y_value, y_sub_value, min(vid) FROM graph_values where gid = '".$gid."' GROUP BY y_value, y_sub_value order by min(vid)";
		$rs = DB::select($sql);
		$get_Count =count($rs);
		if($get_Count>0) {
			$get_Arr = json_decode(json_encode($rs), true);
			foreach($get_Arr as $get_Arrs) {
				$response[] = $get_Arrs;
			}
		} 
		return $response;
	}
	
	
	public function getYAndYSubForThisGidForMap($gid) {
		$response = array();
		
		
		//$sql = "SELECT y_value, y_sub_value, min(vid) FROM map_values where gid = '".$gid."' GROUP BY y_value, y_sub_value order by min(vid)";
		$sql = "SELECT y_value, y_sub_value FROM map_values WHERE gid = '".$gid."' ORDER BY vid LIMIT 0,35";
		$rs = DB::select($sql);
		$get_Count =count($rs);
		if($get_Count>0) {
			$get_Arr = json_decode(json_encode($rs), true);
			foreach($get_Arr as $get_Arrs) {
				$response[] = $get_Arrs;
			}
		} 
		return $response;
	}
	
	
	public function getThisqueryResult($sql) {
		$response = array();


		$data = DB::select($sql);
		$get_Count = count($data);
		

		
			

if($get_Count>0) {
$response = json_decode(json_encode($data), true);
		
		
		}
		
		return $response;		
	}
	
}
?>