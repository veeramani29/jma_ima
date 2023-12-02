<?php
  /*******************************************************
   * Only these origins will be allowed to upload images *
   ******************************************************/
  $accepted_origins = array("http://localhost", "http://laravel.indiamacroadvisors.com", "https://www.indiamacroadvisors.com","http://testing.indiamacroadvisors.com");

  /*********************************************
   * Change this line to set the upload folder *
   *********************************************/
  $imageFolder = "../public/uploads/ckImages/";

  reset ($_FILES);
  $temp = current($_FILES);
  if (is_uploaded_file($temp['tmp_name'])){
    if (isset($_SERVER['HTTP_ORIGIN'])) {
      // same-origin requests won't set an origin. If the origin is set, it must be valid.
      if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
        header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
      } else {
        header("HTTP/1.0 403 Origin Denied");
        return;
      }
    }

    /*
      If your script needs to receive cookies, set images_upload_credentials : true in
      the configuration and enable the following two headers.
    */
    // header('Access-Control-Allow-Credentials: true');
    // header('P3P: CP="There is no P3P policy."');

    // Sanitize input
    if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
        header("HTTP/1.0 500 Invalid file name.");
        return;
    }
  
    // Verify extension
    if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png","jpeg","pdf","dat"))) {
        header("HTTP/1.0 500 Invalid extension.");
        return;
    }
	
	
	$fileType = explode(".",$temp['name']);
	
	$fileOriginalType = explode("/",$temp['type']);
	
	if($fileType[1]=="dat")
	{
		$temp['name'] = str_replace("dat",$fileOriginalType[1],$temp['name']);
	}
  
    // Accept upload if there was no origin, or if it is an accepted origin
    $filetowrite = $imageFolder . $temp['name'];
    move_uploaded_file($temp['tmp_name'], $filetowrite);
	
	
	

    // Respond to the successful upload with JSON.
    // Use a location key to specify the path to the saved image resource.
    // { location : '/your/uploaded/image/file'}
    echo json_encode(array('location' => $filetowrite));
  } else {
    // Notify editor that the upload failed
    header("HTTP/1.0 500 Server Error");
  }
?>
