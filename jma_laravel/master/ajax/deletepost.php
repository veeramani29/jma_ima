<?php

/**
   * Delete selected User. 
 */

include_once("../../config/config.php");
include_once("../../library/mysql.php");
include_once("../lib/class.post.php");

$postOb = new post();

$postId  = $_POST['postId'];
if(!isset($postId)){
    echo 0;
}
else{
    $result = $postOb->deletePost($postId);   
    echo $result;
}



