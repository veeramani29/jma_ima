<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);
/** Sql to be executed before running script
 * 
 * ALTER TABLE `graph_values` ADD COLUMN `datetime` DATETIME NULL AFTER `year`; 
 * ALTER TABLE `graph_values` ADD INDEX `idx_datetime` (`datetime`); 
 */ 


require 'script_class.php';
class AddAccessRules extends Script {
	
	public function Run() {
		$accessRules = array(
			'graph' => array(
					'datadownload'=> array(
						'allowdatadownload' => 'Y',
						'sharegraph' => 'Y'
					)
				)
		);
		
		$json_access_rules = json_encode($accessRules);
		exit($json_access_rules);
	
	}
	
}


$obj = new AddAccessRules();
$obj->Run();

?>