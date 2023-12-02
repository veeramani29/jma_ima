<?php
class media {
	function __construct(){
		$this->db	     = new mysql();
	}
	/**
	* Function to get client tickets list
	*/
	function getMediaList(){
		$this->db->open();
                $query_pag_data   = "SELECT * FROM media order by media_id desc";            
		$postList = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $postList;
	}
        
        function addMedia($insertArr){
               $this->db->open();
                $results = $this->db->insertRecord('media', $insertArr);
                return $results;
                $this->db->close();
          }
        
        
        function getMediaDetails($mId){
            
                $this->db->open();		
                $query_pag_data   = "SELECT * FROM media WHERE media_id='$mId'";            
		$mDetails = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $mDetails;
            
        }
        
        
         function updateMediaImg($updateId,$imgPath){
            
            $this->db->open();
            $query_pag_data   = "update media set media_value_img = '$imgPath'  where media_id = '$updateId'";
            $results = $this->db->query($query_pag_data );
	    $this->db->close();
            return $results;
            
        }
        
        function updateMediaTxt($updateId,$txt){
            
            $this->db->open();
			$txt = addslashes($txt);
            $query_pag_data   = "update media set media_value_text = '$txt'  where media_id = '$updateId'";
            $results = $this->db->query($query_pag_data );
	    $this->db->close();
            return $results;
            
        }
        
        function updateMediaLink($updateId,$lnk){
            
            $this->db->open();
            $query_pag_data   = "update media set media_link = '$lnk'  where media_id = '$updateId'";
            $results = $this->db->query($query_pag_data );
	    $this->db->close();
            return $results;
            
        }
         function updateMediaDate($updateId,$date){
            
            $this->db->open();
            $query_pag_data   = "update media set media_date = '$date'  where media_id = '$updateId'";
            $results = $this->db->query($query_pag_data );
	        $this->db->close();
            return $results;
            
        }

         function updateMediaSort($updateId,$sort){
            
            $this->db->open();
            $query_pag_data   = "update media set media_sort = '$sort'  where media_id = '$updateId'";
            $results = $this->db->query($query_pag_data );
	        $this->db->close();
            return $results;
            
        }

         function updateMediaNotice($updateId,$notice){
            
            $this->db->open();
            $query_pag_data   = "update media set media_notice = '$notice'  where media_id = '$updateId'";
            $results = $this->db->query($query_pag_data );
	        $this->db->close();
            return $results;
            
        }
       
        
       
        function updateMedia($updateId,$category,$writer,$postTitle,$shortDesc,$postHead,$subHead,$postReleased,$post){
            
            $this->db->open();
			$postTitle = addslashes($postTitle);
			$shortDesc = addslashes($shortDesc);
            $query_pag_data   = "update post set post_category_id = '$category',copywriter_id = '$writer',post_title='$postTitle',
            post_cms_small = '$shortDesc',post_heading = '$postHead',post_subheading = '$subHead',post_released = '$postReleased',post_cms = '$post' where post_id = '$updateId'";
            $results = $this->db->query($query_pag_data );
	    $this->db->close();
            return $results;
            
        }
        
         function changeStatus($postId,$status){
            if($status == 'N'){
                $status = 'Y';
            }
            else{
                $status = 'N';
            }
            $this->db->open();
            $query   = "update  post set post_publish_status  = '$status' where post_id = '$postId'";
            $results = $this->db->query($query);
	    $this->db->close();
            return $results;
            
        }
        
       function deleteMedia($mediaId){
            
                $this->db->open();		
                $query   = "DELETE FROM media WHERE media_id='$mediaId'";            
		$delDetails = $this->db->executeQuery($query);
		$this->db->close();
		return $delDetails;
            
        }
        
        
        function deletePost($postId){
            
            $this->db->open();
            $query_pag_data   = "delete from post_details  where id = '$postId'";
            $results = $this->db->query($query_pag_data );
            if($results == 1){
                $query   = "delete from comment_details  where post_id = '$postId'";
                $results = $this->db->query($query);
            }
	    $this->db->close();
            return $results;
            
        }
	
	
	function getmaxId()
	{
	  $this->db->open();
	    $sql1 = "select max(id) from `post_details`";
		$idPost=$this->db->fetchArray($this->db->query($sql1));
		$idPost=$idPost[0]['max(id)'];
		$this->db->close();
		return $idPost;
	}
	
}
?>
