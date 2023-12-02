<?php
namespace App\Model;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model;
use DB;
class Postcategory extends Model
{	
	protected $table = TBL_POST_CATEGORY;
  #  public $fillable = ['title','description'];
 public function getAllCategory()
{

	$response=array();
	#$items = table($this->table)->where('post_category_status', 'Y')->orderBy('category_order', 'asc')->get();
	$get_Cat = Postcategory::where('post_category_status', 'Y')->orderBy('category_order', 'asc')->get();
	$get_Count = $get_Cat->count();
	
	if($get_Count>0) {
		$get_Arr = $get_Cat->toArray();
		$response = $this->processSubcategories($get_Arr);
		uasort($response, array($this, 'sortCategories'));
	}
	return $response;
 	


}


public function getAllCategoriesWithNewIcon() {
		$response = array();
		try{

		$rs = Postcategory::where('new_icon_display','Y')->where('post_category_status','Y')->get();

		
			if($rs->count()>0) {
				
					$response = $rs->toArray();
				
			}
	
			
		} catch (Exception $ex) {
			throw new Exception('Error..! Database error',9990);
		}
		return $response;
	}
		public $timestamps = false;
public function updateNewIcon($catId,$status) {
		$response = false;
		try{
			if($status == 'Y' || $status == 'N') {



	

				$rs =Postcategory::where('post_category_id',$catId)->update(array('new_icon_display'=>$status));
				
				 if($rs!=null) {
					$response = true;
				}
			} else {
				throw new Exception('Invalid Status', 9999);
			}
		}catch (Exception $ex) {
			throw new Exception($ex->getMessage(), $ex->getCode());
		}
		$rs =Postcategory::select('post_category_parent_id')->where('post_category_id',$catId)->first();

		$rw = $rs->toArray();
		if($rw['post_category_parent_id'] !=0) {
			return $this->updateNewIcon($rw['post_category_parent_id'],$status);
		} else {
			return $response;
		}
	}

public function setPostcategoryParent($subCat_id, $status){
	$response = false;
		try{
			if($status == 'Y') {
				$parentcatId =Postcategory::select('post_category_parent_id')->where('post_category_id',$subCat_id)->where('new_icon_display','Y')->first();
				
				$rs =Postcategory::where('post_category_id',$parentcatId['post_category_parent_id'])->update(array('new_icon_display'=>$status));
				
				 if($rs!=null) {
					$response = true;
					$selectParentsParentId = Postcategory::select('post_category_parent_id')->where('post_category_id',$parentcatId['post_category_parent_id'])->where('new_icon_display','Y')->first();
					if($selectParentsParentId['post_category_parent_id'] != 0) {
						$updateParentsParentId = Postcategory::where('post_category_id',$selectParentsParentId['post_category_parent_id'])->update(array('new_icon_display'=>$status));
					}
				}
			} else {
				throw new Exception('Invalid Status', 9999);
			}
		}catch (Exception $ex) {
			throw new Exception($ex->getMessage(), $ex->getCode());
		}
		return $response;
}



private function processSubcategories($result, $pid = 0) {
	    $op = array();
	if(!empty($result)){
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
	}
		return $op;
}


	public function sortCategories($a,$b) {
		 return $a['details']['category_order'] - $b['details']['category_order'];
	}



	public function getThisCategoryById($cat_id) {
		$response = array();

		$get_Cat = Postcategory::where('post_category_id', $cat_id)->first();
		$get_Count = $get_Cat->count();
	
		if($get_Count>0) {
		$response = $get_Cat->toArray();
		}

		
		return $response;
	}

	public function getAllParentCategoriesByCategoryId($post_cat_id){
		$result_arr = array();

		 $get_Cat = DB::select("CALL getAllParentCategoriesByCategoryId(".$post_cat_id.")");
		 $get_Count =count($get_Cat);
	
	if($get_Count>0) {
		$result_arr = $get_Cat;
		/*foreach ($get_Cat as $get_Cats) {
		$result_arr[] = $get_Cats;
		}*/
		
		
	}
		
	//echo "<pre>";print_r($get_Cat);
		return $result_arr;		
	}


	public function getThisCategoryDetailsByKeyAndParent($key,$parent_cat_id) {
		$response = array();
		try{

			$get_Cat = Postcategory::where('post_category_parent_id', $parent_cat_id)->where('category_url_key', $key)->first();
			

			if($get_Cat && $get_Cat->count() >0) {
				$response =$get_Cat->toArray();
			
			}
		} catch (Exception $ex) {
			throw new Exception('Error..! Database error',9990);
		}
		
			
		return $response;
	}



}
