<?php include('controlPanel.php');

$catId = $_REQUEST['catId'];

$order = $_REQUEST['order'];

$orderChage  = $catObj->updateOrder($catId,$order);

$return_url = $_SERVER['HTTP_REFERER'];

echo $return_url;

header("Location:$return_url");

exit(0);


?>
