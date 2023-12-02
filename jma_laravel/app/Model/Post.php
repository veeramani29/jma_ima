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
		$response = array();	$get_Arr_ = array();
			#where('post_type', 'N')
		#orderByRaw("STR_TO_DATE(`post_released`,'%M %d, %Y') desc")
		#$get_Cat = Post::where('post_publish_status', 'Y')->where('post_type', 'P')->orderByRaw("STR_TO_DATE(`post_released`,'%M %d, %Y') desc")->limit($count)->get();
		#$get_Cat = Post::where('post_publish_status', 'Y')->where('post_type', 'N')->orderBy('post_id', 'desc')->limit($count)->get();

		#$get_Count = $get_Cat->count();
       #dd($get_Cat);
		
		$sql = "SELECT * FROM post p LEFT JOIN post_category pc ON p.post_category_id = pc.post_category_id LEFT JOIN homepage_graph hg ON p.post_title!=hg.title WHERE  post_publish_status ='Y'  AND hg.title IS NOT NULL  ORDER BY STR_TO_DATE(`post_released`,'%M %d, %Y') DESC LIMIT 0,$count";
		$get_Cat = DB::select($sql);
			$get_Count =count($get_Cat);
		if($get_Count>0) {
 $get_Arr = $get_Cat;
			#$get_Arr = $get_Cat->toArray();
		
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
			$rs = Post::where('post_url_key',$post_key)->get();
		} else {
			$rs = Post::where('post_url_key',$post_key)->where('post_publish_status','Y')->get();
			 
		}
		
		if($rs->count()>0) {
			$response = $rs->toArray(true);
			
		}
		return $response;
	}
	
	public function getThisPostCategoryIdByKey($post_key) {
		$response = array();

		$rs=Post::select('post_category_id')->where('post_url_key',$post_key)->get();
		
		
		if($rs->count()>0) {
			$result = $rs->toArray();
			
		}
		//echo "<pre>".$post_key;print_r($result);die;
	return $response=isset($result[0]['post_category_id'])?$result[0]['post_category_id']:'';
	}
	
	
	public function getThisPostItemByKeyAndCategoryId($cat_id, $post_key){
		$response = array();

		$get_Cat = Post::where('post_publish_status', 'Y')->where('post_category_id', $cat_id)->where('post_url_key', $post_key)->get();

		$get_Count = $get_Cat->count();
		if($get_Count>0) {
				$response = $get_Cat->toArray();
			
		}
		return $response;		
	}
	
	public function getPublishedPostsByCategoryId($post_category_id) {
		$response = array();

	$get_Cat = Post::where('post_publish_status', 'Y')->where('post_category_id', $post_category_id)->orderBy('post_id', 'desc')->get();
		
		$get_Count = $get_Cat->count();

	if($get_Count>0) {

			$response = $get_Cat->toArray();
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
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			//$response = $rs->fetch_all(true);
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		}
		return $response;		
	}
	
	public function getThisSubCategoryItems($mCategoryKey,$sCategoryKey) {
		$response = array();
		$sql = "SELECT pc.post_category_id, pc.post_category_name, pc.premium_category, pc.category_url, pc.category_url_key, p.post_id, p.post_title, p.post_released, p.post_heading, p.post_subheading, p.post_cms_small, p.post_cms, p.post_datetime, p.post_copywriter_status, p.post_meta_title, p.post_meta_keywords, p.post_meta_description, p.post_url, p.post_url_key FROM post_category pc, post p, (SELECT post_category_id FROM post_category WHERE category_url_key ='".$mCategoryKey."' AND post_category_status = 'Y' AND category_type = 'P') parent_category WHERE pc.post_category_parent_id = parent_category.post_category_id AND pc.category_url_key = '".$sCategoryKey."' AND p.post_category_id = pc.post_category_id AND p.post_publish_status = 'Y' ORDER BY p.post_datetime DESC";	
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
		//	$response = $rs->fetch_all(true);
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		}
		return $response;		
	}
	
	public function getAllPublishedPostsForThisCategoryIdAndAreOutdated($ctID) {
		$response = array();
		try{



	$rs =Post::select('post_id','post_title','post_datetime','post_url')->whereraw('datediff(NOW(), `post_datetime`) > 7')->where('post_category_id',$ctID)->where('post_publish_status','Y')->get();
			//$sql = "SELECT `post_id`, `post_title`, `post_datetime`, `post_url` FROM post WHERE DATEDIFF( NOW( ) , `post_datetime` ) <=7 AND post_category_id = '".$ctID."' AND `post_publish_status` = 'Y'";
			

			if($rs->count()>0) {
			
					$response = $rs->toArray();
				
			}
		} catch (Exception $ex) {
			throw new Exception('Error..! Database error',9990);
		}
		return $response;
	}
	
	public function getLatestTwoDaysNewsItems($count,$isBreaking = false) {
		$postCategory = new postCategory();
	$response = array();  $get_Arr_ = array();

	if($isBreaking == true) {
			$get_Cat = Post::where('premium_news', 'Y')->where('post_publish_status', 'Y')->where('post_type', 'N')->where('post_datetime','>=','( CURDATE() - INTERVAL 10 DAY )')->orderBy('post_id', 'desc')->limit($count)->get();
		}else{
		$get_Cat = Post::where('post_publish_status', 'Y')->where('post_type', 'N')->where('post_datetime','>=','( CURDATE() - INTERVAL 10 DAY )')->orderBy('post_id', 'desc')->limit($count)->get();
		
		}
		
		$get_Count = $get_Cat->count();

		
		if($get_Count>0) {

			$get_Arr = $get_Cat->toArray();
			foreach($get_Arr as $get_Arrs) {
				$get_eachArr = $get_Arrs;
				$category_array = $postCategory->getAllParentCategoriesByCategoryId($get_eachArr['post_category_id']);
				$get_eachArr['category_path'] = $this->getCategotyArrayParsedIntoPath($category_array);
				$response[] = $get_eachArr;
			}
		}
		return $response;
	}
	
	

	public function getLatestNewsRssItems(){
		$postCategory = new postCategory();
		$response = array();  $get_Arr_ = array();
	$get_Cat = Post::where('post_publish_status', 'Y')->where('post_type', 'N')->orderBy('post_id', 'desc')->get();
		
		$get_Count = $get_Cat->count();

		
		if($get_Count>0) {

			$get_Arr = $get_Cat->toArray();
			foreach($get_Arr as $get_Arrs) {
				$get_eachArr = $get_Arrs;
				$category_array = $postCategory->getAllParentCategoriesByCategoryId($get_eachArr['post_category_id']);
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
}
?>