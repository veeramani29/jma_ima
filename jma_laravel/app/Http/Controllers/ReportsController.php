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
use Session;
use App\Lib\Acl;
class ReportsController extends Controller {
	


public function __construct ()
        {
        		 parent::__construct();

            View::share ( 'menu_items', $this->populateLeftMenuLinks());
   


        }
	public function index() {
	  new ErrorController(404);
	}
	


	public function category($params) {
		$this->handleUnpaidUser();
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
			$params=array_unique(array_values($params));
		$category_array = $navigation->getCategoryarrayFromUrlArray($params);
		$category_path = $navigation->getCategotyArrayParsedIntoPath($category_array);
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
			//	exit($this->url('reports/view/'.$category_path));
				Session::put('fullredirect_redirecturl',url('reports/view/'.$category_path));
				
				return redirect('user/premium_login');
			}
		}else{
			$isContentAllowed = true;			
		}
		if($isContentAllowed == true) {
			$this->renderResultSet['result']['category_array'] = $category_array;
			$this->renderResultSet['result']['category_path'] = $category_path;
			$latest_category_array= end($category_array);
			$latest_category_id = $latest_category_array['post_category_id'];
			$post = new Post();
			$reports = $post->getPublishedPostsByCategoryId($latest_category_id);
			if(count($reports) == 0) {
			new ErrorController(401);exit;
			} else if(count($reports) == 1) {
				$this->pageTitle = $reports[0]['post_meta_title'];
				$this->renderResultSet['meta']['shareTitle'] = $reports[0]['post_share_title'];
				$this->renderResultSet['meta']['description']=$reports[0]['post_meta_description'];
				$this->renderResultSet['meta']['keywords']=$reports[0]['post_meta_keywords'];
				 $data['renderResultSet']=$this->renderResultSet;
				$reports_recent_data=($reports[0]['recent_data']=='Y')?true:false;
				$reports[0]['post_cms'] = $AlaneeCommon->makeChart($reports[0]['post_cms'],true,$reports_recent_data);
				$data['result']['posts'] = $reports;
				$this->renderResultSet['result']['posts'] = $reports;
				 return view('page.view',$data);
			} else {
				$data['result']['posts'] = $reports;
				return view('page.category',$data);	
			}			
		}
	}
	
	public function view(Request $request) {

	$params=$request->route()->parameters();
	$params=array_unique(array_values($params));
	
		if(count($params) == 1){ 
			return redirect('news/view/'.$params[0]);	
		}



		$this->handleUnpaidUser();
		$navigation = new Navigation();
		$allparams = ($params);
		$post_url = array_pop($allparams);

		$AlaneeCommon = new CommonClass();


		$category_array = $navigation->getCategoryarrayFromUrlArray($params);
		$category_path = $navigation->getCategotyArrayParsedIntoPath($category_array);
		
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
				$a='';
if($category_path=='special-reports/kuroda-tried-to-end-the-speculation-that-10yr-rate-may-rise-soon/'){
$a=$params[1];
}
				Session::put('fullredirect_redirecturl',url('reports/view/'.$category_path.$a));
				return redirect('user/premium_login');
			}
		}else{
			$isContentAllowed = true;
		}

		
		
		if($isContentAllowed == true) {
			$renderResultSet['result']['category_array'] = $category_array;
			$renderResultSet['result']['category_path'] = $category_path;
			$latest_category_array= end($category_array); 
			$latest_category_id = $latest_category_array['post_category_id'];
			$post = new Post();
			$newsContent = $post->getThisPostItemByKeyAndCategoryId($latest_category_id,md5($post_url));

			/* echo "<pre>";
			print_r($newsContent); */

			if(count($newsContent)>0) {
			
/*if($newsContent[0]['premium_news']=='Y' && $newsContent[0]['post_type']=='N' && ((Session::has('user') && (Session::get('user.user_type_id')==1 )) || !Session::has('user'))){

Session::put('fullredirect_redirecturl',url('reports/view/'.$category_path.$newsContent[0]['post_url']));
return redirect('user/premium_login');

}*/
				if($newsContent[0]['post_type']=='P'){
				return redirect(url('page/category/'.$category_path));
				}
				$reports_recent_data=($newsContent[0]['recent_data']=='Y')?true:false;
				if($newsContent[0]['premium_news']=='Y' && $newsContent[0]['post_type']=='N' && ((Session::has('user') && (Session::get('user.user_type_id')==1 )) || !Session::has('user'))){
				$newsContent[0]['post_cms']	= $newsContent[0]['post_cms'];
				}else{
				$newsContent[0]['post_cms']	= $AlaneeCommon->makeChart($AlaneeCommon->cleanMyCkEditor($newsContent[0]['post_cms']),true,$reports_recent_data);
				}
			}
			$data['result']['posts'] = $newsContent;
			$renderResultSet['pageTitle'] = isset($newsContent[0]['post_title']) ? "Welcome to Japan macro advisors :: ".$newsContent[0]['post_title'] : "Welcome to Japan macro advisors";

			$renderResultSet['meta']['description']=isset($newsContent[0]['post_meta_description'])?$newsContent[0]['post_meta_description']:'';
			$renderResultSet['meta']['keywords']=isset($newsContent[0]['post_meta_keywords'])?$newsContent[0]['post_meta_keywords']:'';



				/* srinivasan 07/09/16 change meta title and description dynamic changes issue id : jma 7; */
			$renderResultSet['share']['shareTitle']=$newsContent[0]['post_share_title'];
			$renderResultSet['share']['description']=$newsContent[0]['post_share_description'];
			$renderResultSet['meta']['metaTitle']=$newsContent[0]['post_meta_title'];
			$data['renderResultSet']=$renderResultSet;
            $data['renderResultSet']=$renderResultSet;
			if($newsContent[0]['premium_news']=='Y' && $newsContent[0]['post_type']=='N'){
				$data['result']['getLatestNewsItems']=$post->getLatestNewsItems(4);

				// echo "<pre>";print_r($data);die;
				
			return view('reports.premium_news_view',$data);
		    }else{
		    	
		    	return view('reports.view',$data);
		    }
		}
	}	
	public function preview(Request $request) {

	$params=$request->route()->parameters();
	$param=array_values($params);
		// get all category items
		
		try {
			if(isset($_SESSION['jma_admin_id']) && isset($_SESSION['jma_admin_name']) && $_SESSION['jma_admin_id'] > 0) {
				 $posturl = $param[0];
				$post_key = md5($posturl);
				$post = new Post();
				$AlaneeCommon = new CommonClass();
				$newsContent = $post->getThisPostItemByKey($post_key,true);
				if(count($newsContent)>0) {
					$reports_recent_data=($newsContent[0]['recent_data']=='Y')?true:false;
					$newsContent[0]['post_cms']	= $AlaneeCommon->makeChart($AlaneeCommon->cleanMyCkEditor($newsContent[0]['post_cms']),true,$reports_recent_data);
				}
				$data['result']['posts'] = $newsContent;
				$renderResultSet['meta']['shareTitle'] = $newsContent[0]['post_share_title'];
				$renderResultSet['meta']['description']=$newsContent[0]['post_meta_description'];
				$renderResultSet['meta']['shareImage']=$newsContent[0]['post_image'];
				$renderResultSet['meta']['keywords']=$newsContent[0]['post_meta_keywords'];
				$renderResultSet['pageTitle']  = isset($this->renderResultSet['result']['posts'][0]['post_title']) ? "Welcome to Japan macro advisors :: ".$this->renderResultSet['result']['posts'][0]['post_title'] : "Welcome to Japan macro advisors";
				$data['renderResultSet']= $renderResultSet;

			} else { 
				throw new Exception('Error..! You need admin previledges to view this page', 9999);
			}
		}catch (Exception $ex) {
			$data['result']['status'] = $ex->getCode();
			$data['result']['message'] = $ex->getMessage();
		}
		
		return view('reports.view',$data);
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
				$reports_recent_data=($page[0]['recent_data']=='Y')?true:false;
				$page[0]['post_cms'] = $AlaneeCommon->makeChart($page[0]['post_cms'],true,$reports_recent_data);
				$this->pageTitle = $page[0]['meta_title'];
				$this->renderResultSet['meta']['description']=$page[0]['meta_description'];
				$this->renderResultSet['meta']['keywords']=$page[0]['mata_keywords'];
				$this->renderResultSet['result']['posts'] = $page;
				$this->renderView('view');
			}else{
				 new ErrorController(404);
			}
		}catch (Exception $ex){
			 new ErrorController(404);
		}	
	}
	
}

?>