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
#use App\Lib\Mobile_Detect;
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
		
			$folders =  $navigation->createFolderNav($folderList,thisController(),thisMethod());
		}else{
			$folderList = array();
			$folders = '';
		}
		$left_menu = $navigation->createLeftNavigation($categories);
		  $Responsive_left_menu = $navigation->createResponsiveNavigation($categories);
		$data['Responsive_left_menu'] = $Responsive_left_menu;
		$data['Normal_left_menu'] = $left_menu;
		$data['folders'] = $folders;
		$data['folderList'] = $folderList;
		//dd($data);
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

}
