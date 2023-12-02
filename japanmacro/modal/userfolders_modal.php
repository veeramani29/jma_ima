<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');

class Userfolders extends AlaneeModal {
	
public function getFolder($uid, $fid = null ) {

		$result_arr = array();

		$sql = "";

		if(null == $fid) { 
			$sql = "SELECT folder_id,user_id,folder_name,folder_contents,timestamp,status FROM `mychart_user_folders` WHERE `user_id`={$uid}";
		} else {
			$fid = $this->mysql_escape_string($fid);
			$sql = "SELECT folder_id,user_id,folder_name,folder_contents,timestamp,status FROM `mychart_user_folders` WHERE `folder_id`={$fid} AND `user_id`={$uid}";
		}
		try {
			$rs = $this->executeQuery($sql);

			if($rs->num_rows>0) {
				while ($rw = $rs->fetch_assoc()) {
					$folder_rw = array('folder_id'=>$rw['folder_id'],'user_id'=>$rw['user_id'],'folder_name'=>$rw['folder_name'],'timestamp'=>$rw['timestamp'],'status'=>$rw['status']);
					$folder_content_arr = json_decode($rw['folder_contents']);
					$folder_rw['total_charts'] = count($folder_content_arr);
					$result_arr[] = $folder_rw;
				}
			}
			
		} catch (Exception $ex) {
			throw new Exception('Error..! Database error',9990);
		}
		
		return $result_arr;

	}
	
	
	public function getLatestChartBook() {

		$result_arr = array();

		$sql = "";
		
		$sql = "SELECT folder_id,user_id,folder_name,folder_contents,timestamp,status FROM `chartbook_user_folders` ORDER BY folder_id DESC LIMIT 2,1";

		
		try {
			$rs = $this->executeQuery($sql);

			if($rs->num_rows>0) {
				while ($rw = $rs->fetch_assoc()) {
					$folder_rw = array('folder_id'=>$rw['folder_id'],'user_id'=>$rw['user_id'],'folder_name'=>$rw['folder_name'],'timestamp'=>$rw['timestamp'],'status'=>$rw['status']);
					$folder_content_arr = json_decode($rw['folder_contents']);
					$result_arr[] = $folder_rw;
				}
			}
			
		} catch (Exception $ex) {
			throw new Exception('Error..! Database error',9990);
		}
		
		return $result_arr;

	}
	
	
	public function viewChartBookLists() {

		$result_arr = array();

		$sql = "";
		
		$sql = "SELECT folder_id,user_id,folder_name,folder_contents,timestamp,status,folder_desc FROM `chartbook_user_folders` ORDER BY folder_id DESC";

		try {
			$rs = $this->executeQuery($sql);

			if($rs->num_rows>0) {
				while ($rw = $rs->fetch_assoc()) {
					$folder_rw = array('folder_id'=>$rw['folder_id'],'user_id'=>$rw['user_id'],'folder_name'=>$rw['folder_name'],'timestamp'=>$rw['timestamp'],'status'=>$rw['status'],'folder_desc'=>$rw['folder_desc']);
					$folder_content_arr = json_decode($rw['folder_contents']);
					$folder_rw['total_charts'] = count($folder_content_arr);
					$result_arr[] = $folder_rw;
				}
			}
			
		} catch (Exception $ex) {
			throw new Exception('Error..! Database error',9990);
		}
		
		return $result_arr;

	}
	
	public function getChartBook($uid, $fid = null ) {

		$result_arr = array();

		$sql = "";

		if(null == $fid) { 
			$sql = "SELECT folder_id,user_id,folder_name,folder_contents,timestamp,status FROM `chartbook_user_folders` WHERE `user_id`={$uid} AND status = 'INACTIVE' ORDER BY folder_id DESC";
		} else {
			$fid = $this->mysql_escape_string($fid);
			$sql = "SELECT folder_id,user_id,folder_name,folder_contents,timestamp,status FROM `chartbook_user_folders` WHERE `folder_id`={$fid} AND `user_id`={$uid} AND status = 'INACTIVE' ORDER BY folder_id DESC";
		}
		try {
			$rs = $this->executeQuery($sql);

			if($rs->num_rows>0) {
				while ($rw = $rs->fetch_assoc()) {
					$folder_rw = array('folder_id'=>$rw['folder_id'],'user_id'=>$rw['user_id'],'folder_name'=>$rw['folder_name'],'timestamp'=>$rw['timestamp'],'status'=>$rw['status']);
					$folder_content_arr = json_decode($rw['folder_contents']);
					$folder_rw['total_charts'] = count($folder_content_arr);
					$result_arr[] = $folder_rw;
				}
			}
			
		} catch (Exception $ex) {
			throw new Exception('Error..! Database error',9990);
		}
		
		return $result_arr;

	}
	
	
	public function collectchartbook() {

		$result_arr = array();
		$sql = "";

		$sql = "SELECT folder_id,user_id,folder_name,folder_contents,timestamp,status FROM `chartbook_user_folders` ORDER BY folder_id DESC" ;
		
		try 
		{
			$rs = $this->executeQuery($sql);
			
			if($rs->num_rows>0) {
				while ($rw = $rs->fetch_assoc()) {
					$folder_rw = array('folder_id'=>$rw['folder_id'],'user_id'=>$rw['user_id'],'folder_name'=>$rw['folder_name'],'timestamp'=>$rw['timestamp'],'status'=>$rw['status']);
					$folder_content_arr = json_decode($rw['folder_contents']);
					$folder_rw['total_charts'] = count($folder_content_arr);
					$result_arr[] = $folder_rw;
				}
			}

		} catch (Exception $ex) {
			throw new Exception('Error..! Database error',9990);
		}
		
		return $result_arr;

	}
	
	public function getChartBookList($uid, $fid = null ) {

		$result_arr = array();

		$sql = "";

		if(null == $fid) { 
			$sql = "SELECT folder_id,user_id,folder_name,folder_contents,timestamp,status FROM `chartbook_user_folders` ORDER BY folder_id DESC" ;
		} else {
			$fid = $this->mysql_escape_string($fid);
			$sql = "SELECT folder_id,user_id,folder_name,folder_contents,timestamp,status FROM `chartbook_user_folders` WHERE `folder_id`={$fid} AND `user_id`={$uid} ORDER BY folder_id DESC";
		}
		try {
			$rs = $this->executeQuery($sql);

			if($rs->num_rows>0) {
				while ($rw = $rs->fetch_assoc()) {
					$folder_rw = array('folder_id'=>$rw['folder_id'],'user_id'=>$rw['user_id'],'folder_name'=>$rw['folder_name'],'timestamp'=>$rw['timestamp'],'status'=>$rw['status']);
					$folder_content_arr = json_decode($rw['folder_contents']);
					$folder_rw['total_charts'] = count($folder_content_arr);
					$result_arr[] = $folder_rw;
				}
			}
			
		} catch (Exception $ex) {
			throw new Exception('Error..! Database error',9990);
		}
		
		return $result_arr;

	}
	
	public function getChartBookInactiveList($uid, $fid = null ) {

		$result_arr = array();

		$sql = "";

		if(null == $fid) { 
			$sql = "SELECT folder_id,user_id,folder_name,folder_contents,timestamp,status FROM `chartbook_user_folders` WHERE status = 'INACTIVE' ORDER BY folder_id DESC";
		} else {
			$fid = $this->mysql_escape_string($fid);
			$sql = "SELECT folder_id,user_id,folder_name,folder_contents,timestamp,status FROM `chartbook_user_folders` WHERE `folder_id`={$fid} AND `user_id`={$uid} AND status = 'INACTIVE' ORDER BY folder_id DESC";
		}
		try {
			$rs = $this->executeQuery($sql);

			if($rs->num_rows>0) {
				while ($rw = $rs->fetch_assoc()) {
					$folder_rw = array('folder_id'=>$rw['folder_id'],'user_id'=>$rw['user_id'],'folder_name'=>$rw['folder_name'],'timestamp'=>$rw['timestamp'],'status'=>$rw['status']);
					$folder_content_arr = json_decode($rw['folder_contents']);
					$folder_rw['total_charts'] = count($folder_content_arr);
					$result_arr[] = $folder_rw;
				}
			}
			
		} catch (Exception $ex) {
			throw new Exception('Error..! Database error',9990);
		}
		
		return $result_arr;

	}
	
	
	public function getActiveChartBookList($uid, $fid = null ) {

		$result_arr = array();

		$sql = "";

		if(null == $fid) { 
			$sql = "SELECT folder_id,user_id,folder_name,folder_contents,timestamp,status FROM `chartbook_user_folders` WHERE status = 'ACTIVE' ORDER BY folder_id DESC" ;
		} else {
			$fid = $this->mysql_escape_string($fid);
			$sql = "SELECT folder_id,user_id,folder_name,folder_contents,timestamp,status FROM `chartbook_user_folders` WHERE `folder_id`={$fid} AND `user_id`={$uid} AND status = 'ACTIVE' ORDER BY folder_id DESC";
		}
		try {
			$rs = $this->executeQuery($sql);

			if($rs->num_rows>0) {
				while ($rw = $rs->fetch_assoc()) {
					$folder_rw = array('folder_id'=>$rw['folder_id'],'user_id'=>$rw['user_id'],'folder_name'=>$rw['folder_name'],'timestamp'=>$rw['timestamp'],'status'=>$rw['status']);
					$folder_content_arr = json_decode($rw['folder_contents']);
					$folder_rw['total_charts'] = count($folder_content_arr);
					$result_arr[] = $folder_rw;
				}
			}
			
		} catch (Exception $ex) {
			throw new Exception('Error..! Database error',9990);
		}
		
		return $result_arr;

	}

	public function putFolder( $uid, $fname ) {
		$sql = "";
		$folder_id = 0;
		try{
			$sql = "INSERT INTO `mychart_user_folders` ( `user_id`, `folder_name`) VALUES ('{$uid}', '{$fname}')";
			$folder_id = $this->insertQuery($sql);
		//	exit($folder_id);
		}catch (Exception $ex) {
			throw new Exception($ex->getMessage(), $ex->getCode());
		}
		return $folder_id;
	}
	
	
	public function putChartBook( $uid, $fname ) {
		$sql = "";
		$folder_id = 0;
		try{
			$sql = "INSERT INTO `chartbook_user_folders` ( `user_id`, `folder_name`) VALUES ('{$uid}', '{$fname}')";
			$folder_id = $this->insertQuery($sql);
		//	exit($folder_id);
		}catch (Exception $ex) {
			throw new Exception($ex->getMessage(), $ex->getCode());
		}
		return $folder_id;
	}

	public function updateFolder( $fid, $fname ) {

		$sql = "";

		$response = false;
		try{
			$sql = "UPDATE `mychart_user_folders` SET `folder_name` = '{$fname}' WHERE `mychart_user_folders`.`folder_id` = {$fid}";
			if($this->executeQuery($sql)) {
				$response = true;
			}
			else {
				throw new Exception('Invalid Data', 9999);
			}
		}catch (Exception $ex) {
			throw new Exception($ex->getMessage(), $ex->getCode());
		}
		
		return $response;

	}
	
	
	public function updateChartBookRename( $fid, $fname ) {

		$sql = "";

		$response = false;
		try{
			$sql = "UPDATE `chartbook_user_folders` SET `folder_name` = '{$fname}' WHERE `chartbook_user_folders`.`folder_id` = {$fid}";
			if($this->executeQuery($sql)) {
				$response = true;
			}
			else {
				throw new Exception('Invalid Data', 9999);
			}
		}catch (Exception $ex) {
			throw new Exception($ex->getMessage(), $ex->getCode());
		}
		
		return $response;

	}

	public function deleteFolder( $fid ) {

		$sql = "";

		$response = false;
		try{
			$sql = "DELETE FROM `mychart_user_folders` WHERE `mychart_user_folders`.`folder_id`={$fid}";
			if($this->executeQuery($sql)) {
				$response = true;
			}
			else {
				echo "{$sql}";
				throw new Exception('Invalid Data', 9999);
			}
		}catch (Exception $ex) {
			throw new Exception($ex->getMessage(), $ex->getCode());
		}
		
		return $response;

	}
	
	
	public function deleteChartBook( $fid ) {

		$sql = "";

		$response = false;
		try{
			$sql = "DELETE FROM `chartbook_user_folders` WHERE `chartbook_user_folders`.`folder_id`={$fid}";
			if($this->executeQuery($sql)) {
				$response = true;
			}
			else {
				echo "{$sql}";
				throw new Exception('Invalid Data', 9999);
			}
		}catch (Exception $ex) {
			throw new Exception($ex->getMessage(), $ex->getCode());
		}
		
		return $response;

	}
	
	
	public function changeStatuaChartBook( $fid ,$fstatus ) {

		$sql = "";

		$response = false;
		try{
			$sql = "UPDATE `chartbook_user_folders` SET `status` = '".$fstatus."' WHERE `folder_id` = {$fid}";
			if($this->executeQuery($sql)) {
				$response = true;
			}
			else {
				echo "{$sql}";
				throw new Exception('Invalid Data', 9999);
			}
		}catch (Exception $ex) {
			throw new Exception($ex->getMessage(), $ex->getCode());
		}
		
		return $response;

	}
	
	
	
	public function saveThisChartBookToMychart($folder_id,$user_id)
	{
		try {
			/* $existingData = $this->getThisChartBookListContent($folder_id,$user_id);
			if($existingData[0]['folder_contents'] != ''){
				$existingFolderContent = json_decode($existingData[0]['folder_contents']);
			}else{
				$existingFolderContent = array();
			}
			$existingFolderContent[] = $chart_data;
			$existingFolderContent_json = json_encode($existingFolderContent); */
			//var_dump($existingFolderContent);
			//var_dump($existingFolderContent_json);
			//exit();
			/* if($this->savethisChartBookListContent($folder_id,$user_id,$existingFolderContent_json)){
				return true;
			} */
			
			if($details = $this->savethisChartBookListToMychart($folder_id,$user_id)){
				return $details;
			}
			
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
	}
	
	 public function saveThisChartTochartBook($folder_id,$user_id,$chart_data){
		try {
			$existingData = $this->getThisChartBookListContent($folder_id,$user_id);
			if($existingData[0]['folder_contents'] != ''){
				$existingFolderContent = json_decode($existingData[0]['folder_contents']);
			}else{
				$existingFolderContent = array();
			}
			$existingFolderContent[] = $chart_data;
			$existingFolderContent_json = json_encode($existingFolderContent);
			//var_dump($existingFolderContent);
			//var_dump($existingFolderContent_json);
			//exit();
			if($this->savethisChartBookListContent($folder_id,$user_id,$existingFolderContent_json)){
				return true;
			}
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
	}
	
	
	public function saveThisChartToFolder($folder_id,$user_id,$chart_data){
		try {
			$existingData = $this->getThisFolderContent($folder_id,$user_id);
			if($existingData[0]['folder_contents'] != ''){
				$existingFolderContent = json_decode($existingData[0]['folder_contents']);
			}else{
				$existingFolderContent = array();
			}
			$existingFolderContent[] = $chart_data;
			$existingFolderContent_json = json_encode($existingFolderContent);
			//var_dump($existingFolderContent);
			//var_dump($existingFolderContent_json);
			//exit();
			if($this->savethisFolderContent($folder_id,$user_id,$existingFolderContent_json)){
				return true;
			}
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
	}
	
	public function updateThisEditedChart($folder_id,$user_id,$chart_data){
		try {
			$existingData = $this->getThisFolderContent($folder_id,$user_id);
			if($existingData[0]['folder_contents'] != ''){
				$existingFolderContent = json_decode($existingData[0]['folder_contents']);
			}else{
				throw new Exception("Error.. Chart not found in myChart",9999);
			}
			$new_folderContent = Array();
			foreach ($existingFolderContent as $ky=>$folderContent){
				if($folderContent->uuid == $chart_data['uuid']){
					$folderContent->chart_code = $chart_data['chart_code'];

					if(isset($chart_data['chart_action']) && isset($chart_data['chart_view_type'])){
$folderContent->chart_view_type = $chart_data['chart_view_type'];
}else{

$folderContent->chart_view_type = 'chart';

$folderContent->chart_view_type = $chart_data['chart_view_type'];

$folderContent->current_chart_codes = $chart_data['current_chart_codes'];
$folderContent->navigator_date_from = $chart_data['navigator_date_from'];
$folderContent->navigator_date_to = $chart_data['navigator_date_to'];
$folderContent->chartType = $chart_data['chartType'];
$folderContent->isMultiaxis = $chart_data['isMultiaxis'];
}

					
				}
				$new_folderContent[] = $folderContent;
			}
			if($this->savethisFolderContent($folder_id,$user_id,json_encode($new_folderContent))){
				return true;
			}
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
		
	}
	
	
	public function updateThisEditedChartBook($folder_id,$user_id,$chart_data){
		try {
			$existingData = $this->getThisChartBookListContent($folder_id,$user_id);
			if($existingData[0]['folder_contents'] != ''){
				$existingFolderContent = json_decode($existingData[0]['folder_contents']);
			}else{
				throw new Exception("Error.. Chart not found in myChart",9999);
			}
			$new_folderContent = Array();
			foreach ($existingFolderContent as $ky=>$folderContent){
				if($folderContent->uuid == $chart_data['uuid']){
					$folderContent->chart_code = $chart_data['chart_code'];

					if(isset($chart_data['chart_action']) && isset($chart_data['chart_view_type'])){
$folderContent->chart_view_type = $chart_data['chart_view_type'];
}else{

$folderContent->chart_view_type = 'chart';

$folderContent->chart_view_type = $chart_data['chart_view_type'];

$folderContent->current_chart_codes = $chart_data['current_chart_codes'];
$folderContent->navigator_date_from = $chart_data['navigator_date_from'];
$folderContent->navigator_date_to = $chart_data['navigator_date_to'];
$folderContent->chartType = $chart_data['chartType'];
$folderContent->isMultiaxis = $chart_data['isMultiaxis'];
}

					
				}
				$new_folderContent[] = $folderContent;
			}
			if($this->savethisChartBookListContent($folder_id,$user_id,json_encode($new_folderContent))){
				return true;
			}
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
		
	}
	
	public function deleteThisFolderContent($folder_id,$user_id,$uuid){
		try {
			$existingData = $this->getThisFolderContent($folder_id,$user_id);
			if($existingData[0]['folder_contents'] != ''){
				$existingFolderContent = json_decode($existingData[0]['folder_contents']);
			}else{
				throw new Exception("Error.. Chart not found in myChart",9999);
			}
			$new_folderContent = Array();
			foreach ($existingFolderContent as $ky=>$folderContent){
				if($folderContent->uuid != $uuid){
					$new_folderContent[] = $folderContent;
				}
			}
			if($this->savethisFolderContent($folder_id,$user_id,json_encode($new_folderContent))){
				return true;
			}
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}	
	}
	
	public function deleteThisChartBookContent($folder_id,$user_id,$uuid){
		try {
			$existingData = $this->getThisChartBookListContent($folder_id,$user_id);
			if($existingData[0]['folder_contents'] != ''){
				$existingFolderContent = json_decode($existingData[0]['folder_contents']);
			}else{
				throw new Exception("Error.. Chart not found in myChart",9999);
			}
			$new_folderContent = Array();
			foreach ($existingFolderContent as $ky=>$folderContent){
				if($folderContent->uuid != $uuid){
					$new_folderContent[] = $folderContent;
				}
			}
			if($this->savethisChartBookListContent($folder_id,$user_id,json_encode($new_folderContent))){
				return true;
			}
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}	
	}
	
	public function duplicateContentFromThis($folder_id,$user_id,$currentUuid,$newUuid,$currentOrder){
		try {
			$existingData = $this->getThisFolderContent($folder_id,$user_id);
			if($existingData[0]['folder_contents'] != ''){
				$existingFolderContent = json_decode($existingData[0]['folder_contents']);
			}else{
				throw new Exception("Error.. Chart not found in myChart",9999);
			}
			$new_content = clone($existingFolderContent[$currentOrder]);
			$new_content->uuid = $newUuid;
			$newOrder = $currentOrder+1;
			array_splice($existingFolderContent,$newOrder,0,array($new_content));
			if($this->savethisFolderContent($folder_id,$user_id,json_encode($existingFolderContent))){
				return true;
			}
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}		
	}
	
	
	public function duplicateChartBookContentFromThis($folder_id,$user_id,$currentUuid,$newUuid,$currentOrder){
		try {
			$existingData = $this->getThisChartBookListContent($folder_id,$user_id);
			if($existingData[0]['folder_contents'] != ''){
				$existingFolderContent = json_decode($existingData[0]['folder_contents']);
			}else{
				throw new Exception("Error.. Chart not found in myChart",9999);
			}
			$new_content = clone($existingFolderContent[$currentOrder]);
			$new_content->uuid = $newUuid;
			$newOrder = $currentOrder+1;
			array_splice($existingFolderContent,$newOrder,0,array($new_content));
			if($this->savethisChartBookListContent($folder_id,$user_id,json_encode($existingFolderContent))){
				return true;
			}
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}		
	}
	
	
	private function getThisFolderContent($folder_id,$user_id){
		try {
			$sql = "SELECT * FROM `mychart_user_folders` WHERE `folder_id`={$folder_id} AND `user_id`={$user_id}";
			return $this->getThisqueryResult($sql);
		}catch (Exception $ex){
			throw new Exception("Error in fetching data",9999);
		}
		
	}
	
	private function getLastFolderContents(){
		try {
			$sql = "SELECT * FROM mychart_user_folders ORDER BY folder_id DESC LIMIT 0,1";
			return $this->getThisqueryResult($sql);
		}catch (Exception $ex){
			throw new Exception("Error in fetching data",9999);
		}
		
	}
	
	
	private function getThisChartBookListContent($folder_id,$user_id){
		try {
			$sql = "SELECT * FROM `chartbook_user_folders` WHERE `folder_id`={$folder_id} AND `user_id`={$user_id}";
			return $this->getThisqueryResult($sql);
		}catch (Exception $ex){
			throw new Exception("Error in fetching data",9999);
		}
		
	}
	
	private function getThisChartBookContent($folder_id,$user_id){
		try {
			$sql = "SELECT * FROM `chartbook_user_folders` WHERE `folder_id`={$folder_id} AND `user_id`=(SELECT  id  FROM `user_accounts` WHERE isAuthor = 'Y')";
			return $this->getThisqueryResult($sql);
		}catch (Exception $ex){
			throw new Exception("Error in fetching data",9999);
		}
		
	}
	
	public function getThisChartBookSelectAllList($folder_id,$user_id){
		try {
			$sql = "SELECT * FROM `chartbook_user_folders` WHERE `folder_id`={$folder_id} AND `user_id`=(SELECT  id  FROM `user_accounts` WHERE isAuthor = 'Y')";
			return $this->getThisqueryResult($sql);
		}catch (Exception $ex){
			throw new Exception("Error in fetching data",9999);
		}
		
	}


	
	public function getFolderContent($folder_id,$user_id){
		try {
			$sql = "SELECT * FROM `mychart_user_folders` WHERE `folder_id`={$folder_id} AND `user_id`={$user_id}";
			return $this->getThisqueryResult($sql);
		}catch (Exception $ex){
			throw new Exception("Error in fetching data",9999);
		}
		
	}
	
	private function savethisFolderContent($folder_id,$user_id,$chart_data){
		try {
			$chart_data=$this->mysql_escape_string($chart_data);
			$sql = "UPDATE `mychart_user_folders` SET `folder_contents` = \"{$chart_data}\" WHERE `folder_id`={$folder_id} AND `user_id`={$user_id}";
			if($this->executeQuery($sql)) {
				return true;
			}else{
				throw new Exception("Error in saving data",9999);
			}
			
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
		
	}
	
	private function savethisChartBookListContent($folder_id,$user_id,$chart_data){
		try {
			$chart_data=$this->mysql_escape_string($chart_data);
			$sql = "UPDATE `chartbook_user_folders` SET `folder_contents` = \"{$chart_data}\" WHERE `folder_id`={$folder_id} AND `user_id`={$user_id}";
			if($this->executeQuery($sql)) {
				return true;
			}else{
				throw new Exception("Error in saving data",9999);
			}
			
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
		
	}
	
	
	
	private function updatethisChartBookDescription($folder_id,$desc){
		try {
			$chart_data=$this->mysql_escape_string($chart_data);
			$sql = "UPDATE `chartbook_user_folders` SET `folder_desc` = \"{$desc}\" WHERE `folder_id`={$folder_id}";
			if($this->executeQuery($sql)) {
				return true;
			}else{
				throw new Exception("Error in saving data",9999);
			}
			
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
		
	}
	
	private function savethisChartBookListToMychart($folder_id,$user_id){
		try {
			
			
			/* $exitsFolder = "";
			$id = mysql_insert_id();
			
			$selectExistsRow = "select chartbook_to_mychart from chartbook_user_folders where folder_id=$folder_id";
			$reltsExitsRow = $this->getThisqueryResult($selectExistsRow);
			if($reltsExitsRow[0]['chartbook_to_mychart'] !="")
			{
				$exitsFolder = $reltsExitsRow[0]['chartbook_to_mychart']
			}
			
			$sqlUpdateExitsFolder = "UPDATE `chartbook_user_folders` SET chartbook_to_mychart = ".$exitsFolder." WHERE folder_id=".$folder_id.""; */
			
			
			
			$sql = "INSERT INTO mychart_user_folders (user_id,folder_name,folder_contents) SELECT  $user_id,mychart.folder_name,mychart.folder_contents FROM chartbook_user_folders AS  mychart WHERE mychart.folder_id = '".$folder_id."'";
			if($this->executeQuery($sql)) {
				
				$folderContent = $this->getLastFolderContents();
				$folderData = array(
					'id' => $folderContent[0]['folder_id'],
					'name' => $folderContent[0]['folder_name'],
					'content' => json_decode($folderContent[0]['folder_contents']),
					'status' => $folderContent[0]['status']
				);
				
			    return $folderData;
				
			}else{
				throw new Exception("Error in saving data",9999);
			}
			
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
		
	}
	
	
	
	
	public function getThisFolderData($folder_id, $user_id){
		try {
			$folderContent = $this->getThisFolderContent($folder_id,$user_id);
			$folderData = array(
				'id' => $folderContent[0]['folder_id'],
				'name' => $folderContent[0]['folder_name'],
				'content' => json_decode($folderContent[0]['folder_contents']),
				'status' => $folderContent[0]['status']
			);
			return $folderData;
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
	}
	
	public function getThisCahertBookData($folder_id, $user_id){
		try {
			$folderContent = $this->getThisChartBookContent($folder_id,$user_id);
			$folderData = array(
				'id' => $folderContent[0]['folder_id'],
				'name' => $folderContent[0]['folder_name'],
				'content' => json_decode($folderContent[0]['folder_contents']),
				'status' => $folderContent[0]['status']
			);
			return $folderData;
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
	}
	
	private function getChartObjectWithThisUuid($objArr,$search_uuid){
		foreach ($objArr as $idx => $chartObj){
			if($chartObj->uuid == $search_uuid){
				return $objArr[$idx];
			}
		}
	}
	
	public function updateOrder($folder_id, $user_id, $aNewOrder){
		try {
			$folderContent_rw = $this->getThisFolderContent($folder_id,$user_id);
			$folderContent = json_decode($folderContent_rw[0]['folder_contents']);
			$new_folderContent = Array();
			foreach ($aNewOrder as $i_ord=>$uuid){
				$new_folderContent[] = $this->getChartObjectWithThisUuid($folderContent,$uuid);
			}
			return $this->savethisFolderContent($folder_id,$user_id,json_encode($new_folderContent));
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
	}
	
	public function updateChartBookOrder($folder_id, $user_id, $aNewOrder){
		try {
			$folderContent_rw = $this->getThisChartBookListContent($folder_id,$user_id);
			$folderContent = json_decode($folderContent_rw[0]['folder_contents']);
			$new_folderContent = Array();
			foreach ($aNewOrder as $i_ord=>$uuid){
				$new_folderContent[] = $this->getChartObjectWithThisUuid($folderContent,$uuid);
			}
			return $this->savethisChartBookListContent($folder_id,$user_id,json_encode($new_folderContent));
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
	}
	
	
	public function addThisContentToFolder($folder_id,$user_id,$chart_data){
		try{
			$folderContent_rw = $this->getThisFolderContent($folder_id,$user_id);
			$folderContent = json_decode($folderContent_rw[0]['folder_contents']);
			$folderContent[] = $chart_data;
			return $this->savethisFolderContent($folder_id,$user_id,json_encode($folderContent));
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
	}
	
	
	public function addThisContentToChartBook($folder_id,$user_id,$chart_data){
		try{
			$folderContent_rw = $this->getThisChartBookListContent($folder_id,$user_id);
			$folderContent = json_decode($folderContent_rw[0]['folder_contents']);
			$folderContent[] = $chart_data;
			return $this->savethisChartBookListContent($folder_id,$user_id,json_encode($folderContent));
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
	}
	
	public function saveThisNoteContentByUUID($folder_id,$user_id,$uuid,$note_content){
		try {
		//	$note_content = $this->mysql_escape_string($note_content);
			$folderContent_rw = $this->getThisFolderContent($folder_id,$user_id);
			$folderContent = json_decode($folderContent_rw[0]['folder_contents']);
			$new_folderContent = Array();
			foreach ($folderContent as $order=>$content){
				if($content->uuid == $uuid){
					$content->note_content = $note_content;
				}
				$new_folderContent[] = $content;
			}
			return $this->savethisFolderContent($folder_id,$user_id,json_encode($new_folderContent));			
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
	}
	
	
	public function saveThisNoteContentByUUIDForChartBook($folder_id,$user_id,$uuid,$note_content){
		try {
		//	$note_content = $this->mysql_escape_string($note_content);
			$folderContent_rw = $this->getThisChartBookListContent($folder_id,$user_id);
			$folderContent = json_decode($folderContent_rw[0]['folder_contents']);
			$new_folderContent = Array();
			foreach ($folderContent as $order=>$content){
				if($content->uuid == $uuid){
					$content->note_content = $note_content;
				}
				$new_folderContent[] = $content;
			}
			return $this->savethisChartBookListContent($folder_id,$user_id,json_encode($new_folderContent));			
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
	}
	
	public function saveChartTitleByUUID($folder_id,$user_id,$uuid,$title_content){
		try {
			//	$note_content = $this->mysql_escape_string($note_content);
			$folderContent_rw = $this->getThisFolderContent($folder_id,$user_id);
			$folderContent = json_decode($folderContent_rw[0]['folder_contents']);
			$new_folderContent = Array();
			foreach ($folderContent as $order=>$content){
				if($content->uuid == $uuid){
					$content->title = $title_content;
				}
				$new_folderContent[] = $content;
			}
			return $this->savethisFolderContent($folder_id,$user_id,json_encode($new_folderContent));
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
	}
	
	
	public function saveChartTitleByUUIDForChartBook($folder_id,$user_id,$uuid,$title_content){
		try {
			//	$note_content = $this->mysql_escape_string($note_content);
			$folderContent_rw = $this->getThisChartBookListContent($folder_id,$user_id);
			$folderContent = json_decode($folderContent_rw[0]['folder_contents']);
			$new_folderContent = Array();
			foreach ($folderContent as $order=>$content){
				if($content->uuid == $uuid){
					$content->title = $title_content;
				}
				$new_folderContent[] = $content;
			}
			return $this->savethisChartBookListContent($folder_id,$user_id,json_encode($new_folderContent));
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
	}
	
	public function updateChartBookDescription($folder_id,$desc){
		try {
			return $this->updatethisChartBookDescription($folder_id,$desc);
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
	}
	
	
	public function getTotalNumberOfFoldersForThisUser($user_id){
		try {
			$sql = "SELECT COUNT('folder_id') as 'TotalFolders' FROM `mychart_user_folders` WHERE `user_id`={$user_id}";
			$rs = $this->getThisqueryResult($sql); 
			return $rs[0]['TotalFolders'];
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
	}
	
	public function getTotalNumberOfContentsInThisFolder($folder_id,$user_id){
		try {
			$sql = "SELECT `folder_contents` FROM `mychart_user_folders` WHERE `folder_id`={$folder_id} AND `user_id`={$user_id}";
			$rs = $this->getThisqueryResult($sql);
			$folder_content =  json_decode($rs[0]['folder_contents']);
			return count($folder_content);
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
	}

	
}

?>

