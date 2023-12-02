<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class BriefseriesController extends AlaneeController {
	public $classes = array('alanee_classes/access_management/acl_class.php','alanee_classes/common/alaneecommon_class.php','alanee_classes/common/navigation_class.php');
	public function index() {
		$this->handleUnpaidUser();
		$this->pageTitle = "Welcome to Japan macro advisors - JMA- Brief series";
		$this->renderResultSet['meta']['description']='Japan macro advisors - JMA- Brief series';
		$this->renderResultSet['meta']['keywords']='japan macroadvisors, japan, brief series';
		// get all category items
		$postCategory = new postCategory();
		$media = new Media();
		$this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
		$this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
		$AlaneeCommon = new Alaneecommon();
		$acl = new Acl();
		$briefSeriesObj = new Briefseries();
		$briefSeriesPost = $briefSeriesObj->getAllBriefseries();
		$this->renderResultSet['result']['briefseries'] = $briefSeriesPost;
		$this->renderResultSet['result']['isUserLoggedIn'] = $this->isUserLoggedIn();
		$this->renderResultSet['result']['isPermitted'] = $acl->isPermitted('content', 'report', 'premiumaccess');
		/*if($this->isUserLoggedIn()==true){
			if($acl->isPermitted('content', 'report', 'premiumaccess')!=true){
				$this->error(401);
				exit;
			//	exit("Error..! Permission denied.");
			}*/
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
		/*}else{
			$this->redirect('user/login');
		}*/	
	}

}


?>