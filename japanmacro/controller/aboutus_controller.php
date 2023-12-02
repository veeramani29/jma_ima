<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class AboutusController extends AlaneeController {
	public $classes = array('alanee_classes/access_management/acl_class.php','alanee_classes/common/alaneecommon_class.php','alanee_classes/common/navigation_class.php');
	public function index() {
		$this->handleUnpaidUser();
		$this->pageTitle = "Welcome to Japan macro advisors - About us";
		$this->renderResultSet['meta']['description']='Japan macro advisors - About us';
		$this->renderResultSet['meta']['keywords']='japan macroadvisors, japan';
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
		$this->renderView();		
	}
	
	public function privacypolicy() {
		$this->handleUnpaidUser();
		$this->pageTitle = "Privacy policy";
		$this->renderResultSet['meta']['description']='Japan macro advisors - Privacy policy';
		$this->renderResultSet['meta']['keywords']='japan macroadvisors, japan';
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
		$this->renderView();		
	}
	
	public function termsofuse() {
		$this->handleUnpaidUser();
		$this->pageTitle = "Terms of Use";
		$this->renderResultSet['meta']['description']='Japan macro advisors - Terms of Use';
		$this->renderResultSet['meta']['keywords']='japan macroadvisors, japan';
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
		$this->renderView();	
	}


	

public function commercial_policy(){

	$this->handleUnpaidUser();
		$this->pageTitle = "Commercial policy";
		$this->renderResultSet['meta']['description']='Japan macro advisors - Commercial policy';
		$this->renderResultSet['meta']['keywords']='japan macroadvisors, japan';
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
		$this->renderView();
}
	
	public function test(){
		$this->pageTitle = "Welcome to Japan macro advisors - Terms of Use";
		$this->renderResultSet['meta']['description']='Japan macro advisors - Terms of Use';
		$this->renderResultSet['meta']['keywords']='japan macroadvisors, japan';
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
		$this->renderView();
	}

}


?>