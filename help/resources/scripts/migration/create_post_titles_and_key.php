<?php 
//include('F:\WORKIN\HTTPWORKIN\htdocs\japanmacroadvisors.com\include\include.php');
include('F:\WORKIN\HTTPWORKIN\htdocs\japanmacroadvisors.com\include\mysql.php');
include('F:\WORKIN\HTTPWORKIN\htdocs\japanmacroadvisors.com\include\common.php');
include('F:\WORKIN\HTTPWORKIN\htdocs\japanmacroadvisors.com\library\function.php');

$query = "SELECT * FROM `post`";
$result = $db->selectQuery($query);
foreach($result as $rw) {
 $id = $rw['post_id'];
 $get_title = trim($rw['post_title']);
$get_title = str_replace(array(' ',	"'",':'), '-', $get_title);
$get_title = str_replace(array(',','?','(',')',), '', $get_title);
$get_title = trim(strtolower($get_title),'-');
$key = md5($get_title);
	//$sql_update = "UPDATE `post` SET `post_url` = '$get_title', `post_url_key` = '$key' WHERE `post_id` = $id";
	//if($db->executeQuery($sql_update)) {
		echo $id." ***** ".$get_title;
		echo '<br><br>';
	} else {
		echo $id." *****  ERROR!";
		echo '<br><br>';
	}

}

?>  