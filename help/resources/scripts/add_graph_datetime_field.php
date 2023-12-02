<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);
/** Sql to be executed before running script
 * 
 * ALTER TABLE `graph_values` ADD COLUMN `datetime` DATETIME NULL AFTER `year`; 
 * ALTER TABLE `graph_values` ADD INDEX `idx_datetime` (`datetime`); 
 */ 


require 'script_class.php';
class AddGraphDateTimeField extends Script {
	public function Run() {
		$out = '';
		try {
		echo "***************** AddGraphDateTimeField - START"."<br><br>";
			$sql = "SELECT vid, month, year FROM graph_values WHERE datetime IS NULL LIMIT 20000";
			$rs = $this->executeQuery($sql);
			if($rs->num_rows>0) {
			//$response = $rs->fetch_all(true);
			while ($rw = $rs->fetch_assoc()) {
				$vid = $rw['vid'];
				$month = $rw['month'] == 0 ? '01' : $rw['month'];
				$year = $rw['year'];
				$sq_datetime = $year.'-'.$month.'-01 00:00:00';
				$sql_update = "UPDATE graph_values SET datetime='$sq_datetime' WHERE vid = $vid";
				if($this->executeQuery($sql_update)) {
					echo $sql_update." <font color='#00ff00'>Updated</font> <br><br>";
				}else {
					echo $sql_update." <font color='#ff0000'>Failed</font> <br><br>";
				}
			}
		} 
		
		} catch (Exception $ex){
			
		}
		echo "***************** AddGraphDateTimeField - END"."<br><br>";
	}
	
}

$obj = new AddGraphDateTimeField();
$obj->Run();
?>