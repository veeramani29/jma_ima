<?php
namespace App\Model;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model;
class Media extends Model {
	protected $table = TBL_MEDIA;
	public function getLatestMedia($count = 5) {
		$response = array();


		$get_Cat = Media::where('media_notice', 0)->orderBy('media_sort', 'asc')->orderBy('media_date', 'desc')->limit($count)->get();
		$get_Count = $get_Cat->count();

		
		if($get_Count>0) {

			$response = $get_Cat->toArray();
		
		}

	
		return $response;
	}
	
	public function getLatestMediaAsNotice($count = 5) {
		$response = array();


		$get_Cat = Media::where('media_notice', 1)->orderBy('media_sort', 'desc')->orderBy('media_date', 'desc')->limit($count)->get();
		$get_Count = $get_Cat->count();

		
		if($get_Count>0) {

				$response = $get_Cat->toArray();
		}

		
		return $response;
	}
}

?>