<?php include('controlPanel.php');

$id= $_REQUEST['id'];

$getEvent = $mediaObj->getEventDetails($id);

$image  = $getEvent[0]['event_value_img'];

if($image !=''){
    $filePath = '../public/uploads/media/'.$image;
    unlink($filePath);
       
}
$mediaObj->deleteEvent($id);
$return_url = $_SERVER['HTTP_REFERER'];

header("Location:$return_url");

exit(0);