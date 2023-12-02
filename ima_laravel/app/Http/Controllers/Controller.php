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
use App\Model\Post;
use App\Model\Userfolders;
use App\Lib\Navigation;
use App\Lib\Mobile_Detect;
use Session;
use App\Model\User;
use Cookie;

class Controller extends BaseController
{
	
	public function __construct ()
	{
				//Cookie::queue(Cookie::forever('name', 'veeramani', 235));
				// dd(Session::get('user.user_permissions'));
				/* $fkgfdg = $_COOKIE['jmacrm'];
		print_r(base64_decode(base64_decode($fkgfdg))); */
		if(Cookie::hasQueued('jmacrm'))
		{
			
			$rm = base64_decode(Cookie::get('jmacrm'));
			$rmb = base64_decode($rm);
			$remember = explode("_",$rmb);
			$name = $remember[1];
			$pass = $remember[2];
			$user = new User();
			$userDetails = $user->getUserDetailsByUserNameAndPassword($name,$pass);
			print_r($userDetails);
			$userDetails['password'] = '********';
			if(count($userDetails)>0 && $userDetails['id'] >0) {
				$_SESSION['user'] = $userDetails;
			}	
		}
		
	}
	
	protected $renderResultSet = array('pagetitle'=>'',
									   'meta' => array('description'=>'','keywords'=>''),
									   'status'=>1,
									   'message'=>'OK',
									   'result'=>'');
	
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	protected function populateLeftMenuLinks() {
		$postCategory = new postCategory();
		$folder = new Userfolders();
		$navigation = new Navigation();
		$categories = $postCategory->getAllCategory();
		if( $this->isUserLoggedIn() ) {
			if($_SESSION['user']['user_type']=="free")
			{
				$folderList = $folder->getFolderForFree($_SESSION['user']['id']);
			}
			else
			{
				$folderList = $folder->getFolder($_SESSION['user']['id']);
			}
			
		////	echo '<pre>';
		//	print_r($folderList);
		//	exit;
			$folders =  $navigation->createFolderNav($folderList,thisController(),thisMethod());
		}else{
			$folderList = array();
			$folders = '';
		}
		$left_menu = $navigation->createLeftNavigation($categories);
		$Responsive_left_menu = $navigation->createResponsiveNavigation($categories);
		$data['Responsive_left_menu'] = $Responsive_left_menu;
		 $addmore_series_src=array('page','news','reports','mycharts');
        if(in_array(thisController(), $addmore_series_src)){
		#$categories_=reset($categories);
		ksort($categories);
		#dd(array_slice($nValues, 0,3,true));
		$filtered_categories=array_slice($categories, 0,2,true);
		// $data['Add_More_Section'] = '';
		$detect = new Mobile_Detect();
		if($detect->isMobile() || $detect->isTablet()){
			$data['Add_More_Section_Mobile'] = $navigation->add_more_series_mobile($filtered_categories);
		} else {
			$data['Add_More_Section'] = $navigation->add_more_series($filtered_categories);
		}
		}
		$data['Normal_left_menu'] = $left_menu;
		$data['folders'] = $folders;
		$data['folderList'] = $folderList;
		#echo "<pre>";print_r($data['veera']);
		return $data;
	}
	
	protected function searchBoxKeyWords(){
		$post = new Post();
		$data['result']['category'] = '';
		$val2 = '';
		$categor = $post->getIndicatorKeyWords(); 
		foreach($categor as $val){
			$val2 .= $val.',';
			//$val2 .= $val1.',';
			//$cat[] = explode(',',htmlentities($val1));
		}	
		$string = str_replace(', ',',',$val2); 
		$string1 = str_replace(',,',',',$string); 
		$string2 = str_replace(' ,',',',$string);
		$fin = explode(',',$string2);
		$unique_array = array_unique($fin);
		$data['result']['category'] = $unique_array;
		return $data;
	}
	
	public function isUserLoggedIn() {
		if(isset($_SESSION['user']) && $_SESSION['user']['id'] > 0) {
			return true;
		}else{
			return false;
		}
	}

	protected function getAllMyChartFolders() {
		$navigation = new Navigation();
		$folder = new Userfolders();
		if( $this->isUserLoggedIn() ) {
			return $navigation->createFolderNav($folder->getFolder($_SESSION['user']['id']));

		}
		
	}
	
	protected function handleUnpaidUser(){
		if(isset($_SESSION['user']) && $_SESSION['user']['id'] > 0) {
			if($_SESSION['user']['user_status'] == 'unpaid' && $_SESSION['user']['user_type'] == 'individual'){
				$this->redirect('user/user_pay_downgrade');
			}
		}
	}
	/* public function setFlashMessage($message=null) {
		if($message != null) {
			Session::put('alanee_flashmessage',$message);
			Session::flash('message', Session::get('alanee_flashmessage')); 
		}
	}
	
	public function getFlashMessage(){

	 	 $message = (Session::has('alanee_flashmessage')) ? Session::get('alanee_flashmessage') : null;
		Session::forget('alanee_flashmessage');
		Session::flash('message', ''); 
		return $message;
	} */
	
public function setFlashMessage($message=null) {
		if($message != null) {
			$_SESSION['alanee_flashmessage'] = $message;
			$_SESSION['message'] = $_SESSION['alanee_flashmessage'];
		}
	}
	
	/**
	 * Get flash message value
	 * @return message
	 */
	public function getFlashMessage(){
	 	$message = isset($_SESSION['alanee_flashmessage']) ? $_SESSION['alanee_flashmessage'] : null;
		unset($_SESSION['alanee_flashmessage']);
		$_SESSION['message'] = '';
		return $message;
	}

	
	public function Track_Download($type,$chart_codes=null){
        if(!empty($_SESSION['user']['email'])){
            $Usertype=$_SESSION['user']['user_type'];
            $Username=$_SESSION['user']['email'];
        } else {
            $Usertype='Non-Logged';
            $Username='Non-Logged';
        }
        if(isset($_SERVER['HTTP_REFERER']))
        	$current_url = $_SERVER['HTTP_REFERER'];
        else
        	$current_url = "";
        
        // $Username=(Session::has('user.email'))?Session::get('user.email'):'Non-Logged';
        if($type == "archive"){
            $input=array('Usertype'=>$Usertype,'Username'=>$Username,'when'=>date('d-m-Y'),'IP'=>$this->get_client_ip(),'REFERER'=>$current_url);
            $path="logs/archive_download_track.txt";
        } else {
             $input=array('Type'=>$type,'Chartcode'=>$chart_codes,'Usertype'=>$Usertype,'Username'=>$Username,'when'=>date('d-m-Y'),'IP'=>$this->get_client_ip(),'REFERER'=>$current_url);
             $path="logs/chart_download_track.txt";
        }
        // var_dump($input);
        //  die();
        $no_of_lines = count(file(storage_path($path))); 
        $event_json = ($no_of_lines/2).json_encode($input).PHP_EOL."\r\n";;
        $handler = fopen(storage_path($path),'a');
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
