<?php
namespace App\Http\Controllers;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 use View;
 use App\Model\User;
use App\Http\Controllers\ErrorController;
class SocialMediaController extends Controller {
	public $Export_url;
	    public function __construct ()
        {
        	$this->Export_url=(env('APP_ENV')=='production')?'https://export.japanmacroadvisors.com/':'http://export.japanmacroadvisors.com/';	
         
        }

     
		
		public function shareSocialmedia($param='')
		{
			if($param!=null){
			$data=array();
			$addsocialmedia = new User;
			$data['result']['getsharedetails'] = $addsocialmedia->getSocialMedia($param);
		if(!empty($data['result']['getsharedetails'])){
			return view('socialMedia.index',$data);
		}else{
			 new ErrorController(404);
		}
		}else{
			 new ErrorController(404);
		}
				
		}
		
		
		
		public function saveimage()
		{ 

			
		   		if(!empty($_REQUEST)){
			$get_img_str=explode("/", $_REQUEST['imageUrl']);
            $img_name= end($get_img_str);
			$imageCode = explode(".",$img_name);
			$unicCode = $imageCode[1]; 
			$url = $this->Export_url.$_REQUEST['imageUrl'];
			$path = './public/socialmedia/_'.$unicCode.'.png';

			copy($url,$path);
			
			
			$this->resizeImage('./public/socialmedia/_'.$unicCode.'.png', './public/socialmedia/'.$unicCode.'.png', 506, 274);
			$shareImagePath = env('APP_URL').'/public/socialmedia/'.$unicCode.'.png';
            unlink ('./public/socialmedia/_'.$unicCode.'.png');
			
			$addsocialmedia = new User;
			$addsocialmedia->addSocialMedia($unicCode,addslashes($_REQUEST['title']),addslashes($_REQUEST['description']),$_REQUEST['loc'],$shareImagePath);
			
			echo $unicCode; exit;
			}else{
			 new ErrorController(404);
		}
		}
		
		
		public function resizeImage($sourceImage, $targetImage, $maxWidth, $maxHeight, $quality = 80)
		{
			// Obtain image from given source file.
			if (!$image = @imagecreatefrompng($sourceImage))
			{
				return false;
			}

			// Get dimensions of source image.
			list($origWidth, $origHeight) = getimagesize($sourceImage);

			if ($maxWidth == 0)
			{
				$maxWidth  = $origWidth;
			}

			if ($maxHeight == 0)
			{
				$maxHeight = $origHeight;
			}

			// Calculate ratio of desired maximum sizes and original sizes.
			$widthRatio = $maxWidth / $origWidth;
			$heightRatio = $maxHeight / $origHeight;

			// Ratio used for calculating new image dimensions.
			$ratio = min($widthRatio, $heightRatio);

			// Calculate new image dimensions.
			$newWidth  = (int)$origWidth  * $ratio;
			$newHeight = (int)$origHeight * $ratio;
			
			$newWidth  = $maxWidth;
			$newHeight = $maxHeight;

			// Create final image with new dimensions.
			$newImage = imagecreatetruecolor($newWidth, $newHeight);
			imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
			imagejpeg($newImage, $targetImage, $quality);

			// Free up the memory.
			imagedestroy($image);
			imagedestroy($newImage);

			return true;
		}

		
		

	
}

?>