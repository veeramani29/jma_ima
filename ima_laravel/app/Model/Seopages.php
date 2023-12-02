<?php
namespace App\Model;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model;
use DB;
class Seopages extends Model {
	
	
	public function getThisItemBySlugKey($slug_hash) {
		$response = array();
		$sql = "SELECT seo.*, pst.post_title, pst.post_released, pst.post_heading, pst.post_subheading, pst.post_cms FROM seopages seo LEFT JOIN post pst ON seo.post_id = pst.post_id WHERE seo.slug_hash='".$slug_hash."'";
		$rs = DB::select($sql);
		if(count($rs)>0) {
			$response = $rs->toArray(true);
			
		}
		return $response;
	}
	
	public function getPublishedPostsByCategoryId($post_category_id) {
		$response = array();
		$sql = "SELECT * FROM `post` WHERE post_publish_status ='Y' AND post_category_id = '$post_category_id' ORDER BY post_id DESC";
			$rs = DB::select($sql);
		if(count($rs)>0) {
			$response = $rs->toArray(true);
			
		}
		return $response;
	}	
	

}

?>