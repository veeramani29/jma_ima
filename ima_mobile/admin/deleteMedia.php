<?php include('controlPanel.php');

$id= $_REQUEST['id'];

$getMedia = $mediaObj->getMediaDetails($id);

$image  = $getMedia[0]['media_value_img'];

if($image !=''){
    $filePath = '../public/uploads/media/'.$image;
    unlink($filePath);
       
}
$mediaObj->deleteMedia($id);
$return_url = $_SERVER['HTTP_REFERER'];

header("Location:$return_url");

exit(0);