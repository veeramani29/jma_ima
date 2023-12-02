<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);
/** Sql to be executed before running script
 * 
 * UPDATE user_accounts SET password; 
 */ 


require 'script_class.php';
class UpdateFolderContent extends Script {
	
	public $classes = array('alanee_classes/common/alaneecommon_class.php');
	
	public function Run() {
		$out = '';
		try {
			$user = new User();
		echo "***************** UpdateFolderContent - START"."<br><br>";

			 $user = new User();

     $response = $user->find_folder_content();

if(is_array($response)){
     foreach ($response as $keys => $values) {
      $get_object=json_decode($values['folder_contents']);
      
      if(is_array($get_object)){
     $new_object= array();
     foreach ($get_object as $key => $value) {
	$value->chart_view_type = "chart";
	$new_object[$key]=$value;
		}

		#echo "<pre>";print_r($new_object);

      $user->update_folder_content(addslashes(json_encode($new_object)),$values['folder_id']);
}
   #echo "======================".json_encode($new_object);
   #echo "<pre>";print_r($response);
     }

}
			
		
		} catch (Exception $ex){
			
		}
		echo "***************** UpdateFolderContent - END"."<br><br>";
	}
	
}

$obj = new UpdateFolderContent();
$obj->Run();
?>