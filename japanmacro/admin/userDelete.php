<?php include('controlPanel.php');
$id= $_REQUEST['id'];

$statusChage  = $userObj->userDelete($id);
$return_url = $_SERVER['HTTP_REFERER'];

header("Location:$return_url");exit(0);