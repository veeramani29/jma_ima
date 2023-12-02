<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class ErrorController extends AlaneeController{
	public $classes = array('alanee_classes/access_management/acl_class.php','alanee_classes/common/alaneecommon_class.php','alanee_classes/common/navigation_class.php');
	public function index($error_code){
		switch ($error_code){
			case 404 :
				$this->error_404();
				break;
				case 401 :
					$this->error_401();
					break;				
			default:
				$this->error_404();
				break;
		}
		
	}
	
	public function error_404(){
		//http_response_code(404);
		header('X-PHP-Response-Code: 404', true, 404);
		$this->pageTitle = "404 - Sorry..! page not found";
		$this->renderResultSet['meta']['description']='';
		$this->renderResultSet['meta']['keywords']='';
		// get all category items
		$postCategory = new postCategory();
		$media = new Media();
		$this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
		$this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
		$AlaneeCommon = new Alaneecommon();
		if(count($this->renderResultSet['result']['rightside']['notice'])>0) {
			foreach ($this->renderResultSet['result']['rightside']['notice'] as &$rwn) {
				$rwn['media_value_text'] = $AlaneeCommon->editorfix($rwn['media_value_text']);
			}
		}
		if(count($this->renderResultSet['result']['rightside']['media'])>0) {
			foreach ($this->renderResultSet['result']['rightside']['media'] as &$rwm) {
				$rwm['media_value_text'] = $AlaneeCommon->editorfix($rwm['media_value_text']);
			}
		}
		$this->populateLeftMenuLinks();	
		$this->setViewPath('error');
		$this->renderView('error_404');
		
	}
	
	public function error_401(){
		//http_response_code(404);
		header('X-PHP-Response-Code: 401', true, 401);
		$this->pageTitle = "401 - Access denied!";
		$this->renderResultSet['meta']['description']='';
		$this->renderResultSet['meta']['keywords']='';
		// get all category items
		$postCategory = new postCategory();
		$media = new Media();
		$this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
		$this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
		$AlaneeCommon = new Alaneecommon();
		if(count($this->renderResultSet['result']['rightside']['notice'])>0) {
			foreach ($this->renderResultSet['result']['rightside']['notice'] as &$rwn) {
				$rwn['media_value_text'] = $AlaneeCommon->editorfix($rwn['media_value_text']);
			}
		}
		if(count($this->renderResultSet['result']['rightside']['media'])>0) {
			foreach ($this->renderResultSet['result']['rightside']['media'] as &$rwm) {
				$rwm['media_value_text'] = $AlaneeCommon->editorfix($rwm['media_value_text']);
			}
		}
		$this->populateLeftMenuLinks();
		$this->setViewPath('error');
		$this->renderView('error_401');
	
	}
	
	
}

?>
