<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class postCategory extends AlaneeModal {
	
	public function getAllNonPremiumCategory() {
		$result_arr = array();
		$arSubcategories = array();
		$sql = "SELECT * FROM `post_category` WHERE premium_category = 'N' AND `post_category_status` = 'Y' order by category_order asc";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			while ($rw = $rs->fetch_assoc()) {
				$result_arr[] = $rw;
			}
			$response = $this->processSubcategories($result_arr);
			uasort($response, array($this, 'sortCategories'));
		}
		return $response;
	}
	
	private function processSubcategories($result, $pid = 0) {
	    $op = array();
	    foreach( $result as $item ) {
	        if( $item['post_category_parent_id'] == $pid ) {
	            $op[$item['post_category_id']] = array(
	                'details' => $item,
	                'subcategories' =>array()
	            );
	            $children =  $this->processSubcategories( $result, $item['post_category_id'] );
	            if( $children ) {
	                $op[$item['post_category_id']]['subcategories'] = $children;
	            }
	        }
		}
		return $op;
	}
	
	private function addToParent($details,&$result,$dump_arr){
		if(isset($result[$details['post_category_parent_id']])) {
			
		}
		if($details['post_category_parent_id'] == 0) {
			if(!isset($result[$details['post_category_id']])) {
				$response[$result[$details['post_category_id']]]['details'] = $details;
				$response[$result[$details['post_category_id']]]['subcategories'] = array();
				return $result[$details['post_category_id']];
			} else {
				$result[] = $this->addToParent($dump_arr[$details['post_category_parent_id']],$result,$dump_arr);
				return $result;
			}
		}
		
	}
	
	public function getAllPremiumCategory() {
		$result_arr = array();
		$arSubcategories = array();
		$sql = "SELECT * FROM `post_category` WHERE premium_category = 'Y' AND `post_category_status` = 'Y' order by category_order asc";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			while ($rw = $rs->fetch_assoc()) {
				$result_arr[] = $rw;
			}
			$response = $this->processSubcategories($result_arr);
			uasort($response, array($this, 'sortCategories'));
		}
		return $response;
	}
	
	public function updateNewIcon($catId,$status) {
		$response = false;
		try{
			if($status == 'Y' || $status == 'N') {
				$sql = "UPDATE post_category SET `new_icon_display` = '$status' WHERE post_category_id = $catId";
				if($this->executeQuery($sql)) {
					$response = true;
				}
			} else {
				throw new Exception('Invalid Status', 9999);
			}
		}catch (Exception $ex) {
			throw new Exception($ex->getMessage(), $ex->getCode());
		}
		$sql_getparent = "SELECT `post_category_parent_id` FROM post_category WHERE post_category_id = $catId";
		$rs = $this->executeQuery($sql_getparent);
		$rw = $rs->fetch_assoc();
		if($rw['post_category_parent_id'] !=0) {
			return $this->updateNewIcon($rw['post_category_parent_id'],$status);
		} else {
			return $response;
		}
	}
	
	public function getAllCategoriesWithNewIcon() {
		$response = array();
		try{
			$sql_categories = "SELECT * FROM `post_category` WHERE `new_icon_display` = 'Y' AND `post_category_status` = 'Y'";
			$rs = $this->executeQuery($sql_categories);
			if($rs->num_rows>0) {
				while ($rw = $rs->fetch_assoc()) {
					$response[] = $rw;
				}
			}
		//	$sql = "SELECT COUNT( * ) AS tot FROM post WHERE DATEDIFF( NOW( ) , `post_datetime` ) <=7 AND post_category_id = '".$res[$i]['post_category_id']."'";
			
		} catch (Exception $ex) {
			throw new Exception('Error..! Database error',9990);
		}
		return $response;
	}
	
	public function sortCategories($a,$b) {
		 return $a['details']['category_order'] - $b['details']['category_order'];
	}
	
	public function getThisCategoryDetailsByKeyAndParent($key,$parent_cat_id) {
		$response = array();
		try{
			$sql_categories = "SELECT * FROM `post_category` WHERE `post_category_parent_id` = $parent_cat_id AND `category_url_key` = '$key'";
			$rs = $this->executeQuery($sql_categories);
			if($rs->num_rows>0) {
				$response = $rs->fetch_assoc();
				
			}
		} catch (Exception $ex) {
			throw new Exception('Error..! Database error',9990);
		}
		return $response;
	}
	
	
	public function getThisCategoryById($cat_id) {
		$response = array();
		try{
			$sql_categories = "SELECT * FROM `post_category` WHERE `post_category_id` = $cat_id";
			$rs = $this->executeQuery($sql_categories);
			if($rs->num_rows>0) {
				$response = $rs->fetch_assoc();
			}
		} catch (Exception $ex) {
			throw new Exception('Error..! Database error',9990);
		}
		return $response;
	}
	
	public function getAllCategory() {
		$result_arr = array();
		$arSubcategories = array();
		$sql = "SELECT * FROM `post_category` WHERE `post_category_status` = 'Y' order by category_order asc";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			while ($rw = $rs->fetch_assoc()) {
				$result_arr[] = $rw;
			}
			$response = $this->processSubcategories($result_arr);
			uasort($response, array($this, 'sortCategories'));
		}
		return $response;		
	}
	
	public function getAllParentCategoriesByCategoryUrlKey($url_key){
		$result_arr = array();

		 $sql = "CALL getAllParentCategoriesByCategoryUrlKey('".$url_key."')";
		$rs = $this->executeQuery($sql);
		if(isset($rs->num_rows) && $rs->num_rows>0) {


			while ($rw = $rs->fetch_assoc()) {
				$result_arr[] = $rw;
			}
		}
		return $result_arr;		
	}
	
	public function getAllParentCategoriesByCategoryId($post_cat_id){
		$result_arr = array();

		 $sql = "CALL getAllParentCategoriesByCategoryId(".$post_cat_id.")";
		$rs = $this->executeQuery($sql);
		if(isset($rs->num_rows) && $rs->num_rows>0) {

			while ($rw = $rs->fetch_assoc()) {
				$result_arr[] = $rw;
			}
		}
		return $result_arr;		
	}

}

?>