<?php
namespace App\Http\Controllers;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use App\Model\Post;
use App\Model\Media;
use App\Lib\CommonClass;
use App\Lib\Navigation;
use App\Model\Postcategory;
use App\Model\Seopages;
use App\Http\Controllers\ErrorController;
use Exception;
use Sesssion;
use Config;
use App\Lib\Acl;
class ReportsController extends Controller {
	


	public function __construct ()
	{
		View::share ('menu_items', $this->populateLeftMenuLinks());
	}
	public function index() {
	  new ErrorController(404);
	}
	

	
	public function admin_index() {
		//$this->renderView();
	}

	public function category($params) {
		$this->handleUnpaidUser();
		$AlaneeCommon = new Alaneecommon();
		$this->pageTitle = "India macro advisors - Posts - Indian economy | Macro economy | Economist - GDP, Inflation - Analysis on Indian economy by Mr. Takuji Okubo";
		$this->renderResultSet['meta']['description']='India macro advisors - Posts - Indian economy | Macro economy | Economist - GDP, Inflation - Analysis on Indain economy by Mr. Takuji Okubo';
		$this->renderResultSet['meta']['keywords']='India economy, Macro economy, Economist, GDP, Inflation';
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
	
	public function view(Request $request) {
		
		$params=$request->route()->parameters();
	    $params=array_values($params);

		if(count($params) == 1){ 
			return redirect('news/view/'.$params[0]);	
		}

		$this->handleUnpaidUser();
		$navigation = new Navigation();
		$post_url = array_pop($params);
		$AlaneeCommon = new CommonClass();
		$category_array = $navigation->getCategoryarrayFromUrlArray($params);
		$isContentAllowed = false;
		if($AlaneeCommon->isCategoryArrayPremium($category_array) == true) {
			if($this->isUserLoggedIn()==true){
				$acl = new Acl();
				if($acl->isPermitted('content', 'report', 'premiumaccess')==true){
					$isContentAllowed = true;
				}else{
					new ErrorController(401);
					exit;
				}
			}else{
				//$this->redirect('user/premium_login');
				$isContentAllowed = true;
			}
		}else{
			$isContentAllowed = true;
		}
		
		
		
		if($isContentAllowed == true) {
			$this->renderResultSet['result']['category_array'] = $category_array;
			$renderResultSet['result']['category_array'] = $category_array;
			$category_path = $navigation->getCategotyArrayParsedIntoPath($category_array);
			$this->renderResultSet['result']['category_path'] = $category_path;
			$renderResultSet['result']['category_path'] = $category_path;
			$latest_category_array= end($category_array); 
			$latest_category_id = $latest_category_array['post_category_id'];
			$post = new Post();
			$newsContent = $post->getThisPostItemByKeyAndCategoryId($latest_category_id,md5($post_url));
			if(count($newsContent)>0) {
			/*	if($newsContent[0]['premium_news']=='Y' && $newsContent[0]['post_type']=='N' && (isset($_SESSION['user']) && $_SESSION['user']['user_type_id']==1 || !isset($_SESSION['user']))){

					$_SESSION['fullredirect_redirecturl'] = url('reports/view/'.$category_path.$newsContent[0]['post_url']);
					return redirect('user/premium_login');

				}*/
				$newsContent[0]['post_cms']	= $AlaneeCommon->makeChart($AlaneeCommon->cleanMyCkEditor($newsContent[0]['post_cms']));
			}
			$data['result']['posts'] = $newsContent;
			$renderResultSet['pageTitle'] = isset($newsContent[0]['post_title']) ? $newsContent[0]['post_title']." :: Welcome to India macro advisors" : "Welcome to India macro advisors";
			$renderResultSet['meta']['description']=isset($newsContent[0]['post_meta_description'])?$newsContent[0]['post_meta_description']:'';
			$renderResultSet['meta']['keywords']=isset($newsContent[0]['post_meta_keywords'])?$newsContent[0]['post_meta_keywords']:'';
			
			
			$renderResultSet['meta']['shareTitle']=$newsContent[0]['post_share_title'];
			$renderResultSet['meta']['description']=$newsContent[0]['post_share_description'];
			$renderResultSet['meta']['metaTitle']=$newsContent[0]['post_meta_title'];
			$data['renderResultSet']=$renderResultSet;
			return view('reports.view',$data);
		}
	}	
	public function preview($param) {
		// get all category items
		$this->viewPath = 'reports';
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
				$this->renderResultSet['meta']['shareTitle'] = $newsContent[0]['post_share_title'];
				$this->renderResultSet['meta']['description']=$newsContent[0]['post_meta_description'];
				$this->renderResultSet['meta']['shareImage']=$newsContent[0]['post_image'];
				$this->renderResultSet['meta']['keywords']=$newsContent[0]['post_meta_keywords'];
				$this->pageTitle = isset($this->renderResultSet['result']['posts'][0]['post_title']) ? "Welcome to India macro advisors :: ".$this->renderResultSet['result']['posts'][0]['post_title'] : "Welcome to India macro advisors";
			} else { 
				throw new Exception('Error..! You need admin privileges to view this page', 9999);
			}
		}catch (Exception $ex) {
			$this->renderResultSet['status'] = $ex->getCode();
			$this->renderResultSet['message'] = $ex->getMessage();
		}
		$this->renderView('view');
	}
	
	public function printgraph($dparam, $params) {
		$this->viewPath = 'reports';
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
	
	public function __call($method, $params){
		try {
			$slug = $method;
		//	exit($slug);
			$slug_hash = sha1($slug);
			$seopage = new Seopages();
			//exit($slug_hash);
			$page = $seopage->getThisItemBySlugKey($slug_hash);
			if(count($page)>0) {
				if($page[0]['post_id'] == 0){
					$page[0]['post_title'] = $page[0]['title'];
					$page[0]['post_heading'] = $page[0]['title'];
					$page[0]['post_cms'] = $page[0]['content'];
				}
				$this->populateLeftMenuLinks();
				$AlaneeCommon = new Alaneecommon();
				$page[0]['post_cms'] = $AlaneeCommon->makeChart($page[0]['post_cms']);
				$this->pageTitle = $page[0]['meta_title'];
				$this->renderResultSet['meta']['description']=$page[0]['meta_description'];
				$this->renderResultSet['meta']['keywords']=$page[0]['mata_keywords'];
				$this->renderResultSet['result']['posts'] = $page;
				$this->renderView('view');
			}else{
				throw new Exception("No page exists");
			}
		}catch (Exception $ex){
			exit("page does not exist!");
		}	
	}
	
}

?>