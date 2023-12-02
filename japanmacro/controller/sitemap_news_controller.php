<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');

class sitemap_newsController extends AlaneeController {
	
	public $classes = array('alanee_classes/access_management/acl_class.php','alanee_classes/common/alaneecommon_class.php','alanee_classes/common/navigation_class.php');
	
	public function index() {

		$this->setTemplate('xml');
		$post = new Post();
		$newsContent = $post->getLatestTwoDaysNewsItems(5);
		$this->renderResultSet['result']['news'] = $newsContent;
		//if(count($newsContent > 0))
		$this->renderView();
	}
}
?>