<?php
namespace App\Model;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model;
class Home extends Model {
	
	protected $table = TBL_HOME_PAGE_GRAPH;

	public function getHomepageGraph(){
		$response = array();


		$get_Cat = Home::orderBy('id', 'desc')->limit(1)->first();
		$get_Count = $get_Cat->count();

		
		if($get_Count>0) {

			$response = $get_Cat->toArray();
		
		}

		return $response;
	}
}

?>