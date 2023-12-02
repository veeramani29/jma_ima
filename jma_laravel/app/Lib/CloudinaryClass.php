<?php
namespace App\Lib;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
/**
 * 
 * Cloudinary class
 * @author Sadia Siddiqa : sadia.siddiqa@japanmacroadvisors.com
 *
 */


require(app_path().'/Libraries/cloudinary/Cloudinary.php');
require(app_path().'/Libraries/cloudinary/Uploader.php');


class CloudinaryClass {

	public function CloudinaryApi() {


		$api_configurations = Config()->get(app()->environment().'.ConfigKeys.cloudinary');
		
		 $this->cloud_name = $api_configurations['cloud_name'];
		$this->api_key = $api_configurations['api_key'];
		$this->cloud_api_secret = $api_configurations['api_secret'];
		
		\Cloudinary::config(array("cloud_name" => $this->cloud_name,"api_key" => $this->api_key,"api_secret" => $this->cloud_api_secret));

	}
	
	/*public function uploadImages($images,$default_upload_options){
		
		if($images){
			foreach($images as $image=>$name){
				$default_upload_options = array("tags" => "slider_images","public_id" => $image);
				# public_id will be generated on Cloudinary's backend.
				$files["unnamed_local"] = \Cloudinary\Uploader::upload($images[$image], $default_upload_options);
			}
		}
	}
	
	public function fetchImages(){
		
	}*/
}

?>