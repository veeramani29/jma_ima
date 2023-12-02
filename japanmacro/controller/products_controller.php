<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');

//echo "<pre>";print_r($_SESSION);
class productsController extends AlaneeController {
	public $classes = array('alanee_classes/access_management/acl_class.php','alanee_classes/common/alaneecommon_class.php','alanee_classes/common/navigation_class.php');
	public function index() {
		$this->pageTitle = "Welcome to Japan macro advisors - Products";
		$this->renderResultSet['meta']['description']='Japan macro advisors - Products and subscriptions';
		$this->renderResultSet['meta']['keywords']='Products, subscription, payment';
		// get all category items
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
		$user = new User();
		$id =isset($_SESSION['user'])?$_SESSION['user']['id']:0;
		$user_details = $user->getUserDetailsById($id);
		$this->renderResultSet['result']['request']['info'] =$user_details;
		$this->populateLeftMenuLinks();		
		$this->renderView();		
	}

	public function offerings() {
		$user = new User();
		$country = new Country();
		$user_position = $user->getPositionsDatabase();
		$user_industry = $user->getIndustryDatabase();
		$this->renderResultSet['result']['user_position'] = $user_position;
		$this->renderResultSet['result']['user_industry'] = $user_industry;
		$this->renderResultSet['result']['country_list'] = $country->getCountryDatabase();

		$this->renderView();
		
	}
	public function about_premium_user(){
		$this->handleUnpaidUser();
		$this->pageTitle = "Welcome to Japan macro advisors - Products";
		$this->renderResultSet['meta']['description']='Japan macro advisors - Products and subscriptions';
		$this->renderResultSet['meta']['keywords']='Products, subscription, payment';
		$AlaneeCommon = new Alaneecommon();
		$this->populateLeftMenuLinks();
		$this->renderView();
	}

} ?>