<?php
class briefseries {
	function __construct(){
		$this->db	     = new mysql();
	}

	 function getBriefSeries(){
		$this->db->open();
                $query_pag_data   = "SELECT briefseries_id,briefseries_type,briefseries_title,briefseries_description,briefseries_title_img,briefseries_summary_path,briefseries_ppt_path,briefseries_date,is_premium FROM briefseries order by briefseries_id desc";            
		$postList = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $postList;
	 }
        
        function addBriefSeries($insertArr){
               $this->db->open();
                $results = $this->db->insertRecord('briefseries', $insertArr);
                return $results;
                $this->db->close();
          }
        
        
       function getBriefSeriesDetails($mId){
            
                $this->db->open();		
                $query_pag_data   = "SELECT briefseries_id,briefseries_type,briefseries_title,briefseries_description,briefseries_title_img,briefseries_summary_path,briefseries_ppt_path,briefseries_date,is_premium FROM briefseries WHERE briefseries_id='$mId'";            
		$mDetails = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $mDetails;
            
        }
        
          function updateThisBriefSeries($updateId, $values) {
        	$open=$this->db->open();
        	$query_pag_data = "update briefseries set ";
        	foreach ($values as $field => $value) {
        		$query_pag_data .= "`$field` = '".mysqli_real_escape_string($this->db->connection,$value)."', ";
        	}
        	$query_pag_data = trim($query_pag_data,', ');
        	$query_pag_data .= " where briefseries_id = ".$updateId;
            $results = $this->db->query($query_pag_data );
	   		$this->db->close();
            return $results;
        }
       
       /* function updateMedia($updateId,$category,$writer,$postTitle,$shortDesc,$postHead,$subHead,$postReleased,$post){
            
            $this->db->open();
            $query_pag_data   = "update post set post_category_id = '$category',copywriter_id = '$writer',post_title='$postTitle',
            post_cms_small = '$shortDesc',post_heading = '$postHead',post_subheading = '$subHead',post_released = '$postReleased',post_cms = '$post' where post_id = '$updateId'";
            $results = $this->db->query($query_pag_data );
	    	$this->db->close();
            return $results;
            
        }
        */
        
       function deleteBriefSeries($materialId){
            
                $this->db->open();		
                $query   = "DELETE FROM briefseries WHERE briefseries_id='$materialId'";            
		$delDetails = $this->db->executeQuery($query);
		$this->db->close();
		return $delDetails;
            
        } 
}
?>
