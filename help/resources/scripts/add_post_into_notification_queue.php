<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);
/** Sql to be executed before running script
 * 
 * ALTER TABLE `graph_values` ADD COLUMN `datetime` DATETIME NULL AFTER `year`; 
 * ALTER TABLE `graph_values` ADD INDEX `idx_datetime` (`datetime`); 
 */ 


require 'script_class.php';
class AddPostIntoNotificationQueue extends Script {
	public function Run() {
		$out = '';
		try {
		echo "***************** AddPostIntoNotificationQueue - START"."<br><br>";
			$sql_update = '';
			for($i=1;$i<=222; $i++) {
				$sql = "INSERT INTO `post_email_queue`(`post_id`,`user_id`,`post_email_queue_status`) VALUES(182,$i,'Y')";
				if($this->executeQuery($sql)){
					echo $sql_update." <font color='#00ff00'>Inserted</font> <br><br>";
				}
				else {
					echo $sql_update." <font color='#ff0000'>Failed</font> <br><br>";
				}
			}
		
		} catch (Exception $ex){
			echo " <font color='#ff0000'>Exception....! : ".$ex->getMessage()."</font> <br><br>";
		}
		echo "***************** AddPostIntoNotificationQueue - END"."<br><br>";
	}
	
}

$obj = new AddPostIntoNotificationQueue();
$obj->Run();
?>