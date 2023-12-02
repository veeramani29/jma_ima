<?php
namespace App\Http\Controllers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Postcategory;
use App\Model\Userfolders;
use App\Lib\Navigation;
use App\Lib\Mobile_Detect;
use Session;
use App\Model\User;
use Cookie;
use DB;

class Controller extends BaseController
{

	     public function __construct ()
        {
        	

        	
		$this->dbConnection();
if(Cookie::hasQueued('jmacrm'))
		{
			$rm = base64_decode(Cookie::get('jmacrm'));
			$rmb = base64_decode($rm);
			$remember = explode("_",$rmb);
			$name = $remember[1];
			$pass = $remember[2];
			$user = new User();
			$userDetails = $user->getUserDetailsByUserNameAndPassword($name,$pass);
			$userDetails['password'] = '********';
			if(count($userDetails)>0 && $userDetails['id'] >0) {
				  Session::put('user', $userDetails);
				
			}	
		}
}

	
		protected $renderResultSet = array('pagetitle'=>'',
									   'meta' => array('description'=>'','keywords'=>''),
									   'status'=>1,
									   'message'=>'OK',
									   'result'=>'');

 

  use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;


protected function populateLeftMenuLinks() {



		$postCategory = new Postcategory();
		$folder = new Userfolders();
		$navigation = new Navigation();
		$categories = $postCategory->getAllCategory();
		if( $this->isUserLoggedIn() ) {

			$folderList = $folder->getFolder(Session::get('user.id'));

		if(Session::get('user.user_type_id') == 2 || Session::get('user.user_type_id') == 3)
			{
				if(Session::get('user.isAuthor') == "Y")
				{ 
					$chartBookList = $folder->getChartBookList(Session::get('user.id'));
					$chartBookListInactive = $folder->getChartBookInactiveList(Session::get('user.id'));
					$showtBookList = $folder->getActiveChartBookList(Session::get('user.id'));
				}
				else
				{ 
					$chartBookList = array();
					$showtBookList = $folder->getActiveChartBookList(Session::get('user.id'));
					$chartBookListInactive = array();
				}
			}
			else
			{
					
				$showtBookList = $folder->getActiveChartBookList(Session::get('user.id'));
			    $chartBookList = array();
				$chartBookListInactive = array();
			}
			$folders =  $navigation->createFolderNav($folderList,thisController(),thisMethod());
		}else{
			$folderList = array();
				$chartBookList = array();
				$showtBookList = array();
				$folders = '';
				$chartBookListInactive = array();
		}

			$detect = new Mobile_Detect();
			if($detect->isMobile() || $detect->isTablet()){
			$Responsive_left_menu = $navigation->createResponsiveNavigation($categories);
		$data['Responsive_left_menu'] = $Responsive_left_menu;
			}

			if(($detect->isMobile() && $detect->isTablet() && thisController()!='mycharts') || (!$detect->isTablet() && thisController()!='mycharts')){
			$left_menu = $navigation->createLeftNavigation($categories);

		$addmore_series_src=array('page','news','reports');
        if(in_array(thisController(), $addmore_series_src)){
        /*	if(env('APP_ENV')=='development'){
         $reorder=array(155,168,187);
		$categories__=array_slice($categories, 0,2,true);
		$categories___=array_slice($categories, 2,1,true);
		$First_ElAr=reset($categories__);
		$temp_Arr=$First_ElAr['subcategories'][$reorder[2]];
		$categories__[$reorder[2]]=$temp_Arr;
		$rand_num_gen=rand(1000,2000);
		$temp_OthrAr=array(
		'details'=>array(
		"post_category_id" => $rand_num_gen,
		"post_category_name" => "Others",
		"post_category_parent_id" => 0,
		"post_category_parent_id1" => 0,
		"category_url" => '',
		"premium_category" => 'N',
	   "category_order" => 4),
		'subcategories'=>array(
		$reorder[0]=>$First_ElAr['subcategories'][$reorder[0]],
		$reorder[1]=>$First_ElAr['subcategories'][$reorder[1]])
		);
		
		unset($First_ElAr['subcategories'][$reorder[0]],$First_ElAr['subcategories'][$reorder[1]],$First_ElAr['subcategories'][$reorder[2]]);
		$First_ElAr['subcategories'][$rand_num_gen]=$temp_OthrAr;
		$categories__[2]=$First_ElAr;unset($First_ElAr);
	   }else{*/
	   	$categories__=array_slice($categories, 0,4,true);
		$categories___=array();
	   
		$categories_=array_merge($categories__, $categories___);
		#dd(($categories_));
		$data['Add_More_Section'] = $navigation->add_more_series($categories_);
		}

			
		$data['Normal_left_menu'] = $left_menu;
			}

		
		$data['folders'] = $folders;
		$data['folderList'] = $folderList;

		$data['chartBookList'] = $chartBookList;
		$data['showtBookList'] = $showtBookList;
		$data['chartBookListInactive'] = $chartBookListInactive;

		return $data;
		//echo "<pre>";print_r($data);die;
		
	}
	
	public function isUserLoggedIn() {

		if(Session::has('user') && Session::get('user.id') > 0) {
			return true;
		}else{
			return false;
		}



	}
protected function getAllMyChartFolders() {
		$navigation = new Navigation();
		$folder = new Userfolders();
		if( $this->isUserLoggedIn() ) {
			return $navigation->createFolderNav($folder->getFolder(Session::get('user.id')));

		}
		
	}



protected function handleUnpaidUser(){
		if(Session::has('user') && Session::get('user.id') > 0) {
			if(Session::get('user.user_status') == 'unpaid' && Session::get('user.user_type') == 'individual'){
				return redirect('user/user_pay_downgrade');
			}
		}
	}

public function redirect($page,$considerPrefix = false){
		$prefix = $considerPrefix == true ? Router::$prefix.'/' : '';
		$appPath = app()->environment();
		$appPath = $appPath == '' ? '' : $appPath.'/';
		if (is_array($page)) {
			$prefix = array_key_exists('prefix', $page) ? $page['prefix'].'/' : '';
			$controller = array_key_exists('controller', $page) ? $page['controller'].'/' : 'home/';
			$action = array_key_exists('action', $page) ? $page['action'].'/' : 'index/';
			if(array_key_exists('params', $page)) {
				$params = is_array($page['params']) ? implode('/', $page['params']) : $page['params'];
			}else {
				$params = '';
			}
			header("location: /".$appPath.$prefix.$controller.$action.$params);
		} else{
			header("location: /".$appPath.$prefix.ltrim($page,'/'));
		}
	}


	public function setFlashMessage($message=null) {

		if($message != null) {
			Session::put('alanee_flashmessage',$message);
			Session::flash('message', Session::get('alanee_flashmessage')); 
		}else{
			Session::forget('alanee_flashmessage');
		}
	}
	
	/**
	 * Get flash message value
	 * @return message
	 */
	public function getFlashMessage(){

	 	 $message = (Session::has('alanee_flashmessage')) ? Session::get('alanee_flashmessage') : null;
		Session::forget('alanee_flashmessage');
		Session::flash('message', ''); 
		return $message;
	}


	

	private function dbConnection(){

		header('Access-Control-Allow-Origin: https://www.japanmacroadvisors.com/');  
        	 header('Access-Control-Allow-Methods: POST, GET, OPTIONS, HEAD');
        	 if($_SERVER['REQUEST_METHOD']=='POST' || $_SERVER['REQUEST_METHOD']=='GET' || $_SERVER['REQUEST_METHOD']=='OPTIONS' || $_SERVER['REQUEST_METHOD']=='HEAD'){
        	 		$method='Success';
        	 	
        	 }else{
        	 	 header("HTTP/1.1 401 Unauthorized");
        	 	die('Unauthorized');
        	 }

			

			try {
			DB::connection()->getPdo();
			} catch (\Exception $e) {
			
			die(include('under_maintenance.php'));
			}
	}





		public function Track_Download($type,$chart_codes=null){
		

$Usertype=(Session::has('user.user_type'))?Session::get('user.user_type'):'Non-Logged';
$Username=(Session::has('user.email'))?Session::get('user.email'):'Non-Logged';
		$input=array('Type'=>$type,'Usertype'=>$Usertype,'Username'=>$Username,'when'=>date('d-m-Y'),'IP'=>$this->get_client_ip(),'REFERER'=>$_SERVER['HTTP_REFERER'],$chart_codes);
		
		$no_of_lines = count(file(storage_path('logs/data_download_track.txt'))); 
		$event_json = ($no_of_lines/2).json_encode($input).PHP_EOL."\r\n";;
		$handler = fopen(storage_path('logs/data_download_track.txt'),'a');
		fwrite($handler,$event_json);
		return true;
		}


	private function get_client_ip() {

	// Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
              $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
              $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }

     $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress =$_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		if(strpos($_SERVER['HTTP_X_FORWARDED_FOR'],',') !== false ) {
		$ipaddress = reset(explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']));
		}else{
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
       $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}


				



			

			


  

}
