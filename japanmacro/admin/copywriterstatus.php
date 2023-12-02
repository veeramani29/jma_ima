<?php include('controlPanel.php');
$id= $_REQUEST['id'];
$status= $_REQUEST['status'];

$statusChage  = $copywriterObj->changeStatus($id,$status);
$return_url = $_SERVER['HTTP_REFERER'];
echo $return_url;
header("Location:$return_url");
exit(0);
