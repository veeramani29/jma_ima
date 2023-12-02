<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class Material extends AlaneeModal {
	
	public function getAllMaterials($material_type) {
		$response = array();
		$sql = "SELECT * FROM `material` WHERE material_type = '$material_type' ORDER BY material_id DESC ";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			//$response = $rs->fetch_all(true);
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		}
		return $response;		
	}
	
	public function getThisPostItemById($post_id) {
		$response = array();
		$sql = "SELECT * FROM `post` WHERE post_publish_status ='Y' AND post_type='N' AND post_url_key = '$post_key'";
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
	//	$sql = "SELECT * FROM `post` WHERE post_publish_status ='Y' AND post_type='N' AND post_url_key = '$post_key'";
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
		$sql = "SELECT pc.post_category_id, pc.post_category_name, pc.premium_category, pc.category_url, pc.category_url_key, p.post_id, p.post_title, p.post_released, p.post_heading, p.post_subheading, p.post_cms_small, p.post_cms, p.post_datetime, p.post_copywriter_status, p.post_meta_title, p.post_meta_keywords, p.post_meta_description, p.post_url, p.post_url_key FROM post_category pc, post p, (SELECT post_category_id FROM post_category WHERE category_url_key ='".$mCategoryKey."' AND post_category_status = 'Y' AND category_type = 'P') parent_category WHERE pc.post_category_parent_id = parent_category.post_category_id AND pc.category_url_key = '".$sCategoryKey."' AND p.post_category_id = pc.post_category_id AND p.post_publish_status = 'Y'";	
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			//$response = $rs->fetch_all(true);
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		}
		return $response;		
	}
	public function getThisMaterial($id){
		$response = array();
		$sql = "SELECT * from `material` WHERE `material_id` = $id";	
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			$response = $rs->fetch_assoc();
		}
		return $response;			
	}
}

?>