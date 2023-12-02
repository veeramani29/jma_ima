<?php

/*~ class.comment.php
/**
 * Manage Post comment
 * NOTE: Requires PHP version 5 or later
 * @package Comment
 * @author bonie@reowix.in
 * @copyright 2012 reowix
 */

class category{
    function __construct(){
		$this->db	     = new mysql();
	}
        
   /**
   * Adds a "comment to" post. 
   * @param string $userid    
   * @param int $postId
   * @param string $comment
   * @param string status
   * @return void          
   */
     
    function addComment($userId,$postId,$comment,$status){
                
                $this->db->open();
		$sql="insert into `comment_details` (`user_id`,`post_id`,`comment_content`,`comment_status`,`created_on`) values ('$userId','$postId','$comment','$status',NOW())";               
                $results = $this->db->query($sql);
		$this->db->close();
    }
        
    
    function getAllCatSubCat(){
         $this->db->open();
         $query   = "SELECT * FROM  post_category";            
         $catList = $this->db->fetchArray($this->db->query($query));
          $this->db->close();
         
         if(count($catList)>0){
             $retList = $this->getAllChild($catList);
         }
        
         return $retList;
    }
    
    
    function getAllChild($catList){
        $catExist = array();
         $this->db->open();
        for($i=0;$i<count($catList);$i++){
            $catId  = $catList[$i]['post_category_id'];
             if(!in_array($catId,$catExist)){
                    array_push($catExist, $catId);
                    $query   = "SELECT * FROM  post_category where post_category_parent_id = '$catId' order by category_order asc"; 
                    $chlList = $this->db->fetchArray($this->db->query($query));
                    if(count($chlList)>0){
                                    for($j=0;$j<count($chlList);$j++){
                                            $sId  = $chlList[$j]['post_category_id'];
                                            if(!in_array($sId,$catExist)){
                                                array_push($catExist, $sId);
                                                $queryChild   = "SELECT * FROM  post_category where post_category_parent_id = '$sId' order by category_order asc"; 
                                              
                                                $chl_chl_List = $this->db->fetchArray($this->db->query($queryChild));
                                                if(count($chl_chl_List)>0){
                                                    for($k=0;$k<count($chl_chl_List);$k++){
                                                        $chlChlId   = $chl_chl_List[$k]['post_category_id'];
                                                         if(!in_array($chlChlId,$catExist)){
                                                               array_push($catExist, $chlChlId);
                                                         }
                                                    }
                                                }
                                            }
                                    }
                    }
            }           
        }
         $this->db->close();
         
         return $catExist;
    }
    
    function getCategoryByOrder($catId){
         $this->db->open();		
                $query   = "SELECT * FROM  post_category WHERE post_category_id='$catId'";   
		$catDetails = $this->db->fetchArray($this->db->query($query));
                $this->db->close();
		return $catDetails;
    }
    
    function getParent($catId){
         $this->db->open();
         if($catId == 0){
             $parent = '';
         }
         else{
         $query   = "SELECT * FROM  post_category where  post_category_id  =".$catId;            
         $parentList = $this->db->fetchArray($this->db->query($query));
         $parent = $parentList[0]['post_category_name'];
         }
         $this->db->close();
         return $parent;
    }
    
    function getIndividualCategory($catId){
                $this->db->open();		
                $query   = "SELECT * FROM  post_category WHERE post_category_id='$catId'";   
		$catDetails = $this->db->fetchArray($this->db->query($query));
                $catName = $catDetails[0]['post_category_name'];
		$this->db->close();
		return $catName;
    }

    function getIndividualCategory2($catId){
                $this->db->open();		
                $query   = "SELECT * FROM  post_category WHERE post_category_id='$catId'";   
		$catDetails = $this->db->fetchArray($this->db->query($query));
		$this->db->close();
		return $catDetails[0];
    }
    
     function changeStatus($catId,$status){
            if($status == 'N'){
                $status = 'Y';
            }
            else{
                $status = 'N';
            }
            $this->db->open();
            $query   = "update  post_category set post_category_status  = '$status' where post_category_id = '$catId'";
            $results = $this->db->query($query);
	    $this->db->close();
            return $results;
            
        }
		
		 function new_icon_display($catId,$status){
           
            $this->db->open();
            $query   = "update  post_category set new_icon_display  = '$status' where post_category_id = '$catId'";
            $results = $this->db->query($query);
	        $this->db->close();
            return $results;
            
        }
    
    function getAllCategories(){
                $mainArr  = array();
                $this->db->open();
                $query_pag_data   = "SELECT * FROM  post_category where post_category_parent_id = 0 and post_category_status = 'Y'";            
		$catList = $this->db->fetchArray($this->db->query($query_pag_data));
		        if(count($catList)>0){
                    for($i=0;$i<count($catList);$i++){
                        $catId   = $catList[$i]['post_category_id'];
                        $catName = $catList[$i]['post_category_name'];                      
                        $mainArr[$i] = array(
                                              'mainCatId' =>$catId,
                                              'mainCatName'=>$catName
                                        );
                        
                    }
                }
		$this->db->close();
		return $mainArr;
                    
          }
          
          function getSubChildCategory($catId){
              $this->db->open();
               $query1 =  "SELECT * FROM  post_category where post_category_parent_id =".$catId; 
               $subCatList = $this->db->fetchArray($this->db->query($query1));
               $this->db->close();
              return $subCatList;
          }
          
          function getAllCategoriesWothoutFilter(){
               $this->db->open();
               $query1 =  "SELECT * FROM  post_category"; 
               $subCatList = $this->db->fetchArray($this->db->query($query1));
               $this->db->close();
              return $subCatList;
          }
          
          function addCategories($insertArr){
               if($this->isCategoryExists($insertArr['category_url_key'],$insertArr['post_category_parent_id'])== false) {
	               	$this->db->open();
	                $results = $this->db->insertRecord(' post_category', $insertArr);
	                return $results;
	                $this->db->close();
               }else{
               		throw new Exception('Category already exists', 9999);
               }
          }

 		function isCategoryExists($category_url_key,$post_category_parent_id) {
               $this->db->open();
               $query1 =  "SELECT * FROM  post_category where category_url_key ='".$category_url_key."' AND post_category_parent_id = ".$post_category_parent_id; 
               $subCatList = $this->db->fetchArray($this->db->query($query1));
               $this->db->close();
               if(count($subCatList) > 0){
               	return true;
               } else {
               	return false;
               }
 		}
    
   /**
   * Get authur of comment using userid.     
   * @param int $userId
   * @return $userDetails          
   */
                
   function getCommentAuthor($userId){
               $this->db->open();
               $query   = "SELECT * FROM user_details where id = '$userId'";            
	       $userDetails = $this->db->fetchArray($this->db->query($query));
	       $this->db->close();
	       return $userDetails;
   }
   
       function updteCategories($updateId,$category){
            
            $this->db->open();
            $query_pag_data   = "update post_category set post_category_name  = '$category' where post_category_id = '$updateId'";
            $results = $this->db->query($query_pag_data );
	    $this->db->close();
            return $results;
            
        }
		
		
		function updteDefaultAlert($updateId,$category){
            
            $this->db->open();
            $query_pag_data   = "UPDATE user_accounts SET want_to_email_alert = '$category' WHERE id = '$updateId'";
            $results = $this->db->query($query_pag_data );
	        $this->db->close();
            return $results;
            
        }
		
		
		function selectInDefaultEmailUserId($updateId)
		{
            
            $this->db->open();
            $query_pag_data   = "SELECT want_to_email_alert,id FROM user_accounts WHERE want_to_email_alert LIKE '%$updateId%'";
            $userDetails = $this->db->fetchArray($this->db->query($query_pag_data));
	        $this->db->close();
            return $userDetails;
            
        }
		
		function selectOutDefaultEmailUserId($updateId)
		{
            
            $this->db->open();
            $query_pag_data   = "SELECT want_to_email_alert,id FROM user_accounts WHERE want_to_email_alert NOT  LIKE '%$updateId%'";
            $userDetails = $this->db->fetchArray($this->db->query($query_pag_data));
	        $this->db->close();
            return $userDetails;
            
        }
		
		
		
		
   function updteCategories2($updateId,$category, $title, $keywords, $desc, $category_url, $category_url_key, $post_category_parent_id,$category_type,$category_link,$email_alert,$default_email_alert){
            $this->db->open();
            $sql_check = "SELECT * FROM  post_category where category_url_key ='".$category_url_key."' AND post_category_parent_id = ".$post_category_parent_id." AND post_category_id != ".$updateId; 
            $chk_result = $this->db->fetchArray($this->db->query($sql_check));
            $this->db->close();
            if(count($chk_result)>0) {
            	throw new Exception('Category already exists', 9999);
            } else {
            	$this->db->open();
	            $query_pag_data   = "update post_category set post_category_name  = '$category', category_meta_title='$title', category_meta_keywords='$keywords', category_meta_description='$desc', category_url='$category_url', category_url_key='$category_url_key', category_type = '$category_type', category_link = '$category_link' , email_alert = '$email_alert' , default_email_alert = '$default_email_alert' where post_category_id = $updateId";
	          //  exit($query_pag_data);
	            $results = $this->db->query($query_pag_data );
		    	$this->db->close();
	            return $results;
            }
        }
       
	function updateIcondisp(){
		$this->db->open();
		$query = "SELECT * FROM `post_category` WHERE `new_icon_display` = 'Y' ";
		
		$res =   $this->db->fetchArray($this->db->query($query));
		
		for($i=0;$i<count($res);$i++)
		{
		
			$rs = "SELECT COUNT( * ) AS tot FROM post WHERE DATEDIFF( NOW( ) , `post_datetime` ) <=7 AND post_category_id = '".$res[$i]['post_category_id']."'";
			
					$rst = $this->db->fetchArray($this->db->query($rs));
					
					if($rst[0]['tot'] == '0')
					{
					  $this->new_icon_display($res[$i]['post_category_id'],'N');
								 
					}
	    }
	}
 
	public function updateNewIcon($catId,$status) {
		$response = false;
		$this->db->open();
		try{
			if($status == 'Y' || $status == 'N') {
				$sql = "UPDATE post_category SET `new_icon_display` = '$status' WHERE post_category_id = $catId";
				if($this->db->query($sql)) {
					$response = true;
				}
			} else {
				throw new Exception('Invalid Status', 9999);
			}
		}catch (Exception $ex) {
			throw new Exception($ex->getMessage(), $ex->getCode());
		}
		$sql_getparent = "SELECT `post_category_parent_id` FROM post_category WHERE post_category_id = $catId";
		$rw = $this->db->fetchArray($this->db->query($sql_getparent));
		if(count($rw)>0 && $rw[0]['post_category_parent_id'] !=0) {
			$parent_cat_id = $rw[0]['post_category_parent_id'];
			$update = false;
			if($status == 'N') {
				$sql_chk = "SELECT post_category_id FROM post_category WHERE post_category_parent_id = $parent_cat_id AND post_category_id AND post_category_id != $catId AND new_icon_display = 'Y' AND post_category_status = 'Y'";
				$rw_chk = $this->db->fetchArray($this->db->query($sql_chk));
				if(count($rw_chk)== 0) {
					return $this->updateNewIcon($parent_cat_id,$status);
				}				
			} else {
				return $this->updateNewIcon($parent_cat_id,$status);
			}
		} 
			return $response;
	}
        
    function getOrder($parentId,$catId){
              
               $select = '';
               $option = '';
               $this->db->open();
               $query   = "SELECT * FROM post_category where post_category_parent_id = '$parentId'";            
	       $orderDetails = $this->db->fetchArray($this->db->query($query));
               $this->db->close();
               
               if(count($orderDetails)>0){
                 $select = '<select class="order_select" name=orderList id="orderList_'.$catId.'">';
                 $option=$option.'<option value="">select</option>';
                   for($i=0;$i<count($orderDetails);$i++){
                       $option=$option.'<option value="'.($i+1).'">'.($i+1).'</option>';
                   }
                   
                 $select = $select.$option.'</select>';
               }
               
	       return $select;
   }
   
   
   function updateOrder($catId,$order){
            $this->db->open();
            $query_pag_data   = "update post_category set category_order  = '$order' where post_category_id = '$catId'";
            $results = $this->db->query($query_pag_data );
	    $this->db->close();
            return $results;
   }
   
   function deleteCategory($categorylId){
    	$this->db->open();	
    	$delDetails = false;
    	$query_post = "DELETE FROM post WHERE post_category_id IN (SELECT post_category_id FROM post_category WHERE post_category_id='$categorylId' OR post_category_parent_id='$categorylId')";
    	if($this->db->executeQuery($query_post)) {
        	$query   = "DELETE FROM post_category WHERE post_category_id='$categorylId' OR post_category_parent_id='$categorylId'";            
			$delDetails = $this->db->executeQuery($query);
    	}
		$this->db->close();
		return $delDetails;
            
    }
}
?>
