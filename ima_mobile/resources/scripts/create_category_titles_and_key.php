<?php
require 'script_class.php';

class MigrateCategory extends Script {
	
	public function run() {
		$query = "SELECT * FROM `post_category`";
		$result = $this->getThisqueryResult($query);
		foreach($result as $rw) {
		 	$id = $rw['post_category_id'];
		 	$get_title = trim($rw['post_category_name']);
			$get_title = str_replace(array(' ',	"'",':','/','\\'), '-', $get_title);
			$get_title = str_replace(array(',','?','(',')',), '', $get_title);
			$get_title = str_replace(array('%',), 'per', $get_title);
			$get_title = trim(strtolower($get_title),'-');
			//echo $get_title;
			//echo '<br><br>';
			$key = md5($get_title);
			
				$sql_update = "UPDATE `post_category` SET `category_url` = '$get_title', `category_url_key` = '$key' WHERE `post_category_id` = $id";
				if($this->executeQuery($sql_update)) {
					echo $id." ***** ".$get_title;
					echo '<br><br>';
				} else {
					echo $id." *****  ERROR!";
					echo '<br><br>';
				}
			
		}
	}
}

$migrate = new MigrateCategory();
$migrate->run();
?>