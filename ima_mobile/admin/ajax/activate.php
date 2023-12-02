
<?php

/**
   * Activate or deactivate the post. 
  */


include_once("../../config/config.php");
include_once("../../library/mysql.php");
include_once("../lib/class.post.php");

$postOb	        = new post();
$postId = $_POST['id'];
if(!isset($postId)){
    echo 0;
}else{

$status = $_POST['status'];
if($status == 'N'){
    $status = 'Y';
}  else {
    $status = 'N';
}
$result = $postOb->updatePostStatus($postId,$status);
echo $result;

}
?>
