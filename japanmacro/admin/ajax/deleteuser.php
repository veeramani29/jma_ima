<?php

/**
   * Delete selected post. 
 */

include_once("../../config/config.php");
include_once("../../library/mysql.php");
include_once("../lib/class.user.php");
include_once("../../library/function.php");

$userOb = new user();

$userId  = $_POST['userId'];
$userImg = $_POST['usrImg'];

if(!isset($userId)){
    echo 0;
}
else{
    $result = $userOb->deleteUser($userId);
    if($result == 1){
        if($userImg !=''){
       deleteImage('../../public/uploads/users/original/','../../public/uploads/users/thumb/',$userImg);
        }
    }
    echo $result;
}
