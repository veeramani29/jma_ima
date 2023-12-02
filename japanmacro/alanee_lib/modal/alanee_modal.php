<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class AlaneeModal {
	
	protected $tableName;
	protected $mapping;
	
	protected function doMapping (){
		$className = get_called_class();
		$this->mapping = get_class_vars($className);
	}
	public function setTableName() {
		
	}
	public function getTableName() {
		
	}
	public function executeQuery($query) {
		$con = new AlaneeDb();
		$oConn = $con->getConnection();
		$res = $oConn->query($query);
		$con->closeConnection();
		return $res;
	}
	public function insertQuery($query) {
		$LiId = 0;
		$con = new AlaneeDb();
		$oConn = $con->getConnection();
		$oConn->query($query);
		$LiId = $oConn->insert_id;
		$con->closeConnection();
		return $LiId;
	}
	public function getThisqueryResult($sql) {
		$response = array();
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			//$response = $rs->fetch_all(true);
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		} 
		return $response;		
	}
	
	protected function mysql_escape_string($str){
		$con = new AlaneeDb();
		$oConn = $con->getConnection();
		$str_escaped = $oConn->real_escape_string($str);
		$con->closeConnection();
		return $str_escaped;
	}
}

?>