<?php
namespace App\Model;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model;
class Graphdetails extends Model {
	protected $table = TBL_GRAPH_DETAILS;
	
	public function getGraphDetailsForTheseComaseperatedGids($gids) {
		$response = array();
		

		$data = Graphdetails::select('gid', 'title')->whereIn('gid',explode(",", $gids))->get();
		$get_Count = $data->count();
		if($get_Count>0) {

			$response = $data->toArray();
		
		}
		
		return $response;
	}
	
	public function checkIsPremiumForTheseComaseperatedGids($gids) {
		
		$data = Graphdetails::select('gid', 'title','isPremium')->whereIn('gid',explode(",", $gids))->where('isPremium','y')->get();
		$get_Count = $data->count();

		if($get_Count>0) {
			$result = true;
		} 
		else {
			$result = false;
		}
		return $result;
	}
	
	public function getGraphSourceForTheseComaseperatedGids($gids){
		$response = array();


		$data = Graphdetails::select('source')->whereIn('gid',explode(",", $gids))->get();
		$get_Count = $data->count();
		if($get_Count>0) {
		$rw = $data->toArray();
	
			foreach ($rw as $rws) {
			$sources = explode(',',$rws['source']);
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