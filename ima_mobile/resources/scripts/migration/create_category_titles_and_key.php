<?php 
//include('F:\WORKIN\HTTPWORKIN\htdocs\indiamacroadvisors.com\include\include.php');
include('F:\WORKIN\HTTPWORKIN\htdocs\indiamacroadvisors.com\include\mysql.php');
include('F:\WORKIN\HTTPWORKIN\htdocs\indiamacroadvisors.com\include\common.php');
include('F:\WORKIN\HTTPWORKIN\htdocs\indiamacroadvisors.com\library\function.php');

$query = "SELECT * FROM `post_category`";
$result = $db->selectQuery($query);
foreach($result as $rw) {
 $id = $rw['post_category_id'];
 $get_title = trim($rw['post_category_name']);
$get_title = str_replace(array(' ',	"'",':'), '-', $get_title);
$get_title = str_replace(array(',','?','(',')',), '', $get_title);
$get_title = trim(strtolower($get_title),'-');
//echo $get_title;
//echo '<br><br>';
$key = md5($get_title);
/*
	$sql_update = "UPDATE `post_category` SET `category_url` = '$get_title', `category_url_key` = '$key' WHERE `post_category_id` = $id";
	if($db->executeQuery($sql_update)) {
		echo $id." ***** ".$get_title;
		echo '<br><br>';
	} else {
		echo $id." *****  ERROR!";
		echo '<br><br>';
	}
*/	
}

?>  