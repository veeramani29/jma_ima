<?php
namespace App\Model;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model;
use DB;
class Graphvalues extends Model {
	protected $table = TBL_GRAPH_VALUES;
	public function getYAndYSubForThisGid($gid) {
		$response = array();

		$data = Graphvalues::select('y_value', 'y_sub_value', DB::raw('min(vid)'))->where('gid',$gid)->groupBy('y_value','y_sub_value')->orderBy('min(vid)','asc')->get();
		
$get_Count = $data->count();
		if($get_Count>0) {

			$response = $data->toArray();
		
		}
		
		
		
		
		return $response;
	}


		public function getThisqueryResult($sql) {
		$response = array();

     //DB::enableQueryLog();
		$data = DB::select($sql);
		$get_Count = count($data);
		//print_r(DB::getQueryLog());
		if($get_Count>0) {
		$response = $data;
		}
		
		return $response;		
	}
	
}
?>