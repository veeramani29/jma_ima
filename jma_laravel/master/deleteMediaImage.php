<?php include('controlPanel.php');

$id= $_REQUEST['id'];

$getMedia = $mediaObj->getMediaDetails($id);

$image  = $getMedia[0]['media_value_img'];

if($image !=''){
    $filePath = './public/uploads/media/'.$image;
    unlink($filePath);
    $doc_path = '';
    $mediaObj->updateMediaImg($id,$doc_path);
}

$return_url = $_SERVER['HTTP_REFERER'];

header("Location:$return_url");

exit(0);