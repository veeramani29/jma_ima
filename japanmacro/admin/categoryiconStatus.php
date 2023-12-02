<?php include('controlPanel.php');
$id= $_REQUEST['Id'];
$status= $_REQUEST['status'];
$statusChage  = $catObj->updateNewIcon($id,$status);
$return_url = $_SERVER['HTTP_REFERER'];
echo $return_url;
header("Location:$return_url");
exit(0);
