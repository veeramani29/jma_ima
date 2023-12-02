<?php include('header.php');

$allUsers = $userObj->getUserList();
//$userObj ->addCronQueue($insertArrayQue);
$insertArrayQue = array();
foreach ($allUsers as $user) {
	$insertArrayQue['post_id'] = 148;
    $insertArrayQue['user_id'] = $user['user_id'];
  //  $userObj ->addCronQueue($insertArrayQue);
}
?>
