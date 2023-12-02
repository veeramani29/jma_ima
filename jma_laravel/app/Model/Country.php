<?php
namespace App\Model;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model;
class Country extends Model {
		protected $table = TBL_COUNTRY;
	public function getCountryDatabase() {
		$response = array();


		$get_Cat = Country::orderBy('country_name', 'asc')->get();
		$get_Count = $get_Cat->count();

		
		if($get_Count>0) {

			$response = $get_Cat->toArray();
		
		}

		
		return $response;	
	}
	public function getCountryDatabaseAsArray() {
		$response = array();

		$get_Cat = Country::orderBy('country_name', 'asc')->get();
		$get_Count = $get_Cat->count();

		
		if($get_Count>0) {
			$responses = $get_Cat->toArray();
			foreach ($responses as $rw) {
				$response[$rw['country_id']] = $rw['country_name'];
				
			}
			
		
		}

		
		return $response;	
	}
	
}

?>