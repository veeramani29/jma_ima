<?php
namespace App\Http\Controllers;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use View;
use App\Model\Postcategory;
use App\Model\User;
use App\Model\Post;
use App\Model\Media;
use App\Lib\CommonClass;
use App\Lib\Navigation;
use App\Lib\Acl;
use Config;
use Session;
use App\Lib\MailGunAPI;
use \Mailgun\Mailgun;
class PageController extends Controller {
	
	public function __construct ()
	{
		View::share ( 'menu_items', $this->populateLeftMenuLinks());
		View::share ( 'search_keywords', $this->searchBoxKeyWords());
	}

		public function index()
		{
		   new ErrorController(404);
		}
	public function admin_index() {

        /**/
	
		#print_r($veera);die;
		#$Postcategory->gettestt(1);
		//$this->renderView();
	}


	public function seo_category($title,$titles=null) {
	
		
		$this->renderResultSet['pageTitle']= "India macro advisors - Posts - India economy | Macro economy | Economist - GDP, Inflation - Analysis on Indian economy by Mr. Takuji Okubo";
		$this->renderResultSet['meta']['description']='India macro advisors - Posts - Indian economy | Macro economy | Economist - GDP, Inflation - Analysis on Indian economy by Mr. Takuji Okubo';
		$this->renderResultSet['meta']['keywords']='Indian economy, Macro economy, Economist, GDP, Inflation';
		$data['renderResultSet']=$this->renderResultSet;
		$navigation = new Navigation();
		
		$segment1 = \Request::segment(3);
	    $segment2 = \Request::segment(4);
	
		 $params=array_filter(array($segment1, $segment2));
		$category_array = $navigation->getCategoryarrayFromUrlArray($params);
		$category_path = $navigation->getCategotyArrayParsedIntoPath($category_array);
		$data['result']['category_path'] = $category_path;
		$latest_category_array= end($category_array);
		$latest_category_id = $latest_category_array['post_category_id'];
		$post = new Post();
		
		if($titles!=null){
		$reports = $post->getcategoryItems($latest_category_id);
		$data['result']['posts'] = $reports;
		return view('page.category_',$data);
		}else{
		$reports=$post->getallSubcatByParent($latest_category_id);
		$data['result']['posts'] = $reports;#dd($reports);
		return view('page.category_list',$data);
		
		}
		
		

	}

	public function category(Request $request) {
		
		$params=$request->route()->parameters();
		$pageUrl = implode("/",$params);
		
		// Temporary code for SEO
		$CommonClass = new CommonClass();
		
		$this->renderResultSet['pageTitle']= "India macro advisors - Posts - India economy | Macro economy | Economist - GDP, Inflation - Analysis on Indian economy by Mr. Takuji Okubo";
		$this->renderResultSet['meta']['description']='India macro advisors - Posts - Indian economy | Macro economy | Economist - GDP, Inflation - Analysis on Indian economy by Mr. Takuji Okubo';
		$this->renderResultSet['meta']['keywords']='Indian economy, Macro economy, Economist, GDP, Inflation';
		$this->renderResultSet['pageUrl'] = $pageUrl;
		$data['renderResultSet']=$this->renderResultSet;
		
		// get all category items
		
		$navigation = new Navigation();
		
		$category_array = $navigation->getCategoryarrayFromUrlArray($params);
		$isContentAllowed = false;
		if($CommonClass->isCategoryArrayPremium($category_array) == true) {
			if($this->isUserLoggedIn()==true){
				$acl = new Acl();
				if($acl->isPermitted('content', 'report', 'premiumaccess')==true){
					$isContentAllowed = true;					
				}else{
					//$this->error(401);
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
		   $data['result']['postsHigh'] = isset($reports[0]['post_cms'])?$reports[0]['post_cms']:'';
			if(count($reports) == 0) {
				new ErrorController(404);
			} else if(count($reports) == 1) {
                $this->renderResultSet['pageTitle'] =  $reports[0]['post_meta_title'];
				$this->renderResultSet['meta']['shareTitle'] = $reports[0]['post_share_title'];
				$this->renderResultSet['meta']['description']=$reports[0]['post_meta_description'];
				$this->renderResultSet['meta']['keywords']=$reports[0]['post_meta_keywords'];
				$this->renderResultSet['meta']['shareImage']=$reports[0]['post_image'];
				$tempCoverage = preg_match_all("/{(graph[_a-z]*) ((\d|,|\||-)+)({([a-zA-Z:,\"\'&quot;]*)})*}/", $reports[0]['post_cms'], $matches);
				$main = explode('|', $matches[2][0]);
				$this->renderResultSet['temporalCoverage'] = str_replace(",","/",$main[2]);
				$data['renderResultSet']=$this->renderResultSet;
				$reports[0]['post_cms'] = $CommonClass->makeChart($reports[0]['post_cms']);
				$data['result']['posts'] = $reports;
				return view('page.view',$data);	
			} else {
				$data['result']['posts'] = $reports;
				 return view('page.category',$data);
			}			
		}
	}
	
	public function view(Request $request) {
		/* if(count($params) == 1){
			$this->redirect('news/view/'.$params[0]);
		}
		$this->viewPath = 'reports'; */
		
		$params=$request->route()->parameters();
		$this->handleUnpaidUser();
		
		$navigation = new Navigation();
		 $params=array_unique(array_values($params));
		
		$CommonClass = new CommonClass();	
		$category_array = $navigation->getCategoryarrayFromUrlArray($params);
		
			$data['result']['category_array'] = $category_array;
			$category_path = $navigation->getCategotyArrayParsedIntoPath($category_array);
			$data['result']['category_path'] = $category_path;
			$latest_category_array= end($category_array); 
			$latest_category_id = $latest_category_array['post_category_id'];
			$post = new Post();
			$allparams=$params;
			$post_url = array_pop($allparams);
			$newsContent = $post->getThisPostItemByKeyAndCategoryId($latest_category_id,md5($post_url));
			if(count($newsContent)>0) {
				if($newsContent[0]['premium_news']=='Y' && $newsContent[0]['post_type']=='N' && (isset($_SESSION['user']) && $_SESSION['user']['user_type_id']==1 || !isset($_SESSION['user']))){

					$_SESSION['fullredirect_redirecturl'] = url('reports/view/'.$category_path.$newsContent[0]['post_url']);
					return redirect('user/premium_login');

				}
				$newsContent[0]['post_cms']	= $CommonClass->makeChart($CommonClass->cleanMyCkEditor($newsContent[0]['post_cms']));
			}
			$data['result']['posts'] = $newsContent;
			$this->renderResultSet['pageTitle']=  isset($data['result']['posts'][0]['post_title']) ? "Welcome to India macro advisors :: ".$data['result']['posts'][0]['post_title'] : "Welcome to India macro advisors";
			
			
			$this->renderResultSet['meta']['description']=$newsContent[0]['post_meta_description'];
			$this->renderResultSet['meta']['keywords']=$newsContent[0]['post_meta_keywords'];
			$data['renderResultSet']=$this->renderResultSet;

		    return view('page.view',$data);	
		
	}	
	public function preview($param) {
			/**
			 * @todo : Authenticate Admin User to use this URL
			 */
			// get all category items
		$params=$request->route()->parameters();
	    $param=array_values($params);
		try {
			if(isset($_SESSION['jma_admin_id']) && isset($_SESSION['jma_admin_name']) && $_SESSION['jma_admin_id'] > 0) {
				$posturl = $param[0];
				$post_key = md5($posturl);
				$post = new Post();
				$CommonClass = new CommonClass();
				$newsContent = $post->getThisPostItemByKey($post_key,true);
				if(count($newsContent)>0) {
					$newsContent[0]['post_cms']	= $CommonClass->makeChart($CommonClass->cleanMyCkEditor($newsContent[0]['post_cms']));
				}
				$data['result']['posts'] = $newsContent;
				$this->renderResultSet['pageTitle']=isset($data['result']['posts'][0]['post_title']) ? "Welcome to India macro advisors :: ".$data['result']['posts'][0]['post_title'] : "Welcome to India macro advisors";
				
			} else { 
				throw new Exception('Error..! You need admin privileges to view this page', 9999);
			}
		}catch (Exception $ex) {
			$data['status'] = $ex->getCode();
			$data['message'] = $ex->getMessage();
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

	public function ideapitchcompetition(){

		new ErrorController(404);die;
		/* commenetd 04/04/2018 $this->renderResultSet['pageTitle']= "India macro advisors - Posts - India economy | Macro economy | Economist - GDP, Inflation - Analysis on Indian economy by Mr. Takuji Okubo";
		$this->renderResultSet['meta']['description']='India macro advisors - Posts - Indian economy | Macro economy | Economist - GDP, Inflation - Analysis on Indian economy by Mr. Takuji Okubo';
		$this->renderResultSet['meta']['keywords']='Indian economy, Macro economy, Economist, GDP, Inflation';
		$data['renderResultSet']=$this->renderResultSet;
		$user = new User();
		if(isset($_SESSION['user']) && $_SESSION['user']['id'] >0)
		{
			$data['result']['check_register_status'] = $user->getCompetitionUserById($_SESSION['user']['id']);
		}
		else
		{
			$data['result']['check_register_status'] = false;
		}
		
		return view('page.ideapitchcompetition',$data);	*/
}


    public function upload_document($params=null){
	new ErrorController(404);die;
    	/* /* commenetd 04/04/2018  $user = new User();
		if(isset($_SESSION['user']) && $_SESSION['user']['id'] >0)
		{
			$data['result']['check_register_status'] = $user->getCompetitionUserById($_SESSION['user']['id']);
		}
		else
		{
			$data['result']['check_register_status'] = false;
		}
		
		if($this->isUserLoggedIn()==true){
		
		
							if(!empty($_FILES['careers_resume']))
							{
								
										$file_name = $_FILES['careers_resume']['name'];
										$file_size = $_FILES['careers_resume']['size'];
										$file_tmp = $_FILES['careers_resume']['tmp_name'];
										$file_type = $_FILES['careers_resume']['type'];
										$extension = explode('.',$_FILES['careers_resume']['name']);
										$file_ext = $extension[1];

										$extensions = array("pptx","PPTX");

										if(in_array($file_ext,$extensions)=== false){
											$errors[]="extension not allowed, please choose a pptx or PPTX file.";
										}
										
										
										$target_dir = "assets/competiotion_ima_idea_pitch/";
										$target_file = $target_dir . basename($_FILES["careers_resume"]["name"]);

										if (move_uploaded_file($_FILES["careers_resume"]["tmp_name"], $target_file)) {
											
										} else {
											$errors[]="Sorry, there was an error uploading your file.";
											print_r($errors);
											exit();
										}
										
										
										$mgObject = new MailGun(env('MailGunAPI'));


										## $mgClient = $mgObject->Mailgun;

										##$domain = $mgObject->domain;
										
										$domain = 'mg.indiamacroadvisors.net';
										
										
										$uniquetime=time();
										
										$mailSubject = 'IMA';

										$mailBody = '<html>'.'Dear IMA Team,<br/>
										you have received the following competition user ppt document.<br/>
										</html>';
										
										$result = $mgObject->sendMessage($domain, array(
												'from'    => 'info@mg.indiamacroadvisors.net',
												'to'      => 'erteam@indiamacroadvisors.com',
												'subject' => $mailSubject,
												'html'    => $mailBody,
												'o:tag'   => array($uniquetime)
										), array(
											'attachment' => array('./assets/competiotion_ima_idea_pitch/'.$file_name)
										));
										
										//unlink('./assets/competiotion_ima_idea_pitch/'.$file_name); 
										$userDetails['account_user_id'] =  $_SESSION['user']['id'];
										$userDetails['ppt_document'] = $file_name;
										$user = new User();
										$updatePPTDetails = $user->updateCompetitionPPTX($userDetails);
										return redirect ('page/upload_document/success');
										
										
							}
							
							
							
							
							$firstParam = isset($params) ? $params : ''; 
							$this->pageTitle = "Welcome to India macro advisors - Competition Page";
							$this->renderResultSet['meta']['description']='If you are an aspiring young economist looking to combine analytical skills and entrepreneurial spirit, then join us';
							$this->renderResultSet['meta']['keywords']='India macroadvisors, India';
							$this->renderResultSet['meta']['shareTitle'] = 'Competition|User Opportunities|India Macro Advisors|Economic Research';
							$data['renderResultSet']=$this->renderResultSet;
							// get all category items
							$postCategory = new postCategory();
							$media = new Media();
							$data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
							$data['result']['rightside']['media'] = $media->getLatestMedia(5);
							$data['result']['rightside']['param'] = $firstParam;
							$CommonClass = new CommonClass();
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
							$user = new User();
							if(isset($_SESSION['user']) && $_SESSION['user']['id'] >0)
							{
								$data['result']['check_register_status'] = $user->getCompetitionUserById($_SESSION['user']['id']);
							}
							else
							{
								$data['result']['check_register_status'] = false;
							}
							
						return view('page.uploaddocument',$data);		
		}
        else
        {
			                $firstParam = isset($params) ? $params : ''; 
							$this->pageTitle = "Welcome to India macro advisors - Competition Page";
							$this->renderResultSet['meta']['description']='If you are an aspiring young economist looking to combine analytical skills and entrepreneurial spirit, then join us';
							$this->renderResultSet['meta']['keywords']='India macroadvisors, India';
							$this->renderResultSet['meta']['shareTitle'] = 'Competition|User Opportunities|India Macro Advisors|Economic Research';
							$data['renderResultSet']=$this->renderResultSet;
							// get all category items
							$postCategory = new postCategory();
							$media = new Media();
							$data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
							$data['result']['rightside']['media'] = $media->getLatestMedia(5);
							$data['result']['rightside']['param'] = $firstParam;
							$CommonClass = new CommonClass();
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
			return view('page.uploaddocument',$data);	
		}    		*/
							
							
							
							
							
	}
	
}


?>