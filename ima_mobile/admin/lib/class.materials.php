<?php
class materials {
	function __construct(){
		$this->db	     = new mysql();
	}

	function getMaterialsList(){
		$this->db->open();
                $query_pag_data   = "SELECT * FROM material order by material_id desc";            
		$postList = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $postList;
	}
        
        function addMaterial($insertArr){
               $this->db->open();
                $results = $this->db->insertRecord('material', $insertArr);
                return $results;
                $this->db->close();
          }
        
        
        function getMaterialDetails($mId){
            
                $this->db->open();		
                $query_pag_data   = "SELECT * FROM material WHERE material_id='$mId'";            
		$mDetails = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $mDetails;
            
        }
        
        function updateThisMaterial($updateId, $values) {
        	$this->db->open();
        	$query_pag_data = "update material set ";
        	foreach ($values as $field => $value) {
        		$query_pag_data .= "`$field` = '".mysqli_real_escape_string($this->db->connection,$value)."', ";
        	}
        	$query_pag_data = trim($query_pag_data,', ');
        	$query_pag_data .= " where material_id = ".$updateId;
            $results = $this->db->query($query_pag_data );
	   		$this->db->close();
            return $results;
        }
       
        function updateMedia($updateId,$category,$writer,$postTitle,$shortDesc,$postHead,$subHead,$postReleased,$post){
            
            $this->db->open();
            $query_pag_data   = "update post set post_category_id = '$category',copywriter_id = '$writer',post_title='$postTitle',
            post_cms_small = '$shortDesc',post_heading = '$postHead',post_subheading = '$subHead',post_released = '$postReleased',post_cms = '$post' where post_id = '$updateId'";
            $results = $this->db->query($query_pag_data );
	    	$this->db->close();
            return $results;
            
        }
        
        
       function deleteMaterial($materialId){
            
                $this->db->open();		
                $query   = "DELETE FROM material WHERE material_id='$materialId'";            
		$delDetails = $this->db->executeQuery($query);
		$this->db->close();
		return $delDetails;
            
        }
}
?>
