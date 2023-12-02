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
use App\Lib\Acl;
use Session;
class PageController extends Controller {
	
	public function __construct ()
        {

        		 parent::__construct();
            View::share ( 'menu_items', $this->populateLeftMenuLinks());
   


        }

         public function index()
    {
    	 new ErrorController(404);
    }

	public function category(Request $request) {

		$params=$request->route()->parameters();
			
		#$this->handleUnpaidUser();
		#$this->viewPath = 'reports';
		$CommonClass = new CommonClass();

		$this->renderResultSet['pageTitle']= "Japan macro advisors - Posts - Japan economy | Macro economy | Economist - GDP, Inflation - Analysis on Japanese economy by Mr. Takuji Okubo";
  
        $this->renderResultSet['meta']['description']="Japan macro advisors - Posts - Japan economy | Macro economy | Economist - GDP, Inflation - Analysis on Japanese economy by Mr. Takuji Okubo";
        $this->renderResultSet['meta']['keywords']='Japan economy, Macro economy, Economist, GDP, Inflation';
        $data['renderResultSet']=$this->renderResultSet;

		
		// get all category items
		$media = new Media();
		$data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
		$data['result']['rightside']['media'] = $media->getLatestMedia(5);
		if(count($data['result']['rightside']['notice'])>0) {
			foreach ($data['result']['rightside']['notice'] as &$rwn) {
				$rwn['media_value_text'] = $CommonClass->editorfix($rwn['media_value_text']);
			}
		}
		if(count($data['result']['rightside']['media'])>0) {
			foreach ($data['result']['rightside']['media'] as &$rwm) {
				$rwm['media_value_text'] = $CommonClass->editorfix($rwm['media_value_text']);
			}
		}
		$navigation = new Navigation();
	$params=array_unique(array_values($params));
		$category_array = $navigation->getCategoryarrayFromUrlArray($params);

		$isContentAllowed = false;
		if($CommonClass->isCategoryArrayPremium($category_array) == true) {
			if($this->isUserLoggedIn()==true){
				$acl = new Acl();
				if($acl->isPermitted('content', 'report', 'premiumaccess')==true){
					$isContentAllowed = true;					
				}else{
					new ErrorController(401);
					exit;
				}
			}else{
				return  redirect('user/premium_login');
			}
		}else{
			$isContentAllowed = true;			
		}

		if($isContentAllowed == true) {

			$data['result']['category_array'] = $category_array;
			$category_path = $navigation->getCategotyArrayParsedIntoPath($category_array);
			$data['result']['category_path'] = $category_path;
			$latest_category_array= end($category_array);
			 $latest_category_id = $latest_category_array['post_category_id'];
			$post = new Post();
			$reports = $post->getPublishedPostsByCategoryId($latest_category_id);

			if(count($reports) == 0) {

				new ErrorController(404);
			} else if(count($reports) == 1) {

				if($reports[0]['post_type']=='N'){
				return redirect(url('reports/view/'.$category_path));
				}

				$this->renderResultSet['pageTitle'] = $reports[0]['post_meta_title'];
				$this->renderResultSet['meta']['shareTitle'] = $reports[0]['post_share_title'];
				$this->renderResultSet['meta']['description']=$reports[0]['post_meta_description'];
				/* srinivasan 20/09/16 change share title and description dynamic changes issue id : jma 7; */
				$this->renderResultSet['share']['shareTitle'] = $reports[0]['post_share_title'];
				$this->renderResultSet['share']['description']=$reports[0]['post_share_description'];
				$this->renderResultSet['meta']['keywords']=$reports[0]['post_meta_keywords'];
				$this->renderResultSet['meta']['shareImage']=$reports[0]['post_image'];
       			 $data['renderResultSet']=$this->renderResultSet;
				$reports_recent_data=($reports[0]['recent_data']=='Y')?true:false;
				$reports[0]['post_cms'] = $CommonClass->makeChart($reports[0]['post_cms'],true,$reports_recent_data);
				$data['result']['posts'] = $reports;

				 return view('page.view',$data);	
		
			} else {
				$data['result']['posts'] = $reports;
				return view('page.category',$data);	
			}			
		}
		
	}
	
	public function view(Request $request) {

		$params=$request->route()->parameters();

		$this->handleUnpaidUser();
			// get all category items
		$navigation = new Navigation();
		$allparams = ($params);
		$params=array_unique(array_values($params));
		$category_array = $navigation->getCategoryarrayFromUrlArray($params);
		$data['result']['category_array'] = $category_array;
		$category_path = $navigation->getCategotyArrayParsedIntoPath($category_array);
		$data['result']['category_path'] = $category_path;
		$latest_category_array= end($category_array); 
		$latest_category_id = $latest_category_array['post_category_id'];
		$post = new Post();
		$CommonClass = new CommonClass();
		$allparams=$params;
$post_url = array_pop($allparams);
		$newsContent = $post->getThisPostItemByKeyAndCategoryId($latest_category_id,md5($post_url));
		if(count($newsContent)>0) {

			if($newsContent[0]['premium_news']=='Y' && $newsContent[0]['post_type']=='N' && ((Session::has('user') && Session::get('user.user_type_id')==1 ) || !Session::has('user'))){

Session::put('fullredirect_redirecturl',url('reports/view/'.$category_path.$newsContent[0]['post_url']));
return redirect('user/premium_login');

}
				$reports_recent_data=($newsContent[0]['recent_data']=='Y')?true:false;
				$newsContent[0]['post_cms']	= $CommonClass->makeChart($CommonClass->cleanMyCkEditor($newsContent[0]['post_cms']),true,$reports_recent_data);
		}
		$data['result']['posts'] = $newsContent;

		$this->renderResultSet['pageTitle']=  isset($data['result']['posts'][0]['post_title']) ? "Welcome to Japan macro advisors :: ".$data['result']['posts'][0]['post_title'] : "Welcome to Japan macro advisors";
  
        $this->renderResultSet['meta']['description']=$newsContent[0]['post_meta_description'];
        $this->renderResultSet['meta']['keywords']=$newsContent[0]['post_meta_keywords'];
		
        $data['renderResultSet']=$this->renderResultSet;

		return view('page.view',$data);	
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
				$CommonClass = new CommonClass();
				$newsContent = $post->getThisPostItemByKey($post_key,true);
				if(count($newsContent)>0) {
					$reports_recent_data=($newsContent[0]['recent_data']=='Y')?true:false;
					$newsContent[0]['post_cms']	= $CommonClass->makeChart($CommonClass->cleanMyCkEditor($newsContent[0]['post_cms']),true,$reports_recent_data);
				}
				$data['result']['posts'] = $newsContent;
				

			$this->renderResultSet['pageTitle']=isset($data['result']['posts'][0]['post_title']) ? "Welcome to Japan macro advisors :: ".$data['result']['posts'][0]['post_title'] : "Welcome to Japan macro advisors";
			  $data['renderResultSet']=$this->renderResultSet;
			} else { 
				throw new Exception('Error..! You need admin previledges to view this page', 9999);
			}
		}catch (Exception $ex) {
			$data['result']['status'] = $ex->getCode();
			$data['result']['message'] = $ex->getMessage();
		}
		
		return view('page.view',$data);	
	}
	
	public function printgraph($dparam, $params) {
		$categoryurl_main = isset($dparam[0]) ? $dparam[0] : null;
		$categoryurl_sub = isset($dparam[1]) ? $dparam[1] : null;
		$this->setTemplate('printgraph');
		$graphCode = "{graph ".str_replace('|',',',$params['gid'])."||".str_replace('|',',',$params['date'])."}";
		$CommonClass = new CommonClass();
		$post = new Post();
		$mCategoryKey = md5($categoryurl_main);
		$sCategoryKey = md5($categoryurl_sub);
		$reports = $categoryurl_sub == null ? $post->getThisMainCategoryItems($mCategoryKey) : $post->getThisSubCategoryItems($mCategoryKey, $sCategoryKey);
		$data['result']['graph'] = $CommonClass->makeChart($graphCode);
		$data['result']['post_title'] = $reports[0]['post_title'];
		return view('page.printgraph',$data);		
	}
	
}

?>