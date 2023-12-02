<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class Graphdetails extends AlaneeModal {
	
	public function getGraphDetailsForTheseComaseperatedGids($gids) {
		$response = array();
		$sql = "select gid, title from graph_details where gid in ($gids)";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			//$response = $rs->fetch_all(true);
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}	
		} 
		return $response;
	}
	
	public function checkIsPremiumForTheseComaseperatedGids($gids) {
		$result = '';
		$sql = "select gid, title, isPremium from graph_details where gid in ($gids) AND isPremium = 'y'";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			$result = true;
		} 
		else {
			$result = false;
		}
		return $result;
	}
	
	public function getGraphSourceForTheseComaseperatedGids($gids){
		$response = array();
		$sql = "select source FROM graph_details where gid in ($gids)";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			//$response = $rs->fetch_all(true);
			while ($rw = $rs->fetch_assoc()) {
				$sources = explode(',',$rw['source']);
				foreach($sources as $source_ky) {
					$source = trim($source_ky);
					if(!in_array($source,$response)){
						$response[] = $source;
					}
				}
			}
		}
		return implode(', ',$response);
	}
	public function getFilepathForTheseComaseperatedGids($gids) {
		$response = array();
		$sql = "select gid, filepath from graph_details where gid in ($gids)";
		$rs = $this->executeQuery($sql);
		if($rs->num_rows>0) {
			//$response = $rs->fetch_all(true);
			while ($rw = $rs->fetch_assoc()) {
				$response[] = $rw;
			}
		} 
		return $response;
	}
	
}
?>