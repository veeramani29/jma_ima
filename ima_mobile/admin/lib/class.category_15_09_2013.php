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
    
    function getAllCategories(){
                $mainArr  = array();
                $this->db->open();
                $query_pag_data   = "SELECT * FROM  post_category where post_category_parent_id = 0 and post_category_status = 'Y'";            
		$catList = $this->db->fetchArray($this->db->query($query_pag_data));
                if(count($catList)>0){
                    for($i=0;$i<count($catList);$i++){
                        $subCatId   = '';
                        $subCatName = '';
                        $catId   = $catList[$i]['post_category_id'];
                        $catName = $catList[$i]['post_category_name'];
                        $query1 =  "SELECT * FROM  post_category where post_category_parent_id =".$catId; 
                        $subCatList = $this->db->fetchArray($this->db->query($query1));
                        if(count($subCatList)>0){
                              for($j=0;$j<count($subCatList);$j++){
                                $subCatId   = $subCatList[$j]['post_category_id'];
                                $subCatName = $subCatList[$j]['post_category_name'];
                                $subCatName = $catName."-".$subCatName;
                              }
                        }
                      
                        $mainArr[$i] = array(
                                              'mainCatId' =>$catId,
                                              'mainCatName'=>$catName,
                                              'subCatId'   => $subCatId,
                                              'subCatName' => $subCatName,
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
          
          function addCategories($insertArr){
               $this->db->open();
                $results = $this->db->insertRecord(' post_category', $insertArr);
                return $results;
                $this->db->close();
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
   function updteCategories2($updateId,$category, $title, $keywords, $desc){
            
            $this->db->open();
            $query_pag_data   = "update post_category set post_category_name  = '$category', category_meta_title='$title', category_meta_keywords='$keywords', category_meta_description='$desc' where post_category_id = '$updateId'";
            $results = $this->db->query($query_pag_data );
	    $this->db->close();
            return $results;
            
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
   
  
}
?>
