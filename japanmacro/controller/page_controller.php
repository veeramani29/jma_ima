<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class PageController extends AlaneeController {
	public $classes = array('alanee_classes/access_management/acl_class.php','alanee_classes/common/alaneecommon_class.php','alanee_classes/common/navigation_class.php');
	public function index() {
		$this->handleUnpaidUser();
		$this->pageTitle = "Welcome to Japan macro advisors - Posts";
		// get all category items
		$this->populateLeftMenuLinks();
		
		//$this->renderView();
	}
	
	public function admin_index() {
		$this->renderView();
	}

	public function category($params) {
		
		$this->handleUnpaidUser();
		$this->viewPath = 'reports';
		$AlaneeCommon = new Alaneecommon();
		$this->pageTitle = "Japan macro advisors - Posts - Japan economy | Macro economy | Economist - GDP, Inflation - Analysis on Japanese economy by Mr. Takuji Okubo";
		$this->renderResultSet['meta']['description']='Japan macro advisors - Posts - Japan economy | Macro economy | Economist - GDP, Inflation - Analysis on Japanese economy by Mr. Takuji Okubo';
		$this->renderResultSet['meta']['keywords']='Japan economy, Macro economy, Economist, GDP, Inflation';
		// get all category items
		$media = new Media();
		$this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
		$this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
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
		$navigation = new Navigation();
		$this->populateLeftMenuLinks();
		$category_array = $navigation->getCategoryarrayFromUrlArray($params);
		$isContentAllowed = false;
		if($AlaneeCommon->isCategoryArrayPremium($category_array) == true) {
			if($this->isUserLoggedIn()==true){
				$acl = new Acl();
				if($acl->isPermitted('content', 'report', 'premiumaccess')==true){
					$isContentAllowed = true;					
				}else{
					$this->error(401);
					exit;
				}
			}else{
				$this->redirect('user/premium_login');
			}
		}else{
			$isContentAllowed = true;			
		}
		if($isContentAllowed == true) {
			$this->renderResultSet['result']['category_array'] = $category_array;
			$category_path = $navigation->getCategotyArrayParsedIntoPath($category_array);
			$this->renderResultSet['result']['category_path'] = $category_path;
			$latest_category_array= end($category_array);
			$latest_category_id = $latest_category_array['post_category_id'];
			$post = new Post();
			$reports = $post->getPublishedPostsByCategoryId($latest_category_id);
			
			if(count($reports) == 0) {
				$this->error(404);
			} else if(count($reports) == 1) {
				$this->pageTitle = $reports[0]['post_meta_title'];
				$this->renderResultSet['meta']['shareTitle'] = $reports[0]['post_share_title'];
				$this->renderResultSet['meta']['description']=$reports[0]['post_meta_description'];
				/* srinivasan 20/09/16 change share title and description dynamic changes issue id : jma 7; */
				$this->renderResultSet['share']['shareTitle'] = $reports[0]['post_share_title'];
				$this->renderResultSet['share']['description']=$reports[0]['post_share_description'];
				$this->renderResultSet['meta']['keywords']=$reports[0]['post_meta_keywords'];
				$reports[0]['post_cms'] = $AlaneeCommon->makeChart($reports[0]['post_cms']);
				$this->renderResultSet['result']['posts'] = $reports;
				
				$this->renderView('view');
			} else {
				$this->renderResultSet['result']['posts'] = $reports;
				$this->renderView();
			}			
		}
	}
	
	public function view($params) {
		$this->handleUnpaidUser();
			// get all category items
		$navigation = new Navigation();
		$this->populateLeftMenuLinks();
		$post_url = array_pop($params);
		$category_array = $navigation->getCategoryarrayFromUrlArray($params);
		$this->renderResultSet['result']['category_array'] = $category_array;
		$category_path = $navigation->getCategotyArrayParsedIntoPath($category_array);
		$this->renderResultSet['result']['category_path'] = $category_path;
		$latest_category_array= end($category_array); 
		$latest_category_id = $latest_category_array['post_category_id'];
		$post = new Post();
		$AlaneeCommon = new Alaneecommon();
		$newsContent = $post->getThisPostItemByKeyAndCategoryId($latest_category_id,md5($post_url));
		if(count($newsContent)>0) {
			$newsContent[0]['post_cms']	= $AlaneeCommon->makeChart($AlaneeCommon->cleanMyCkEditor($newsContent[0]['post_cms']));
		}
		$this->renderResultSet['result']['posts'] = $newsContent;
		$this->pageTitle = isset($this->renderResultSet['result']['posts'][0]['post_title']) ? "Welcome to Japan macro advisors :: ".$this->renderResultSet['result']['posts'][0]['post_title'] : "Welcome to Japan macro advisors";
		$this->renderResultSet['meta']['description']=$newsContent[0]['post_meta_description'];
		$this->renderResultSet['meta']['keywords']=$newsContent[0]['post_meta_keywords'];
		$this->renderView();
	}	
	public function preview($param) {
			// get all category items
		$this->populateLeftMenuLinks();
		try {
			if(isset($_SESSION['jma_admin_id']) && isset($_SESSION['jma_admin_name']) && $_SESSION['jma_admin_id'] > 0) {
				$posturl = $param[0];
				$post_key = md5($posturl);
				$post = new Post();
				$AlaneeCommon = new Alaneecommon();
				$newsContent = $post->getThisPostItemByKey($post_key,true);
				if(count($newsContent)>0) {
					$newsContent[0]['post_cms']	= $AlaneeCommon->makeChart($AlaneeCommon->cleanMyCkEditor($newsContent[0]['post_cms']));
				}
				$this->renderResultSet['result']['posts'] = $newsContent;
				$this->pageTitle = isset($this->renderResultSet['result']['posts'][0]['post_title']) ? "Welcome to Japan macro advisors :: ".$this->renderResultSet['result']['posts'][0]['post_title'] : "Welcome to Japan macro advisors";
			} else { 
				throw new Exception('Error..! You need admin previledges to view this page', 9999);
			}
		}catch (Exception $ex) {
			$this->renderResultSet['status'] = $ex->getCode();
			$this->renderResultSet['message'] = $ex->getMessage();
		}
		$this->renderView('view');
	}
	
	public function printgraph($dparam, $params) {
		$categoryurl_main = isset($dparam[0]) ? $dparam[0] : null;
		$categoryurl_sub = isset($dparam[1]) ? $dparam[1] : null;
		$this->setTemplate('printgraph');
		$graphCode = "{graph ".str_replace('|',',',$params['gid'])."||".str_replace('|',',',$params['date'])."}";
		$AlaneeCommon = new Alaneecommon();
		$post = new Post();
		$mCategoryKey = md5($categoryurl_main);
		$sCategoryKey = md5($categoryurl_sub);
		$reports = $categoryurl_sub == null ? $post->getThisMainCategoryItems($mCategoryKey) : $post->getThisSubCategoryItems($mCategoryKey, $sCategoryKey);
		$this->renderResultSet['result']['graph'] = $AlaneeCommon->makeChart($graphCode);
		$this->renderResultSet['result']['post_title'] = $reports[0]['post_title'];
		$this->renderView();		
	}
	
}

?>