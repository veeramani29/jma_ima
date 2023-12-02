<?php include('controlPanel.php');

$id= $_REQUEST['id'];
$catObj->deleteCategory($id);
$return_url = $_SERVER['HTTP_REFERER'];

header("Location:$return_url");

exit(0);