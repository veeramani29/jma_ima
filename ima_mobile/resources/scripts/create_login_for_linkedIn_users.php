<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);
/** Sql to be executed before running script
 * 
 * UPDATE user_accounts SET password; 
 */ 


require 'script_class.php';
class UpdatePasswordField extends Script {
	
	public $classes = array('alanee_classes/common/alaneecommon_class.php');
	
	public function Run() {
		$out = '';
		try {
			$user = new User();
		echo "***************** UpdatePasswordField - START"."<br><br>";
			$sql = "SELECT * FROM user_accounts WHERE password = '' AND linkedin_enabled = 'Y' LIMIT 20000";
			$rs = $user->executeQuery($sql);
			if($rs->num_rows>0) {
			//$response = $rs->fetch_all(true);
			while ($rw = $rs->fetch_assoc()) {
				$id = $rw['id'];
				$AlaneeCommon = new Alaneecommon();
				$password = $AlaneeCommon->createPassword(8);
				$sql_update = "UPDATE user_accounts SET password='".$password."' WHERE id = $id";
				if($user->executeQuery($sql_update)) {
					echo $sql_update." <font color='#00ff00'>Updated</font> <br><br>";
				}else {
					echo $sql_update." <font color='#ff0000'>Failed</font> <br><br>";
				}
			}
		} 
		
		} catch (Exception $ex){
			
		}
		echo "***************** UpdatePasswordField - END"."<br><br>";
	}
	
}

$obj = new UpdatePasswordField();
$obj->Run();
?>