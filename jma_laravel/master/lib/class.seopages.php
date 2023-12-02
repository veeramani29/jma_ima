<?php
class seopages {
	function __construct(){
		$this->db = new mysql();
	}

	function getAllPages(){
		$this->db->open();
		$query_pag_data   = "SELECT seo.*, pst.post_title FROM seopages seo LEFT JOIN post pst ON seo.post_id = pst.post_id ORDER BY seo.id DESC";
		$loglist = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $loglist;
	}
	private function isPostExists($slug_hash){
        $this->db->open();
        $query1 =  "SELECT * FROM  seopages where slug_hash ='".$slug_hash."'";
      	$reslist = $this->db->fetchArray($this->db->query($query1));
        $this->db->close();
        if(count($reslist) > 0){
           return true;
        } else {
           return false;
       }		
	}
	
	function addppage($insertArr){
		if($this->isPostExists($insertArr['slug_hash'])== false) {
			$this->db->open();
			$results = $this->db->insertRecord('seopages', $insertArr);
			return $results;
			$this->db->close();
		}else{
			throw new Exception('Page already exists', 9999);
		}
	}
	
	function deleteThisPost($id){
            $this->db->open();
            $query_pag_data   = "delete from seopages  where id = '$id'";
            $results = $this->db->query($query_pag_data );
		    $this->db->close();
            return $results;		
	}
	
	function getPagetDetails($id){
		$this->db->open();		
        $query_pag_data   = "SELECT * FROM seopages WHERE id='$id'";            
		$postDetails = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $postDetails;
		
	}
	
	function updateSeoPage($insertArr){
		$update = "UPDATE `seopages` SET ";
		$where = " WHERE `id` = ".$insertArr['id'];
		foreach ($insertArr as $ky => $val){
			switch ($ky){
				case 'title':
				case 'slug':
				case 'slug_hash':
				case 'meta_title':
				case 'meta_description':
				case 'mata_keywords':
				case 'post_id':
				case 'content':
					$update .= "`".$ky."`='".$val."',";
					break;
			}
		}
		$update = rtrim($update,',');
            $this->db->open();
            $query_pag_data   = $update.$where;
            $results = $this->db->query($query_pag_data );
		    $this->db->close();
            return $results;	
	}

}
?>
