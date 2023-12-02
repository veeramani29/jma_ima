<?php
namespace App\Model;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model;
use App\Model\Postcategory;
use DB;
class Post extends Model {
	
	protected $table = TBL_POST;
	
	public function getLatestNewsItems($count) {
		$postCategory = new postCategory();
		$response = array();
		/* $sql = "SELECT * FROM `post` WHERE post_publish_status ='Y' AND post_type='N' ORDER BY `post_id` DESC LIMIT 0,$count"; */
		$sql = "SELECT * FROM post p LEFT JOIN post_category pc ON p.post_category_id = pc.post_category_id LEFT JOIN homepage_graph hg ON p.post_title!=hg.title WHERE  post_publish_status ='Y'  AND hg.title IS NOT NULL  ORDER BY STR_TO_DATE(`post_released`,'%M %d, %Y') DESC LIMIT 0,$count";
		$rs = DB::select($sql);
		$get_Count =count($rs);
		if($get_Count>0) {
			 $get_Arr = json_decode(json_encode($rs), true);
			foreach($get_Arr as $get_Arrs) {
				$get_eachArr = $get_Arrs;
				$category_array = $postCategory->getAllParentCategoriesByCategoryId($get_Arrs['post_category_id']);
				$get_eachArr['category_path'] = $this->getCategotyArrayParsedIntoPath($category_array);
				$response[] = $get_eachArr;
			}
		}
		return $response;
	}
	
	public function getThisPostItemByKey($post_key,$isPreview = false) {
		$response = array();
		if($isPreview == true) {
			$sql = "SELECT * FROM `post` WHERE post_url_key = '$post_key'";
		} else {
			$sql = "SELECT * FROM `post` WHERE post_publish_status ='Y' AND post_url_key = '$post_key'";
		}
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
	
	public function getThisPostCategoryIdByKey($post_key) {
		$response = array();
		$sql = "SELECT `post_category_id` FROM `post` WHERE post_url_key = '$post_key'";
		$rs = DB::select($sql);
		$get_Count =count($rs);
		if($get_Count>0) {
			$get_Arr = json_decode(json_encode($rs), true);
			foreach($get_Arr as $get_Arrs) {
				$response[] = $get_Arrs;
			}
		}
		return $response[0]['post_category_id'];
	}
	
	
	public function getThisPostItemByKeyAndCategoryId($cat_id, $post_key){
		$response = array();
		$sql = "SELECT * FROM `post` WHERE post_publish_status ='Y' AND post_category_id ='$cat_id' AND post_url_key = '$post_key'";
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
	
	public function getPublishedPostsByCategoryId($post_category_id) {
		$response = array();
		$sql = "SELECT * FROM `post` WHERE post_publish_status ='Y' AND post_category_id = '$post_category_id' ORDER BY post_id DESC";
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


	public function get_Graphdetails_BasedOnPage_CategoryId($post_category_id) {
		 $response = array();
		 #SELECT * FROM `graph_details` WHERE CONCAT(',', updated_page, ',') like '%,2,%'
		 #SELECT * FROM `graph_details` WHERE find_in_set('2',updated_page) <> 0
		$sql = "SELECT p.post_id,g.gid,g.title FROM `post` p,graph_details g WHERE p.`post_category_id` = '$post_category_id' and find_in_set(p.post_id,g.updated_page) <> 0";

			#$sql = "SELECT p.post_id,g.gid,g.title FROM `post` p,graph_details g WHERE p.`post_category_id` = '$post_category_id' and p.post_id=g.updated_page";
		$rs = DB::select($sql);
		$get_Count =count($rs);
		if($get_Count>0) {
			$response = json_decode(json_encode($rs), true);
			
		}
		return $response;
	}
	
	public function getThisMainCategoryItems($mCategoryKey) {
		/*
		 * @todo
		 */
		$response = array();
		$sql = "SELECT pc.post_category_id, pc.post_category_name, pc.premium_category, pc.category_url, pc.category_url_key, p.post_id, p.post_title, p.post_released, p.post_heading, p.post_subheading, p.post_cms_small, p.post_cms, p.post_datetime, p.post_copywriter_status, p.post_meta_title, p.post_meta_keywords, p.post_meta_description, p.post_url, p.post_url_key FROM post_category pc, post p WHERE pc.category_url_key = '".$mCategoryKey."' AND p.post_category_id = pc.post_category_id AND p.post_publish_status = 'Y' ORDER BY p.post_datetime DESC";
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
	
	public function getThisSubCategoryItems($mCategoryKey,$sCategoryKey) {
		$response = array();
		$sql = "SELECT pc.post_category_id, pc.post_category_name, pc.premium_category, pc.category_url, pc.category_url_key, p.post_id, p.post_title, p.post_released, p.post_heading, p.post_subheading, p.post_cms_small, p.post_cms, p.post_datetime, p.post_copywriter_status, p.post_meta_title, p.post_meta_keywords, p.post_meta_description, p.post_url, p.post_url_key FROM post_category pc, post p, (SELECT post_category_id FROM post_category WHERE category_url_key ='".$mCategoryKey."' AND post_category_status = 'Y' AND category_type = 'P') parent_category WHERE pc.post_category_parent_id = parent_category.post_category_id AND pc.category_url_key = '".$sCategoryKey."' AND p.post_category_id = pc.post_category_id AND p.post_publish_status = 'Y' ORDER BY p.post_datetime DESC";	
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
	
	public function getAllPublishedPostsForThisCategoryIdAndAreOutdated($ctID) {
		$response = array();
		try{
			$sql = "SELECT `post_id`, `post_title`, `post_datetime`, `post_url` FROM post WHERE DATEDIFF( NOW( ) , `post_datetime` ) <=7 AND post_category_id = '".$ctID."' AND `post_publish_status` = 'Y'";
			$rs = DB::select($sql);
			$get_Count =count($rs);
			if($get_Count>0) {
				$get_Arr = json_decode(json_encode($rs), true);
				foreach($get_Arr as $get_Arrs) {
					$response[] = $get_Arrs;
				}
			}
		} catch (Exception $ex) {
			throw new Exception('Error..! Database error',9990);
		}
		return $response;
	}
	
	public function getLatestTwoDaysNewsItems($count) {
		$postCategory = new postCategory();
		$response = array();
		
		/* $sql = "SELECT * FROM `post` WHERE post_publish_status ='Y' AND post_type='N' AND post_datetime >= ( CURDATE() - INTERVAL 2 DAY ) ORDER BY `post_id` DESC LIMIT 0,$count"; */
		
		$sql = "SELECT p.* FROM post AS p LEFT JOIN post_category AS pc ON p.post_category_id = pc.post_category_id WHERE p.post_category_id = 29 AND  p.post_publish_status = 'Y' AND p.post_datetime >= ( CURDATE() - INTERVAL 10 DAY ) ORDER BY p.post_id DESC LIMIT 0,$count";
		$rs = DB::select($sql);
		$get_Count =count($rs);
		if($get_Count>0) {
			$get_Arr = json_decode(json_encode($rs), true);
			foreach($get_Arr as $get_Arrs) {
				$get_eachArr = $get_Arrs;
				$category_array = $postCategory->getAllParentCategoriesByCategoryId($get_Arrs['post_category_id']);
				$get_eachArr['category_path'] = $this->getCategotyArrayParsedIntoPath($category_array);
				$response[] = $get_eachArr;
			}
			/* while ($rw = $rs->fetch_assoc()) {
				$category_array = $postCategory->getAllParentCategoriesByCategoryId($rw['post_category_id']);
				$rw['category_path'] = $this->getCategotyArrayParsedIntoPath($category_array);
				$response[] = $rw;
			} */
		}
		return $response;
	}



	public function getcategoryItems($post_idar) {
		$postCategory = new postCategory();
		$response = array();
		
		
		
		$sql = "SELECT pc.category_url,p.* FROM post AS p LEFT JOIN post_category AS pc ON p.post_category_id = pc.post_category_id WHERE pc.post_category_parent_id  in ($post_idar) AND  p.post_publish_status = 'Y'  ORDER BY p.post_id asc";
		$rs = DB::select($sql);
		$get_Count =count($rs);
		if($get_Count>0) {
			$get_Arr = json_decode(json_encode($rs), true);
			foreach($get_Arr as $get_Arrs) {
				$get_eachArr = $get_Arrs;
				$category_array = $postCategory->getAllParentCategoriesByCategoryId($get_Arrs['post_category_id']);
				$get_eachArr['category_path'] = $this->getCategotyArrayParsedIntoPath($category_array);
				$response[] = $get_eachArr;
			}
			
		}
		return $response;
	}
	
	
	private function getCategotyArrayParsedIntoPath($cat_array) {
		$response = '';
		if(is_array($cat_array)) {
			foreach ($cat_array as $rw_cat) {
				$response.=$rw_cat['category_url'].'/';
			}
		}
		return $response;
	}
	
	public function getCategoryPostByKeyword($keyword){
		$sql = "SELECT t1.post_title, t1.post_url, t1.post_cms, t1.post_category_id, t2.post_category_name,t2.category_url, t2.post_category_parent_id FROM post t1 INNER JOIN post_category t2 on t1.post_category_id = t2.post_category_id AND t1.post_meta_keywords LIKE '%".$keyword."%' AND t1.post_publish_status='Y'";
		$rs = DB::select($sql);
		$get_Count =count($rs);
		return $rs;
	}
	
	public function getIndicatorKeyWords(){
		//$response=array();
		$sql = "SELECT post_meta_keywords,post_category_id FROM post WHERE post_publish_status='Y'";
		$rs = DB::select($sql);
		$get_Count =count($rs);
		if($get_Count>0) {
			foreach($rs as $key=>$value){
				$response[$key] = $value->post_meta_keywords;
				//$response[$key] =  explode(",",$value->post_meta_keywords);
			}
		}
		return $response;
	}

	public function getallSubcatByParent($latest_category_id){


		$response=array();
	#$items = table($this->table)->where('post_category_status', 'Y')->orderBy('category_order', 'asc')->get();
	$get_Cat = Postcategory::where('post_category_parent_id', $latest_category_id)->orderBy('category_order', 'asc')->get();
	$get_Count = $get_Cat->count();
	
	if($get_Count>0) {
		$response = $get_Cat->toArray();
		
	}
	return $response;

		
	}
}
?>