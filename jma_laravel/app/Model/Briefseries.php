<?php
namespace App\Model;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model;

class Briefseries extends Model {
	
	protected $table = TBL_BRIEFSERIES;

	public function getAllBriefseries() {
		$response = array();

		
		  $get_Cat = Briefseries::orderBy('briefseries_id','desc')->limit(5)->get();
		
		 $get_Count = $get_Cat->count();
        if($get_Count>0) {
            $response = $get_Cat->toArray();
        
        }

		
		return $response;		
	}
	
	
}

?>