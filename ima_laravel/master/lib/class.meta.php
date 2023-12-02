<?php
class meta {
	function __construct(){
		$this->db	     = new mysql();
	}
	/**
	* Function to get client tickets list
	*/
	function getMetaList(){
		$this->db->open();
                $query_pag_data   = "SELECT * FROM meta order by meta_id";            
		$postList = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $postList;
	}
        
        function addMeta($insertArr){
               $this->db->open();
                $results = $this->db->insertRecord('meta', $insertArr);
                return $results;
                $this->db->close();
          }
        
        
        function getMetaDetails($mId){
            
                $this->db->open();		
                $query_pag_data   = "SELECT * FROM meta WHERE meta_id='$mId'";            
		$mDetails = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $mDetails;
            
        }

         function updateMetaFilename($updateId,$param){
            
            $this->db->open();
            $query_pag_data   = "update meta set filename = '$param'  where meta_id = '$updateId'";
            $results = $this->db->query($query_pag_data );
	    $this->db->close();
            return $results;
        }
         function updateMetaTitle($updateId,$param){
            
            $this->db->open();
            $query_pag_data   = "update meta set title = '$param'  where meta_id = '$updateId'";
            $results = $this->db->query($query_pag_data );
	    $this->db->close();
            return $results;
        }
         function updateMetaKeywords($updateId,$param){
            
            $this->db->open();
            $query_pag_data   = "update meta set keywords = '$param'  where meta_id = '$updateId'";
            $results = $this->db->query($query_pag_data );
	    $this->db->close();
            return $results;
        }
         function updateMetaDesc($updateId,$param){
            
            $this->db->open();
            $query_pag_data   = "update meta set description = '$param'  where meta_id = '$updateId'";
            $results = $this->db->query($query_pag_data );
	    $this->db->close();
            return $results;
        }
        
       function deleteMeta($mediaId){
            
                $this->db->open();		
                $query   = "DELETE FROM meta WHERE meta_id='$mediaId'";            
		$delDetails = $this->db->executeQuery($query);
		$this->db->close();
		return $delDetails;
            
        }
}
?>
