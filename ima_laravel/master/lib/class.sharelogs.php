<?php
class sharelogs {
	function __construct(){
		$this->db	     = new mysql();
	}

	function getAllLogs(){
		$this->db->open();
		$query_pag_data   = "SELECT * FROM share_graph_log order by id desc";
		$loglist = $this->db->fetchArray($this->db->query($query_pag_data));
		$this->db->close();
		return $loglist;
	}

	function deleteMaterial($logId){

		$this->db->open();
		$query   = "DELETE FROM share_graph_log WHERE id='$logId'";
		$delDetails = $this->db->executeQuery($query);
		$this->db->close();
		return $delDetails;

	}
}
?>
