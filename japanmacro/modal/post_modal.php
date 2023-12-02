<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class Post extends AlaneeModal {
	
	public function getLatestNewsItems($count) {
		$postCategory = new postCategory();
		$response = array();
		$sql = "SELECT * FROM `post` WHERE post_publish_status ='Y' AND post_type='N' ORDER BY `post_id` DESC LIMIT 0,$count";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			//$response = $rs->fetch_all(true);
			while ($rw = $rs->fetch_assoc()) {
				$category_array = $postCategory->getAllParentCategoriesByCategoryId($rw['post_category_id']);
				$rw['category_path'] = $this->getCategotyArrayParsedIntoPath($category_array);
				$response[] = $rw;
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
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			//$response = $rs->fetch_all(true);
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		}
		return $response;
	}
	
	public function getThisPostCategoryIdByKey($post_key) {
		$response = array();
		$sql = "SELECT `post_category_id` FROM `post` WHERE post_url_key = '$post_key'";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			//$response = $rs->fetch_all(true);
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		}
		return $response[0]['post_category_id'];
	}
	
	
	public function getThisPostItemByKeyAndCategoryId($cat_id, $post_key){
		$response = array();
		 $sql = "SELECT * FROM `post` WHERE post_publish_status ='Y' AND post_category_id ='$cat_id' AND post_url_key = '$post_key'";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			//$response = $rs->fetch_all(true);
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		}
		return $response;		
	}
	
	public function getPublishedPostsByCategoryId($post_category_id) {
		$response = array();
		$sql = "SELECT * FROM `post` WHERE post_publish_status ='Y' AND post_category_id = '$post_category_id' ORDER BY post_id DESC";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			//$response = $rs->fetch_all(true);
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
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
			$sql = "SELECT `post_id`, `post_title`, `post_datetime`, `post_url` FROM post WHERE DATEDIFF( NOW( ) , `post_datetime` ) <=7 AND post_category_id = '".$ctID."' AND `post_publish_status` = 'Y'";
			$rs = $this->executeQuery($sql);
			if($rs->num_rows>0) {
				while ($rw = $rs->fetch_assoc()) {
					$response[] = $rw;
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
		$sql = "SELECT * FROM `post` WHERE post_publish_status ='Y' AND post_type='N' AND post_datetime >= ( CURDATE() - INTERVAL 10 DAY ) ORDER BY `post_id` DESC LIMIT 0,$count";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			while ($rw = $rs->fetch_assoc()) {
				$category_array = $postCategory->getAllParentCategoriesByCategoryId($rw['post_category_id']);
				$rw['category_path'] = $this->getCategotyArrayParsedIntoPath($category_array);
				$response[] = $rw;
			}
		}
		return $response;
	}
	
	

	public function getLatestNewsRssItems(){
		$postCategory = new postCategory();
		$response = array();
		
		 $sql = "SELECT * FROM `post` WHERE post_publish_status ='Y' AND post_type='N' ORDER BY `post_id` DESC";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			while ($rw = $rs->fetch_assoc()) {
				$category_array = $postCategory->getAllParentCategoriesByCategoryId($rw['post_category_id']);
				$rw['category_path'] = $this->getCategotyArrayParsedIntoPath($category_array);
				$response[] = $rw;
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