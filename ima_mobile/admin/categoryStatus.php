<?php include('controlPanel.php');
$id= $_REQUEST['id'];
$status= $_REQUEST['status'];

$statusChage  = $catObj->changeStatus($id,$status);$catObj->updateNewIcon($id, 'N') ;
$return_url = $_SERVER['HTTP_REFERER'];
echo $return_url;
header("Location:$return_url");
exit(0);
