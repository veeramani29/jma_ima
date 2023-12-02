<?php
namespace App\Model;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model;
use Exception;
use DB;
class Userfolders extends Model {
	 protected $table = TBL_MYCHART_FOLDERS;
	
public function getFolder($uid, $fid = null ) {

		$result_arr = array();

		$sql = "";
	

		if(null == $fid) { 
			$sql = "SELECT folder_id,user_id,folder_name,folder_contents,timestamp,status FROM `mychart_user_folders` WHERE `user_id`={$uid}";
		} else {
			#$fid = $this->mysql_escape_string($fid);
			$sql = "SELECT folder_id,user_id,folder_name,folder_contents,timestamp,status FROM `mychart_user_folders` WHERE `folder_id`={$fid} AND `user_id`={$uid}";
		}
		try {
			$rs = DB::select($sql);
		    $get_Count =count($rs);

			if($get_Count>0) {
				$get_Arr = json_decode(json_encode($rs), true);
			    foreach($get_Arr as $get_Arrs) {
					$folder_rw = array('folder_id'=>$get_Arrs['folder_id'],'user_id'=>$get_Arrs['user_id'],'folder_name'=>$get_Arrs['folder_name'],'timestamp'=>$get_Arrs['timestamp'],'status'=>$get_Arrs['status']);
					$folder_content_arr = json_decode($get_Arrs['folder_contents']);
					$folder_rw['total_charts'] = is_array($folder_content_arr)?count($folder_content_arr):0;
					$result_arr[] = $folder_rw;
				}
			}
			
		} catch (Exception $ex) {
			throw new Exception('Error..! '.$ex->getMessage(), $ex->getCode());
		}
		
		return $result_arr;

	}
	
	public function getFolderForFree($uid, $fid = null ) {

		$result_arr = array();

		$sql = "";

		if(null == $fid) { 
			$sql = "SELECT folder_id,user_id,folder_name,folder_contents,timestamp,status FROM `mychart_user_folders` WHERE `user_id`={$uid} LIMIT 0,1";
		} else {
			#$fid = $this->mysql_escape_string($fid);
			$sql = "SELECT folder_id,user_id,folder_name,folder_contents,timestamp,status FROM `mychart_user_folders` WHERE `folder_id`={$fid} AND `user_id`={$uid}";
		}
		try {
			$rs = DB::select($sql);
		    $get_Count =count($rs);

			if($get_Count>0) {
				$get_Arr = json_decode(json_encode($rs), true);
			    foreach($get_Arr as $get_Arrs) {
					$folder_rw = array('folder_id'=>$get_Arrs['folder_id'],'user_id'=>$get_Arrs['user_id'],'folder_name'=>$get_Arrs['folder_name'],'timestamp'=>$get_Arrs['timestamp'],'status'=>$get_Arrs['status']);
					$folder_content_arr = json_decode($get_Arrs['folder_contents']);
					$folder_rw['total_charts'] = is_array($folder_content_arr)?count($folder_content_arr):0;
					$result_arr[] = $folder_rw;
				}
			}
			
		} catch (Exception $ex) {
			throw new Exception('Error..! '.$ex->getMessage(), $ex->getCode());
		}
		
		return $result_arr;

	}

	/* public function putFolder( $uid, $fname ) {
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
	} */
	
	public function putFolder( $uid, $fname ) {
		$sql = "";
		$folder_id = 0;
		try{
			$folder_id = DB::table('mychart_user_folders')->insertGetId(
				array('user_id' => $uid, 'folder_name' => $fname)
			);
		   return $folder_id;
		}catch (Exception $ex) {
			throw new Exception($ex->getMessage(), $ex->getCode());
		}
		return $folder_id;
	}

	/* public function updateFolder( $fid, $fname ) {

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

	} */
	
	public function updateFolder( $fid, $fname ) {

		

		$response = false;
		try{
			 $rs=DB::table(TBL_MYCHART_FOLDERS)->where('folder_id',$fid)->update(array('folder_name'=>$fname));

		
			if($rs!=null) {
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
			//$sql = "DELETE FROM `mychart_user_folders` WHERE `mychart_user_folders`.`folder_id`={$fid}";
			$rs = DB::table('mychart_user_folders')->where('folder_id', $fid)->delete();
			if($rs) {
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
	
/* public function updateThisEditedChart($folder_id,$user_id,$chart_data){
		
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
		
	} */
	
	
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
					if(isset($chart_data['color_codes'])){
						
						$folderContent->color_code = $chart_data['color_codes'];
					}
					if(isset($chart_data['color_series']))
					{
						$folderContent->color_series = $chart_data['color_series'];
					}
					if(isset($chart_data['color_status']))
					{
						$folderContent->color_status = $chart_data['color_status'];
					}
					if(isset($chart_data['chart_labels_available']))
					{
						$folderContent->chart_labels_available = $chart_data['chart_labels_available'];
					}
					if(isset($chart_data['charts_fields_available']))
					{
						$folderContent->charts_fields_available = $chart_data['charts_fields_available'];
					}
					if(isset($chart_data['reverseYAxis']))
					{
					$folderContent->reverseYAxis = $chart_data['reverseYAxis'];
					}

					if(isset($chart_data['reversedAxis_']) && $chart_data['reverseYAxis']!=false)
					{
					$folderContent->reversedAxis_ = $chart_data['reversedAxis_'];
					}else{
					$folderContent->reversedAxis_ = [];
					}
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
	
	
	private function getThisFolderContent($folder_id,$user_id){
		try {

			$sql =Userfolders::where('folder_id',$folder_id)->where('user_id',$user_id)->get();
			
			return $sql->toArray();
		}catch (Exception $ex){
			throw new Exception("Error in fetching data",9999);
		}
		
	}

	public function getFolderContent($folder_id,$user_id){
		try {
			$res=Userfolders::where('folder_id',$folder_id)->where('user_id',$user_id)->get()->toArray();
			
			return $res;
		}catch (Exception $ex){
			throw new Exception("Error in fetching data",9999);
		}
		
	}
	
   private function savethisFolderContent($folder_id,$user_id,$chart_data){
		try {
			#$chart_data=DB::connection()->getPdo()->quote($chart_data);
		

			 $rs=DB::table(TBL_MYCHART_FOLDERS)->where('user_id', $user_id)->where('folder_id', $folder_id)->update(array('folder_contents' => $chart_data));
			
			
				return true;
			
			
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
		
	}
	
	public function getThisFolderData($folder_id, $user_id){
		try {
			$folderContent = $this->getThisFolderContent($folder_id,$user_id);
			$folderData = array(
				'id' => isset($folderContent[0]['folder_id'])?$folderContent[0]['folder_id']:'',
				'name' => isset($folderContent[0]['folder_name'])?$folderContent[0]['folder_name']:'',
				'content' => isset($folderContent[0]['status'])?json_decode($folderContent[0]['folder_contents']):'',
				'status' => isset($folderContent[0]['status'])?$folderContent[0]['status']:''
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
	
	
	
	public function getTotalNumberOfFoldersForThisUser($user_id){
		try {

			$rs= DB::table(TBL_MYCHART_FOLDERS)->where('user_id',$user_id)->count();

			return $rs;
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
	}
	
	public function getTotalNumberOfContentsInThisFolder($folder_id,$user_id){
		try {

			$rs= Userfolders::where('user_id',$user_id)->where('folder_id',$folder_id)->whereNotNull('folder_contents')->pluck('folder_contents')->toArray();
			#$rs = $rs ? $rs->toArray() :[];
			#echo "<pre>"; print_r($rs);die;
			$folder_content =  !empty($rs)?json_decode($rs[0]):'';
			return !empty($folder_content)?count($folder_content):0;
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage(),$ex->getCode());
		}
	}

	
}

?>

