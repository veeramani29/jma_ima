<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class AlaneeController extends AlaneeCore {
	public $httpsRootPath;
	
	public function AlaneeController($controllername='',$action='',$params=''){
		parent::AlaneeCore($controllername,$action,$params);
		$this->httpsRootPath = 'https:'.$this->rootPath;
		
		if(isset($_COOKIE['jmacrm']))
		{
			$rm = base64_decode($_COOKIE['jmacrm']);
			$rmb = base64_decode($rm);
			$remember = explode("_",$rmb);
			$name = $remember[1];
			$pass = $remember[2];
			$user = new User();
			$userDetails = $user->getUserDetailsByUserNameAndPassword($name,$pass);
			$userDetails['password'] = '********';
			if(count($userDetails)>0 && $userDetails['id'] >0) {
				$_SESSION['user'] = $userDetails;
			}	
		}
	}
	
	protected function populateLeftMenuLinks() {
		$postCategory = new postCategory();
		$folder = new Userfolders();
		$navigation = new Navigation();
		$categories = $postCategory->getAllCategory();
		if( $this->isUserLoggedIn() ) {
			$folderList = $folder->getFolder($_SESSION['user']['id']);
			
			/* $chartBookList = array();
			$showtBookList = $folder->getChartBookList($_SESSION['user']['id']); */
			
			
			if($_SESSION['user']['user_type_id'] == 2 || $_SESSION['user']['user_type_id'] == 3)
			{
				if($_SESSION['user']['isAuthor'] == "Y")
				{
					$chartBookList = $folder->getChartBookList($_SESSION['user']['id']);
					$chartBookListInactive = $folder->getChartBookInactiveList($_SESSION['user']['id']);
					$showtBookList = $folder->getActiveChartBookList($_SESSION['user']['id']);
				}
				else
				{
					$chartBookList = array();
					$showtBookList = $folder->getActiveChartBookList($_SESSION['user']['id']);
					$chartBookListInactive = array();
				}
			}
			else
			{
				$showtBookList = $folder->getActiveChartBookList($_SESSION['user']['id']);
			    $chartBookList = array();
				$chartBookListInactive = array();
			}
			
			
			//print_r($chartBookList);
			
			
			////	echo '<pre>';
			//	exit;
			//	print_r($folderList);
			$folders =  $navigation->createFolderNav($folderList,$this->controllername,$this->action);
		}else{
			$folderList = array();
			$chartBookList = array();
			$folders = '';
		}
		
				$detect = new Mobile_Detect();
			if($detect->isMobile() || $detect->isTablet()){
			$Responsive_left_menu = $navigation->createResponsiveNavigation($categories);
			$this->renderResultSet['result']['category']['Responsive_left_menu'] = $Responsive_left_menu;
			}

			if(($detect->isMobile() && $detect->isTablet() && $this->controllername!='mycharts') || (!$detect->isTablet() && $this->controllername!='mycharts')){
			$left_menu = $navigation->createLeftNavigation($categories);
			$this->renderResultSet['result']['category']['menu'] = $left_menu;
			}
		$this->renderResultSet['result']['category']['folders'] = $folders;
		$this->renderResultSet['result']['category']['folderList'] = $folderList;
		$this->renderResultSet['result']['category']['chartBookList'] = $chartBookList;
		$this->renderResultSet['result']['category']['showtBookList'] = $showtBookList;
		$this->renderResultSet['result']['category']['chartBookListInactive'] = $chartBookListInactive;
		
	}
	
	
	
	protected function populateLeftMenuLinksForBooks() {
		$postCategory = new postCategory();
		$folder = new Userfolders();
		$navigation = new Navigation();
		$categories = $postCategory->getAllCategory();
		if( $this->isUserLoggedIn() ) {
			
			if($_SESSION['user']['isAuthor'] == "Y")
			{
				
				$folderList = $folder->getFolder($_SESSION['user']['id']);
				$chartBookList = $folder->getChartBookList($_SESSION['user']['id']);
				$showtBookList = $folder->getActiveChartBookList($_SESSION['user']['id']);
				$folders =  $navigation->createFolderNav($folderList,$this->controllername,$this->action);
			}
			else
			{
				$folderList = $folder->getFolder($_SESSION['user']['id']);
				$chartBookList = array();
				$showtBookList = $folder->getActiveChartBookList($_SESSION['user']['id']);
				$folders =  $navigation->createFolderNav($folderList,$this->controllername,$this->action);
			}
			
			
		}else{
			$folderList = array();
			$chartBookList = array();
			$folders = '';
			$showtBookList = $folder->getActiveChartBookList($_SESSION['user']['id']);
		}
		
		
		$left_menu = $navigation->createLeftNavigation($categories);
		$Responsive_left_menu = $navigation->createResponsiveNavigation($categories);
		$this->renderResultSet['result']['category']['Responsive_left_menu'] = $Responsive_left_menu;
		$this->renderResultSet['result']['category']['menu'] = $left_menu;
		$this->renderResultSet['result']['category']['folders'] = $folders;
		$this->renderResultSet['result']['category']['folderList'] = $folderList;
		$this->renderResultSet['result']['category']['chartBookList'] = $chartBookList;
		$this->renderResultSet['result']['category']['showtBookList'] = $showtBookList;
		
	}
	
	protected function isUserLoggedIn() {
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


	
	
}


?>