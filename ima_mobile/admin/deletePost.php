<?php include('controlPanel.php');

$id= $_REQUEST['id'];

$delete  = $postObj->deleteJmaPost($id);

$post_QueDele  = $postObj->deleteJmaPostQue($id);

$return_url = $_SERVER['HTTP_REFERER'];
header("Location:$return_url");
exit(0);

