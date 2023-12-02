<?php
namespace App\Http\Controllers;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use Config;
use app\Lib\Autoloader;
use App\Model\Media;
use App\Lib\CommonClass;
use App\Lib\Acl;
use App\Lib\Navigation;
use App\Model\User;
use App\Model\Userfolders;
use App\Model\Mailtemplate;
use App\Lib\MailGunAPI;
use App\Libraries\mailer\PHPMailer;
use Exception;
use App\Http\Controllers\ErrorController;
use Response;
use Session;
use PHPPowerPoint;
use PHPPowerPoint_Style_Alignment;
use PHPPowerPoint_Style_Color;
use PHPPowerPoint_Style_Bullet;
use PHPPowerPoint_Shape_MemoryDrawing;
use PHPPowerPoint_IOFactory;
use PHPPowerPoint_Style_Fill;
use PHPPowerPoint_Style_Font;
class MychartsController extends Controller {
		public $Export_url;
	
	
		public function __construct ()
		{
View::share ( 'menu_items', $this->populateLeftMenuLinks());
require(base_path().'/vendor/vendor_phppowerpoint/Classes/PHPPowerPoint.php');
require(base_path().'/vendor/vendor_phppowerpoint/Classes/PHPPowerPoint/IOFactory.php');
//$this->Export_url=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on')?'https://export.japanmacroadvisors.com/':'http://52.6.41.234:8080/';
$this->Export_url=(env('APP_ENV')=='production')?'https://export.japanmacroadvisors.com/':'http://export.japanmacroadvisors.com/';	
	}
	
	
public function about_my_chart(){
	
	
	//$this->handleUnpaidUser();
	$renderResultSet['pageTitle ']= "Welcome to Japan macro advisors - MyCharts";
	$renderResultSet['meta']['description']='Japan macro advisors - MyCharts';
	$renderResultSet['meta']['keywords']='japan macroadvisors, japan';
	$data['renderResultSet']=$renderResultSet;
	return view('mycharts.about_my_chart', $data);	

}

	public function index(){



		

		if($this->isUserLoggedIn() == true) {
			$this->handleUnpaidUser();
			$renderResultSet['pageTitle ']= "Welcome to Japan macro advisors - MyCharts";
	$renderResultSet['meta']['description']='Japan macro advisors - MyCharts';
	$renderResultSet['meta']['keywords']='japan macroadvisors, japan';
	$data['renderResultSet']=$renderResultSet;
			
			 return view('mycharts.index', $data);	
		}else{
			return redirect('/');
		}	
	}
	
	public function listChartBook(){
		if($this->isUserLoggedIn() == true) {
			$this->handleUnpaidUser();
			$renderResultSet['pageTitle ']= "Welcome to Japan macro advisors - MyCharts";
	$renderResultSet['meta']['description']='Japan macro advisors - MyCharts';
	$renderResultSet['meta']['keywords']='japan macroadvisors, japan';
	$data['renderResultSet']=$renderResultSet;
			// get all category items
			
			
		 return view('mycharts.listChartBook', $data);	
		}else{
			return redirect('/');
		}	
	}
	
	
	public function list_chartbook(){
		if($this->isUserLoggedIn() == true) {
			$this->handleUnpaidUser();
			$renderResultSet['pageTitle ']= "Welcome to Japan macro advisors - MyCharts";
	$renderResultSet['meta']['description']='Japan macro advisors - MyCharts';
	$renderResultSet['meta']['keywords']='japan macroadvisors, japan';
	$data['renderResultSet']=$renderResultSet;
		
			$folder = new Userfolders();
			$viewChartBookList = $folder->viewChartBookLists();
			$data['result']['viewChartBookList'] = $viewChartBookList;
		
			 return view('mycharts.list_chartbook', $data);
		}else{
			return redirect('/');
		}	
	}
	
	public function collectAllchartbook(){
			if($this->isUserLoggedIn() == true) {
				$folder = new Userfolders();
				$viewChartBookList = $folder->collectchartbook(Session::get('user.id'));
				$this->renderResultSet['result'] = $viewChartBookList;
				$this->renderAjax('json');

		}
	}
	
	/**
	 * Folder functionalities - create, delete, rename
	 */
	public function folder($params){
		
		if($this->isUserLoggedIn() == true) {
		
		try {
			switch ($params){
				case 'getallfolders':
						$folder = new Userfolders();
						if( $this->isUserLoggedIn() ) {
							$folderList = $folder->getFolder(Session::get('user.id'));
							$this->renderResultSet['status'] = 1;
							$this->renderResultSet['message'] = 'OK';
							$this->renderResultSet['result'] = $folderList;								
						}else{
							throw new Exception("Error.Authentication failed.",9999);
						}
					break;
				case 'create':
					if(isset($_POST['folder_name'])) {
						$folder = new Userfolders();
						$fname = $_POST['folder_name'];
						if(Session::get('user.id') != $_POST['user_id']){
							throw new Exception("Error.Authentication failed.",9999);
						}
						if( $this->isUserLoggedIn() ) {
							if ($this->isCreateFolderAllowed()){
								 $fid = $folder->putFolder( Session::get('user.id') , $fname );
								if( null != $fid ) {
									$this->renderResultSet['status'] = 1;
									$this->renderResultSet['message'] = 'OK';
									$this->renderResultSet['result'] = array('folder_id'=>$fid);
								}
								else {
									throw new Exception("Error.Folder cannot be created.",9999);
								}
							}else{
								throw new Exception("Permission denied to create new folder.",1001);
							}
							
						}else{
							throw new Exception("Error.Authentication failed.",9999);
						}
					}else{
						throw new Exception("Error. Invalid request",9999);
					}
					break;
				case 'rename':
					if(isset($_POST['folder_name']) && isset($_POST['folder_id'])) {
						$folder = new Userfolders();
						$fname = $_POST['folder_name'];
						$fid = $_POST['folder_id'];
						if( $this->isUserLoggedIn() ) {
							if($folder->updateFolder( $fid , $fname )) {
								$this->renderResultSet['status'] = 1;
								$this->renderResultSet['message'] = 'OK';
								$this->renderResultSet['result'] = array();
							}
							else {
								throw new Exception("Error.Folder cannot be renamed.",9999);
							}
						}else{
							throw new Exception("Error.Authentication failed.",9999);
						}
					}else{
						throw new Exception("Error. Invalid request",9999);
					}
					break;
				case 'delete':
					if(isset($_POST['folder_id'])) {
						$folder = new Userfolders();
						$fid = $_POST['folder_id'];
						if( $this->isUserLoggedIn() ) {
							if($folder->deleteFolder( $fid )  ) {
								$this->renderResultSet['status'] = 1;
								$this->renderResultSet['message'] = 'OK';
								$this->renderResultSet['result'] = array();
							}
							else {
								throw new Exception("Error.Folder cannot be deleted.",9999);
							}
						}else{
							throw new Exception("Error.Authentication failed.",9999);
						}
					}else{
						throw new Exception("Error. Invalid request",9999);
					}
					break;
				case 'getthisfolderdata':
				
					if(isset($_POST['folder_id'])) {
						$folder = new Userfolders();
						$fid = $_POST['folder_id'];
						if( $this->isUserLoggedIn() ) {
								$folderData = $folder->getThisFolderData($fid,Session::get('user.id'));
								$this->renderResultSet['status'] = 1;
								$this->renderResultSet['message'] = 'OK';
								$this->renderResultSet['result'] = array('folderData'=>$folderData);
						}else{
							throw new Exception("Error.Authentication failed.",9999);
						}
					}else{
						throw new Exception("Error. Invalid request",9999);
					}					
					break;
				case 'reorder':
					if(isset($_POST['folder_id'])) {
						$folder = new Userfolders();
						$fid = $_POST['folder_id'];
						$new_order = $_POST['new_order'];
						if( $this->isUserLoggedIn() ) {
							if($folder->updateOrder($fid,Session::get('user.id'),$new_order)){
								$this->renderResultSet['status'] = 1;
								$this->renderResultSet['message'] = 'OK';
								$this->renderResultSet['result'] = array();
							}else{
								throw new Exception("Error in saving order",9999);
							}
						}else{
							throw new Exception("Error.Authentication failed.",9999);
						}
					}else{
						throw new Exception("Error. Invalid request",9999);
					}					
					break;
				case 'createcontent':
					if(isset($_POST['chart_data'])) {
						$folder = new Userfolders();
						$chart_data = $_POST['chart_data'];
						$folder_id = $_POST['folder_id'];
						if( $this->isUserLoggedIn() ) {
							$user_id = Session::get('user.id');
							if($this->isAddChartAllowed($folder_id)){
								if($folder->addThisContentToFolder($folder_id,$user_id,$chart_data)){
									$this->renderResultSet['status'] = 1;
									$this->renderResultSet['message'] = 'OK';
									$this->renderResultSet['result'] = array();
								}else{
									throw new Exception("Error.failed saving graph.");
								}
							}else{
								throw new Exception("Permission denied to add content to this folder.",1001);
							}
						}else{
							throw new Exception("Error.Authentication failed.",9999);
						}
					}else{
						throw new Exception("Error. Invalid request",9999);
					}
					break;
					
				case 'savenotecontent':
					if(isset($_POST['uuid'])) {
						$folder = new Userfolders();
						$note_content = $_POST['note_content'];
						$uuid = $_POST['uuid'];
						$folder_id = $_POST['folder_id'];
						if( $this->isUserLoggedIn() ) {
							$user_id = Session::get('user.id');
							if($folder->saveThisNoteContentByUUID($folder_id,$user_id,$uuid,$note_content)){
								$this->renderResultSet['status'] = 1;
								$this->renderResultSet['message'] = 'OK';
								$this->renderResultSet['result'] = array();
							}else{
								throw new Exception("Error.failed saving graph.");
							}
								
						}else{
							throw new Exception("Error.Authentication failed.",9999);
						}
					}else{
						throw new Exception("Error. Invalid request",9999);
					}				
					
					break;
					
					case 'savecharttitle':
						if(isset($_POST['uuid'])) {
							$folder = new Userfolders();
							$title_content = $_POST['title_content'];
							$uuid = $_POST['uuid'];
							$folder_id = $_POST['folder_id'];
							if( $this->isUserLoggedIn() ) {
								$user_id = Session::get('user.id');
								if($folder->saveChartTitleByUUID($folder_id,$user_id,$uuid,$title_content)){
									$this->renderResultSet['status'] = 1;
									$this->renderResultSet['message'] = 'OK';
									$this->renderResultSet['result'] = array();
								}else{
									throw new Exception("Error.failed saving graph.");
								}
					
							}else{
								throw new Exception("Error.Authentication failed.",9999);
							}
						}else{
							throw new Exception("Error. Invalid request",9999);
						}
							
						break;
						
					case 'duplicatecontent':
						if(isset($_POST['currentUuid'])) {
							$folder = new Userfolders();
							$currentUuid = $_POST['currentUuid'];
							$newUuid = $_POST['newUuid'];
							$folder_id = $_POST['folder_id'];
							$currentOrder = $_POST['currentOrder'];
							if( $this->isUserLoggedIn() ) {
								$user_id = Session::get('user.id');
								if($this->isAddChartAllowed($folder_id)){
									if($folder->duplicateContentFromThis($folder_id,$user_id,$currentUuid,$newUuid,$currentOrder)){
										$this->renderResultSet['status'] = 1;
										$this->renderResultSet['message'] = 'OK';
										$this->renderResultSet['result'] = array();
									}else{
										throw new Exception("Error.failed saving graph.");
									}
								}else{
									throw new Exception("Permission denied to add content to this folder.",1001);
								}
							}else{
								throw new Exception("Error.Authentication failed.",9999);
							}
						}else{
							throw new Exception("Error. Invalid request",9999);
						}
							
						break;
					
					
					default: throw new Exception('Error.Invalid request',9999);
				
		}
		}catch (Exception $ex){
			$this->renderResultSet['status'] = $ex->getCode();
			$this->renderResultSet['message'] = $ex->getMessage();
			$this->renderResultSet['result'] = array();
		}
		ob_clean();
return Response::json($this->renderResultSet, '200');

		
		}else{
			return redirect('/');
		}
	}
	
	
	
	/**
	 * ChartBook functionalities - create, delete, rename
	 */
	public function chartbook($params){
		if($this->isUserLoggedIn() == true) {
		
		try {
			switch ($params){
				case 'getallfolders':
						$folder = new Userfolders();
						if( $this->isUserLoggedIn() ) {
							$folderList = $folder->getChartBook(Session::get('user.id'));
							$this->renderResultSet['status'] = 1;
							$this->renderResultSet['message'] = 'OK';
							$this->renderResultSet['result'] = $folderList;								
						}else{
							throw new Exception("Error.Authentication failed.",9999);
						}
					break;
				case 'getLatestCb':
						$folder = new Userfolders();
						if( $this->isUserLoggedIn() ) {
							$folderList = $folder->getLatestChartBook();
							$this->renderResultSet['status'] = 1;
							$this->renderResultSet['message'] = 'OK';
							$this->renderResultSet['result'] = $folderList;								
						}else{
							throw new Exception("Error.Authentication failed.",9999);
						}
					break;	
				case 'create':
					if(isset($_POST['book_name'])) {
						$folder = new Userfolders();
						$fname = $_POST['book_name'];
						if(Session::get('user.id') != $_POST['user_id']){
							throw new Exception("Error.Authentication failed.",9999);
						}
						if( $this->isUserLoggedIn() ) {
							if ($this->isCreateFolderAllowed()){
								$fid = $folder->putChartBook( Session::get('user.id') , $fname );
								if( null != $fid ) {
									$this->renderResultSet['status'] = 1;
									$this->renderResultSet['message'] = 'OK';
									$this->renderResultSet['result'] = array('folder_id'=>$fid);
								}
								else {
									throw new Exception("Error.Folder cannot be created.",9999);
								}
							}else{
								throw new Exception("Permission denied to create new folder.",1001);
							}
							
						}else{
							throw new Exception("Error.Authentication failed.",9999);
						}
					}else{
						throw new Exception("Error. Invalid request",9999);
					}
					break;
				case 'rename':
					if(isset($_POST['folder_name']) && isset($_POST['folder_id'])) {
						$folder = new Userfolders();
						$fname = $_POST['folder_name'];
						$fid = $_POST['folder_id'];
						if( $this->isUserLoggedIn() ) {
							if($folder->updateChartBookRename( $fid , $fname )) {
								$this->renderResultSet['status'] = 1;
								$this->renderResultSet['message'] = 'OK';
								$this->renderResultSet['result'] = array();
							}
							else {
								throw new Exception("Error.Folder cannot be renamed.",9999);
							}
						}else{
							throw new Exception("Error.Authentication failed.",9999);
						}
					}else{
						throw new Exception("Error. Invalid request",9999);
					}
					break;
				case 'delete':
					if(isset($_POST['folder_id'])) {
						$folder = new Userfolders();
						$fid = $_POST['folder_id'];
						if( $this->isUserLoggedIn() ) {
							if($folder->deleteChartBook( $fid )  ) {   
								$this->renderResultSet['status'] = 1;
								$this->renderResultSet['message'] = 'OK';
								$this->renderResultSet['result'] = array();
							}
							else {
								throw new Exception("Error.Folder cannot be deleted.",9999);
							}
						}else{
							throw new Exception("Error.Authentication failed.",9999);
						}
					}else{
						throw new Exception("Error. Invalid request",9999);
					}
					break;
				case 'status':
					if(isset($_POST['folder_id'])) {
						$folder = new Userfolders();
						$fid = $_POST['folder_id'];
						$fstatus = $_POST['folder_status'];
						if( $this->isUserLoggedIn() ) {
							if($folder->changeStatuaChartBook( $fid ,$fstatus )  ) {   
								$this->renderResultSet['status'] = 1;
								$this->renderResultSet['message'] = 'OK';
								$this->renderResultSet['result'] = array();
							}
							else {
								throw new Exception("Error.Folder cannot be deleted.",9999);
							}
						}else{
							throw new Exception("Error.Authentication failed.",9999);
						}
					}else{
						throw new Exception("Error. Invalid request",9999);
					}
					break;	
				case 'getthisfolderdata':
					if(isset($_POST['folder_id'])) {  
						$folder = new Userfolders();
						$fid = $_POST['folder_id'];
						if( $this->isUserLoggedIn() ) {	
								$folderData = $folder->getThisCahertBookData($fid,Session::get('user.id'));
								
								$this->renderResultSet['status'] = 1;
								$this->renderResultSet['message'] = 'OK';
								$this->renderResultSet['result'] = array('folderData'=>$folderData);
						}else{
							throw new Exception("Error.Authentication failed.",9999);
						}
					}else{
						throw new Exception("Error. Invalid request",9999);
					}					
					break;
				case 'reorder':
					if(isset($_POST['folder_id'])) {
						$folder = new Userfolders();
						$fid = $_POST['folder_id'];
						$new_order = $_POST['new_order'];
						if( $this->isUserLoggedIn() ) {
							if($folder->updateChartBookOrder($fid,Session::get('user.id'),$new_order)){
								$this->renderResultSet['status'] = 1;
								$this->renderResultSet['message'] = 'OK';
								$this->renderResultSet['result'] = array();
							}else{
								throw new Exception("Error in saving order",9999);
							}
						}else{
							throw new Exception("Error.Authentication failed.",9999);
						}
					}else{
						throw new Exception("Error. Invalid request",9999);
					}					
					break;
				case 'createcontent':
					if(isset($_POST['chart_data'])) {
						$folder = new Userfolders();
						$chart_data = $_POST['chart_data'];
						$folder_id = $_POST['folder_id'];
						if( $this->isUserLoggedIn() ) {
							$user_id = Session::get('user.id');
							
								if($folder->addThisContentToChartBook($folder_id,$user_id,$chart_data)){
									$this->renderResultSet['status'] = 1;
									$this->renderResultSet['message'] = 'OK';
									$this->renderResultSet['result'] = array();
								}else{
									throw new Exception("Error.failed saving graph.");
								}
							
						}else{
							throw new Exception("Error.Authentication failed.",9999);
						}
					}else{
						throw new Exception("Error. Invalid request",9999);
					}
					break;
					
				case 'savenotecontent':
					if(isset($_POST['uuid'])) {
						$folder = new Userfolders();
						$note_content = $_POST['note_content'];
						$uuid = $_POST['uuid'];
						$folder_id = $_POST['folder_id'];
						if( $this->isUserLoggedIn() ) {
							$user_id = Session::get('user.id');
							if($folder->saveThisNoteContentByUUIDForChartBook($folder_id,$user_id,$uuid,$note_content)){  
								$this->renderResultSet['status'] = 1;
								$this->renderResultSet['message'] = 'OK';
								$this->renderResultSet['result'] = array();
							}else{
								throw new Exception("Error.failed saving graph.");
							}
								
						}else{
							throw new Exception("Error.Authentication failed.",9999);
						}
					}else{
						throw new Exception("Error. Invalid request",9999);
					}				
					
					break;
					
					case 'savecharttitle':
						if(isset($_POST['uuid'])) {
							$folder = new Userfolders();
							$title_content = $_POST['title_content'];
							$uuid = $_POST['uuid'];
							$folder_id = $_POST['folder_id'];
							if( $this->isUserLoggedIn() ) {
								$user_id = Session::get('user.id');
								if($folder->saveChartTitleByUUIDForChartBook($folder_id,$user_id,$uuid,$title_content)){
									$this->renderResultSet['status'] = 1;
									$this->renderResultSet['message'] = 'OK';
									$this->renderResultSet['result'] = array();
								}else{
									throw new Exception("Error.failed saving graph.");
								}
					
							}else{
								throw new Exception("Error.Authentication failed.",9999);
							}
						}else{
							throw new Exception("Error. Invalid request",9999);
						}
							
						break;
					case 'updatechartbookdesc':
						if(isset($_POST['desc'])) {
							$folder = new Userfolders();
							$desc = addslashes($_POST['desc']);
							$folder_id = $_POST['folderId'];
							if( $this->isUserLoggedIn() ) {
								$user_id = Session::get('user.id');
								if($folder->updateChartBookDescription($folder_id,$desc)){
									$this->renderResultSet['status'] = 1;
									$this->renderResultSet['message'] = 'OK';
									$this->renderResultSet['result'] = array();
								}else{
									throw new Exception("Error.failed saving graph.");
								}
					
							}else{
								throw new Exception("Error.Authentication failed.",9999);
							}
						}else{
							throw new Exception("Error. Invalid request",9999);
						}
							
						break;	
					case 'duplicatecontent':
						if(isset($_POST['currentUuid'])) {
							$folder = new Userfolders();
							$currentUuid = $_POST['currentUuid'];
							$newUuid = $_POST['newUuid'];
							$folder_id = $_POST['folder_id'];
							$currentOrder = $_POST['currentOrder'];
							if( $this->isUserLoggedIn() ) {
								$user_id = Session::get('user.id');
							
									if($folder->duplicateChartBookContentFromThis($folder_id,$user_id,$currentUuid,$newUuid,$currentOrder)){
										$this->renderResultSet['status'] = 1;
										$this->renderResultSet['message'] = 'OK';
										$this->renderResultSet['result'] = array();
									}else{
										throw new Exception("Error.failed saving graph.");
									}
								
							}else{
								throw new Exception("Error.Authentication failed.",9999);
							}
						}else{
							throw new Exception("Error. Invalid request",9999);
						}
							
						break;
					
					
					default: throw new Exception('Error.Invalid request',9999);
				
		}
		}catch (Exception $ex){
			$this->renderResultSet['status'] = $ex->getCode();
			$this->renderResultSet['message'] = $ex->getMessage();
			$this->renderResultSet['result'] = array();
		}

		return Response::json($this->renderResultSet, '200');
	

		
		}else{
			return redirect('/');
		}
	}
	
	
	/**
	 * Chart functionalities - add to folder, delete from folder etc
	 */
	public function chart($params){

		if($this->isUserLoggedIn() == true) {
		
		try {
			switch ($params){
				case 'addtofolder':
					if(isset($_POST['chart_data'])) {
						$folder = new Userfolders();
						$chart_data = $_POST['chart_data'];
						$folder_id = $_POST['folder_id'];
						if( $this->isUserLoggedIn() ) {
							$user_id = Session::get('user.id');
							if($this->isAddChartAllowed($folder_id)){
								if($folder->saveThisChartToFolder($folder_id,$user_id,$chart_data)){
									$this->renderResultSet['status'] = 1;
									$this->renderResultSet['message'] = 'OK';
									$this->renderResultSet['result'] = array();
								}else{
									throw new Exception("Error.failed saving graph.");
								}
							}else{
								throw new Exception("Permission denied to add content to this folder.",1001);
							}
						}else{
							throw new Exception("Error.Authentication failed.",9999);
						}
					}else{
						throw new Exception("Error. Invalid request",9999);
					}
					break;
					
				case 'updatethiseditedchart':
					if(isset($_POST['chart_data'])) {
						$folder = new Userfolders();
						$chart_data = $_POST['chart_data'];
						$folder_id = $_POST['folder_id'];
						if( $this->isUserLoggedIn() ) {
							$user_id = Session::get('user.id');
							if($folder->updateThisEditedChart($folder_id,$user_id,$chart_data)){
								$this->renderResultSet['status'] = 1;
								$this->renderResultSet['message'] = 'OK';
								$this->renderResultSet['result'] = array();
							}else{
								throw new Exception("Error.failed saving graph.");
							}
					
						}else{
							throw new Exception("Error.Authentication failed.",9999);
						}
					}else{
						throw new Exception("Error. Invalid request",9999);
					}
					break;
				
				case 'deletethisfoldercontent':
					if(isset($_POST['folder_id'])) {
						$folder = new Userfolders();
						$uuid = $_POST['uuid'];
						$folder_id = $_POST['folder_id'];
						if( $this->isUserLoggedIn() ) {
							$user_id = Session::get('user.id');
							if($folder->deleteThisFolderContent($folder_id,$user_id,$uuid)){
								$this->renderResultSet['status'] = 1;
								$this->renderResultSet['message'] = 'OK';
								$this->renderResultSet['result'] = array();
							}else{
								throw new Exception("Error.failed saving graph.");
							}
								
						}else{
							throw new Exception("Error.Authentication failed.",9999);
						}
					}else{
						throw new Exception("Error. Invalid request",9999);
					}
					break;
					break;
			}
		}catch (Exception $ex){
			$this->renderResultSet['status'] = $ex->getCode();
			$this->renderResultSet['message'] = $ex->getMessage();
			$this->renderResultSet['result'] = array();
		}
		ob_clean();
return Response::json($this->renderResultSet, '200');
		}else{
			return redirect('/');
		}
	}
	
	/**
	 * Chart saveChartBookToMychart - add to chart book to mychart folder.
	 */
	public function saveChartBookToMychart()
	{
		
		
		if($this->isUserLoggedIn() == true) {
		
		   try
		   {
			   if(isset($_POST['folder_id'])) 
			   {
				        $folder = new Userfolders();
						$folder_id = $_POST['folder_id'];
						$user_id = Session::get('user.id');
						
						if($lastFolder = $folder->saveThisChartBookToMychart($folder_id,$user_id))
						{
							$this->renderResultSet['status'] = 1;
							$this->renderResultSet['message'] = 'OK';
							$this->renderResultSet['result'] = $lastFolder;
						}
						else
						{
							throw new Exception("Error.failed saving graph.");
						}
						
			   }
		   }
		   catch (Exception $ex){
				$this->renderResultSet['status'] = $ex->getCode();
				$this->renderResultSet['message'] = $ex->getMessage();
				$this->renderResultSet['result'] = array();
		   }

		 return Response::json($this->renderResultSet, '200');
		}else{
		return redirect('/');
		}
			
			
	}
	
	
	/**
	 * Chart functionalities - add to folder, delete from folder etc
	 */
	public function chartbookList($params){

		if($this->isUserLoggedIn() == true) {
		
		try {
			switch ($params){
				case 'addtofolder':
					if(isset($_POST['chart_data'])) {
						$folder = new Userfolders();
						$chart_data = $_POST['chart_data'];
						$folder_id = $_POST['folder_id'];
						if( $this->isUserLoggedIn() ) {
							$user_id = Session::get('user.id');
							
								if($folder->saveThisChartTochartBook($folder_id,$user_id,$chart_data)){
									$this->renderResultSet['status'] = 1;
									$this->renderResultSet['message'] = 'OK';
									$this->renderResultSet['result'] = array();
								}else{
									throw new Exception("Error.failed saving graph.");
								}
							
						}else{
							throw new Exception("Error.Authentication failed.",9999);
						}
					}else{
						throw new Exception("Error. Invalid request",9999);
					}
					break;
					
				case 'updatethiseditedchart':
					if(isset($_POST['chart_data'])) {
						$folder = new Userfolders();
						$chart_data = $_POST['chart_data'];
						$folder_id = $_POST['folder_id'];
						if( $this->isUserLoggedIn() ) {
							$user_id = Session::get('user.id');
							if($folder->updateThisEditedChartBook($folder_id,$user_id,$chart_data)){
								$this->renderResultSet['status'] = 1;
								$this->renderResultSet['message'] = 'OK';
								$this->renderResultSet['result'] = array();
							}else{
								throw new Exception("Error.failed saving graph.");
							}
					
						}else{
							throw new Exception("Error.Authentication failed.",9999);
						}
					}else{
						throw new Exception("Error. Invalid request",9999);
					}
					break;
				
				case 'deletethisfoldercontent':
					if(isset($_POST['folder_id'])) {
						$folder = new Userfolders();
						$uuid = $_POST['uuid'];
						$folder_id = $_POST['folder_id'];
						if( $this->isUserLoggedIn() ) {
							$user_id = Session::get('user.id');
							if($folder->deleteThisChartBookContent($folder_id,$user_id,$uuid)){
								$this->renderResultSet['status'] = 1;
								$this->renderResultSet['message'] = 'OK';
								$this->renderResultSet['result'] = array();
							}else{
								throw new Exception("Error.failed saving graph.");
							}
								
						}else{
							throw new Exception("Error.Authentication failed.",9999);
						}
					}else{
						throw new Exception("Error. Invalid request",9999);
					}
					break;
					break;
			}
		}catch (Exception $ex){
			$this->renderResultSet['status'] = $ex->getCode();
			$this->renderResultSet['message'] = $ex->getMessage();
			$this->renderResultSet['result'] = array();
		}
		return Response::json($this->renderResultSet, '200');
		
		}else{
			return redirect('/');
		}
	}
	
	/**
	 * Function to check folder creation permission
	 */

	private function isCreateFolderAllowed(){
		try {
			$folder = new Userfolders();
			$totalFoldersForThisUser = $folder->getTotalNumberOfFoldersForThisUser(Session::get('user.id'));
			if($totalFoldersForThisUser < Session::get('user.user_permissions.mychart.totalFolders')){
				return true;
			}else{
				return false;
			}
		} catch (Exception $e) {
			 return false;
		}
	}
	
	/**
	 * Function to check add chart to a folder is allowed
	 */
	private function isAddChartAllowed($folder_id){
		try {
		
			$folder = new Userfolders();
			 $totalChartsInFolder = $folder->getTotalNumberOfContentsInThisFolder($folder_id,Session::get('user.id'));	
			 
			if($totalChartsInFolder < Session::get('user.user_permissions.mychart.totalChartsPerFolder')){
				return true;
			}else{
				return false;
			}
		} catch (Exception $e) {
			return false;
		}
		
	}


	private function Bulk_image_by_npm($data){
		try {
$get_allimages=array_column($data, 'chart');
$total_chart_img=count(get_allimages);
if($total_chart_img>0){
	$image_npm_cmd_str='';
	$tempFilepath_conf = Config::read ( 'chart.download' ); 
		$tempFilepath = $tempFilepath_conf ['tempfolder'];
	 foreach ($get_allimages as $key => $value) {
	$get_img_str_=explode("/", $value);
  	$img_name_= end($get_img_str_);

	 	$image_npm_cmd_str.=$tempFilepath.str_replace('png', 'svg', $img_name_)."=".$tempFilepath.$img_name_.";";
	 }

	 $server_PATH='/usr/local/bin/';

	 $output = shell_exec ( $server_PATH.'highcharts-export-server --width 900 --scale 2 --batch "'.$image_npm_cmd_str.'"' );

	 shell_exec ( "killall php" );
	/* if (! is_file ( $outfile ) || filesize ( $outfile ) < 10) {
$array=array('msg'=>'Error while converting SVG.','file'=>'');
echo json_encode($array);
	}*/
}
return true;
} catch (Exception $e) {
return false;
}
		
}

	public function power_point()
{ 



	if(strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){


$dir = base_path()."/public/phppowerpoint/created/";

$eachfiles = scandir($dir);
foreach ($eachfiles as $eachfile) {
	if($eachfile!='.' && $eachfile!='index.php' && $eachfile!='..')
		unlink($dir.$eachfile);
}
$this->Track_Download('ppt-mychart');

	$objPHPPowerPoint = new PHPPowerPoint();



$objPHPPowerPoint->getProperties()->setCreator("Maarten Balliauw")
								  ->setLastModifiedBy("Maarten Balliauw")
								  ->setTitle("Office 2007 PPTX Test Document")
								  ->setSubject("Office 2007 PPTX Test Document")
								  ->setDescription("Test document for Office 2007 PPTX, generated using PHP classes.")
								  ->setKeywords("office 2007 openxml php")
								  ->setCategory("Test result file");

$objPHPPowerPoint->removeSlideByIndex(0);
//First Slider With Folder Title
$currentSlide = $this->createTemplatedSlide($objPHPPowerPoint,'title'); 
// Create header Jma Logo
#$jma_logo = $currentSlide->createDrawingShape();
#$jma_logo->setName('Jma logo')->setDescription('Jma logo')->setPath('./images/logo.gif')->setHeight(36)->setOffsetX(10)->setOffsetY(10);
#$jma_logo->getShadow()->setVisible(true)->setDirection(45)->setDistance(10); Shodow

# start Folder Title
$jma_text = $currentSlide->createRichTextShape()->setHeight(100)->setWidth(600)->setOffsetX(170)->setOffsetY(180);
$jma_text->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_CENTER );
if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!=null){
$currentfolder_title=$_POST['title'].'-'.$_POST['page_no'];
$jma_textRun = $jma_text->createTextRun($currentfolder_title);
$jma_textRun->getFont()->setBold(true)->setSize(40)->setColor( new PHPPowerPoint_Style_Color( 'FFC00000' ) );
}else{
$currentfolder_title=$_POST['title'];
$jma_textRun = $jma_text->createTextRun($currentfolder_title);
$jma_textRun->getFont()->setBold(true)->setSize(60)->setColor( new PHPPowerPoint_Style_Color( 'FFC00000' ) );
}

// Create  (line)
$line = $currentSlide->createLineShape(170, 180, 770, 180);
$line->getBorder()->getColor()->setARGB('FFC00000');
// Create a shape (line)
$line = $currentSlide->createLineShape(170, 300, 770, 300);
$line->getBorder()->getColor()->setARGB('FFC00000');
#Each chart Slider With  Title



$total_chart=count($_POST['data']);
if($total_chart>0){
	$sn=0;

$evenPath = Config::read('environment') != '' ?trim(Config::read('environment'),'/') : '';
if($evenPath != "development")
{
// By Bulk Image cretaing
$this->Bulk_image_by_npm($_POST['data']);
}
 foreach ($_POST['data'] as $key => $value) {


# Start Draw Table
if(is_array($value) && array_key_exists("table", $value)){

$tableDataseries=json_decode($value['table']['data']);
$tableDataseries_H=($value['table']['heading']);
$tableSlide = $this->createTemplatedSlide($objPHPPowerPoint,'table'); 

# Heading
$each_text = $tableSlide->createRichTextShape()->setHeight(40)->setWidth(900)->setOffsetX(50)->setOffsetY(20);
$each_text->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );
$each_textRun = $each_text->createTextRun(($sn+1).".".$_POST['titleArray'][$sn]);
$each_textRun->getFont()->setBold(true)->setSize(20)->setColor(new PHPPowerPoint_Style_Color( 'FFC00000' ) );

$totalsetColSpan=count($tableDataseries_H)+1;

if($totalsetColSpan>3){
	$from_X=100;
	$slide_W=700;
}else{
	$slide_W=600;
	$from_X=200;
}

// Create a shape (table)
$tableshape = $tableSlide->createTableShape($totalsetColSpan)->setHeight(500)->setWidth($slide_W)->setOffsetX($from_X)->setOffsetY(80);
// Add row with Th

$th_row = $tableshape->createRow();
$th_row->setHeight(20);
$th_row->getFill()->setFillType(PHPPowerPoint_Style_Fill::FILL_SOLID)
               ->setRotation(90)
               ->setStartColor(new PHPPowerPoint_Style_Color('00F5F5F5'));
               
	
$th_row->nextCell()->createTextRun('Date')->getFont()->setBold(true)->setSize(16);
foreach (array_filter($tableDataseries_H) as $each_th_cell) {
$th_row->nextCell()->createTextRun((($each_th_cell!=null)?$each_th_cell:'N/A'))->getFont()->setBold(true)->setSize(13);
}


# Add Row With Draw td
foreach (array_filter($tableDataseries) as $key => $each_td_cell) {
$td_row = $tableshape->createRow();
foreach ($tableDataseries[$key] as $each_th_cell_hd) {
$td_row->nextCell()->createTextRun((($each_th_cell_hd!=null)?$each_th_cell_hd:'-'))->getFont()->setBold(true)->setSize(13);

}
}



# Source Text
$each_sourcetext = $tableSlide->createRichTextShape()->setHeight(30)->setWidth(700)->setOffsetX(200)->setOffsetY(610);
$each_sourcetext->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT);
$source=($_POST['sourceArray'][$sn]!=null)?$_POST['sourceArray'][$sn]:'Source: N/A';
$textRun = $each_sourcetext->createTextRun($source);
$textRun->getFont()->setBold(true)->setSize(15)->setColor(new PHPPowerPoint_Style_Color( '00000000' ) );

/*$source_td_row = $tableshape->createRow();
$source_td_cell = $source_td_row->nextCell();
$source_td_cell->setColSpan($totalsetColSpan);
$source_td_cell->createTextRun($source)->getFont()->setBold(true)->setSize(13);*/



  }elseif(is_array($value) && array_key_exists("chart", $value)){


 $chart_value=$value['chart'];



$currentchartSlide = $this->createTemplatedSlide($objPHPPowerPoint,'chart'); 
# Header
$each_text = $currentchartSlide->createRichTextShape()->setHeight(40)->setWidth(900)->setOffsetX(50)->setOffsetY(20);
$each_text->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );

$each_textRun = $each_text->createTextRun(($sn+1).".".$_POST['titleArray'][$sn]);
$each_textRun->getFont()->setBold(true)->setSize(20)->setColor(new PHPPowerPoint_Style_Color( 'FFC00000' ) );

$find_str=trim(@reset(explode("/", $chart_value)));


if($find_str=='files' || $find_str=='charts'){


$get_img_str=explode("/", $chart_value);
  $img_name= end($get_img_str);

if($find_str=='charts'){
 // If it is cretaing iamge from Highchart server Start
/*if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") { 
$url= "https://export.highcharts.com/";
} else { 
      $url= "http://export.highcharts.com/";
}*/

 $url= $this->Export_url;
copy($url.$chart_value, './public/temp/'.$img_name);
// If it is cretaing iamge from Highchart server End

}

$img_create = imagecreatefrompng('./public/temp/'.$img_name);
 $i_width = imagesx($img_create);
 $i_height = imagesy($img_create);
$img_resize = imagecreatetruecolor ($i_width,$i_height); 
imagecopyresampled ($img_resize,$img_create,0,0,0,0,$i_width,$i_height,$i_width,$i_height);

unlink ('./public/temp/'.$img_name);
/*if($evenPath != "development")
{
unlink ('./public/temp/'.str_replace('png', 'svg', $img_name));
}*/
// Image Object
$each_img = new PHPPowerPoint_Shape_MemoryDrawing();
$each_img->setName('Jma My chart')
      ->setDescription('Jma My chart')
      ->setImageResource($img_resize)
      ->setRenderingFunction(PHPPowerPoint_Shape_MemoryDrawing::RENDERING_JPEG)
      ->setMimeType(PHPPowerPoint_Shape_MemoryDrawing::MIMETYPE_DEFAULT)
      ->setHeight(550)
      ->setOffsetX(20)
      ->setOffsetY(70);
$currentchartSlide->addShape($each_img);


if(isset($_REQUEST['currentView']) && $_REQUEST['currentView']=='smallView'){

if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!=null){
# Source Text
$each_sourcetext = $currentchartSlide->createRichTextShape()->setHeight(30)->setWidth(700)->setOffsetX(80)->setOffsetY(610);
$each_sourcetext->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT);
$source=($_POST['sourceArray'][$sn]!=null)?$_POST['sourceArray'][$sn]:'Source: N/A';
$textRun = $each_sourcetext->createTextRun($source);
$textRun->getFont()->setBold(true)->setSize(15)->setColor(new PHPPowerPoint_Style_Color( '00000000' ) );
}
}

/* From folder path $each_img = $currentSlide1->createDrawingShape();
 $each_img->setName('PHPPowerPoint logo')
          ->setDescription('PHPPowerPoint logo')
          ->setPath('./temp/'.$img_name)
          ->setHeight(550)
          ->setOffsetX(20)
          ->setOffsetY(70);*/




}else{

$each_charterror = $currentchartSlide->createRichTextShape()->setHeight(500)->setWidth(800)->setOffsetX(30)->setOffsetY(80);
$each_charterror->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT)->setMarginLeft(25)->setIndent(-25);
$each_charterror->getActiveParagraph()->getFont()->setBold(true)->setSize(26)->setColor( new PHPPowerPoint_Style_Color( '00000000' ) );
$each_charterror->getActiveParagraph()->getBulletStyle()->setBulletType(PHPPowerPoint_Style_Bullet::TYPE_BULLET)->setBulletChar('•');
$each_charterror->createParagraph()->getAlignment()->setLevel(0)->setMarginLeft(25)->setIndent(-25);
$each_charterror->createTextRun("Due to bad internet connection we cant't export chart. Please try Again");

}

}else{




 $notes=($_POST['NotesArray'][$sn]!=null)?$_POST['NotesArray'][$sn]:'N/A';
if($notes){
	/* $replaes = array("","");
	$replacement = array("","");
	$fdf = str_replace("<p><img", "END", $notes);
	$dddd = explode("END",$fdf); */
	
	 $src_sources = array();
	 $imageSize = 280;
     $imageFind = preg_match_all('/<img[^>]+>/i',$notes, $result); 
	
	 if(empty($imageFind))
	 {
			$content = strip_tags($notes,"<li><span><strong><u><br><p><div>");
			$replace = str_replace("</li>", "END", $content);
			$replace2 = str_replace("<br>", "END", $replace);
			$replace3 = str_replace("</div>", "END", $replace2);
			$replace4 = str_replace("</p>", "END", $replace3);
			$notes_array = explode("END",$replace4);
			$notes_array2 = array_map('trim',$notes_array);
			array_pop($notes_array2);
	 }else{
		
		$notes_array2 = $result[0];
		
		$img = array();
			foreach($notes_array2 as $img_tag)
			{
				preg_match_all('/(src)=("[^"]*")/i',$img_tag, $img[$img_tag]);
			}
			foreach($img as $img_del)
			{
			    $src_sources[] = $img_del[2][0]; 
			}
			
			
			$content = strip_tags($notes,"<li><span><strong><u><br><p><div>");
			$replace = str_replace("</li>", "END", $content);
			$replace2 = str_replace("<br>", "END", $replace);
			$replace3 = str_replace("</div>", "END", $replace2);
			$replace4 = str_replace("</p>", "END", $replace3);
			$notes_array = explode("END",$replace4);
			$notes_array2 = array_map('trim',$notes_array);
			array_pop($notes_array2);
			
			foreach ($notes_array2 as $key => $value) 
			{
				$replace =array("<p>","<p>&nbsp;","&nbsp;");
				$replacement =array("","","");
				$newVal = str_replace($replace,$replacement,$value);
			
				 if(strlen($newVal)>0) {
					$imageSize = 280;
					break;
				}
				else
				{
					$imageSize = 520;
				}
				 
			}
			
	 }	 
	 
	 
	//print_r($notes_array2);exit;
	//echo $res;exit;
}
$notes_count = count($notes_array2);

/* 
$each_notetext->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );
$each_notetext->createTextRun(($sn+1).".".$_POST['titleArray'][$sn]);
$each_notetext->getFont()->setBold(true)->setSize(20)->setColor(new PHPPowerPoint_Style_Color( 'FFC00000' ) ); */

if($notes_count>0){

	if(!empty($src_sources))
	{
		$imageName = array();
		foreach($src_sources as $kval => $vVal)
		{
			$imageSorces = explode("/",$vVal);
			$imageName[] =  str_replace('"','',array_pop($imageSorces)); 
			
		}	
		
		//dd($imageName);
		$numOfImage = count($imageName);
		
		$currentnoteSlide = $this->createTemplatedSlideImage($objPHPPowerPoint,$imageName,$imageSize,$numOfImage); 
		
		//dd($src_sources);
			
		
		
		//$currentnoteSlide = $this->createTemplatedSlide($objPHPPowerPoint,'note'); 

			
		# Header
		$each_text = $currentnoteSlide->createRichTextShape()->setHeight(40)->setWidth(800)->setOffsetX(50)->setOffsetY(20);
		$each_text->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );

		$each_notetext = $each_text->createTextRun(($sn+1).".".$_POST['titleArray'][$sn]);
		$each_notetext->getFont()->setBold(true)->setSize(20)->setColor(new PHPPowerPoint_Style_Color( 'FFC00000' ) ); 

		$each_notetext = $currentnoteSlide->createRichTextShape()->setHeight(260)->setWidth(800)->setOffsetX(30)->setOffsetY(380);
		
		// Add logo
		/* $currentnoteSlide->createDrawingShape()
			  ->setName('PHPPowerPoint logo')
			  ->setDescription('PHPPowerPoint logo')
			 ->setPath('./public/uploads/ckImages/'.$imageName)
			  ->setHeight(120)
			  ->setOffsetX(20)
			  ->setOffsetY(70); */
			  

	}
	else
	{
		$currentnoteSlide = $this->createTemplatedSlide($objPHPPowerPoint,'note'); 

			
		# Header
		$each_text = $currentnoteSlide->createRichTextShape()->setHeight(40)->setWidth(800)->setOffsetX(50)->setOffsetY(20);
		$each_text->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );

		$each_notetext = $each_text->createTextRun(($sn+1).".".$_POST['titleArray'][$sn]);
		$each_notetext->getFont()->setBold(true)->setSize(20)->setColor(new PHPPowerPoint_Style_Color( 'FFC00000' ) ); 

		$each_notetext = $currentnoteSlide->createRichTextShape()->setHeight(500)->setWidth(800)->setOffsetX(30)->setOffsetY(80);
	}
	
	//for ($n=0; $n <$notes_count; $n++) { 
	$i =0;
	foreach ($notes_array2 as $key => $value) {
		$i++;
		$bullet = false;
		$setBold = false;
		/*$rep=array('<ul>','</ul>','<li>','</li>','<p>','</p>','&nbsp;');
		$eachvalue = str_replace($rep, "", $value);
		$eachvalue=strip_tags($eachvalue);*/
		if(preg_match('/<li>/',$value)){
			$bullet = true;
		}
		if(preg_match('/<strong>/',$value)){
			$setBold = true;
		}		
		$text = htmlentities($value);
		//$color = array('color:', '&quot;&gt;');
		$size = array('font-size:','&quot;&gt;');
		$font = array('font-family:','&quot;&gt;');
		$underline = array('text-decoration:','&quot;&gt;');
		$styleAlign = array('text-align:','&quot;&gt;');
		//$colorcode = $this->getColorSizeFont($color[0],$color[1],$text);
		if(preg_match('/font-size/',$text)){
			$sizecode = $this->getColorSizeFont($size[0],$size[1],$text);
			$sizecode = explode("px",$sizecode);
		}
		else{
			$sizecode[0] = 16;
		}
		if(preg_match('/font-family/',$text)){
			$fontcode = $this->getColorSizeFont($font[0],$font[1],$text);
			$fontcode = explode(",",$fontcode);
			$fontcode2 = str_replace("'", "", $fontcode[0]);
			$fontcode[0] = preg_replace('/\s+/', '', $fontcode2);
			if($fontcode[0] == 'comicsansms'){
				$fontcode[0] = 'comic sans ms';
			}elseif($fontcode[0] == 'andalemono'){
				$fontcode[0] = 'andale mono';
			}elseif($fontcode[0] == 'arialblack'){
				$fontcode[0] = 'arial black';
			}elseif($fontcode[0] == 'bookantiqua'){
				$fontcode[0] = 'book antiqua';
			}elseif($fontcode[0] == 'couriernew'){
				$fontcode[0] = 'courier new';
			}elseif($fontcode[0] == 'symbol;'){
				$fontcode[0] = 'symbol';
			}elseif($fontcode[0] == 'timesnewroman'){
				$fontcode[0] = 'times new roman';
			}elseif($fontcode[0] == 'trebuchetms'){
				$fontcode[0] = 'trebuchet ms';
			}else{
				$fontcode[0] = $fontcode[0];
			}
		}
		else {
			$fontcode[0] = 'arial';
		}
		if(preg_match('/text-decoration/',$text)){
			$getUnderline = $this->getColorSizeFont($underline[0],$underline[1],$text);
			$getUnderline = explode(",",$getUnderline);
		}
		else{
			$getUnderline[0] = 'none';
		}
		
		if(preg_match('/text-align/',$text)){
			$getStyleAlign = $this->getColorSizeFont($styleAlign[0],$styleAlign[1],$text);
			$getStyleAlign = explode(",",$getStyleAlign);
		}
		else{
			$getStyleAlign[0] = '';
		}
		
		
		$rep=array('<ul>','</ul>','<li>','</li>','<p>','</p>','&nbsp;');
		$eachvalue = str_replace($rep, "", $value);
		$eachvalue=strip_tags($eachvalue);

		if($eachvalue!=''){
$each_notetext->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT)->setMarginLeft(25)->setIndent(-25);
$each_notetext->getActiveParagraph()->getFont()->setBold($setBold)->setName($fontcode[0])->setSize($sizecode[0]);
//$each_notetext->getActiveParagraph()->getBulletStyle()->setBulletType(PHPPowerPoint_Style_Bullet::TYPE_BULLET)->setBulletChar('•');
if(trim($getUnderline[0])=='underline;')
{
	$each_notetext->getActiveParagraph()->getFont()->setUnderline(PHPPowerPoint_Style_Font::UNDERLINE_SINGLE);
}
else
{
	$each_notetext->getActiveParagraph()->getFont()->setUnderline(PHPPowerPoint_Style_Font::UNDERLINE_NONE);
}

if(trim($getStyleAlign[0])=='center;')
{
	$each_notetext->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_CENTER );
}
elseif(trim($getStyleAlign[0])=='left;')
{
	$each_notetext->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );
}
elseif(trim($getStyleAlign[0])=='right;')
{
	$each_notetext->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_RIGHT );
}
elseif(trim($getStyleAlign[0])=='justify;')
{
	$each_notetext->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_JUSTIFY );
}

if(preg_match('/<li>/',$value)){$each_notetext->getActiveParagraph()->getBulletStyle()->setBulletType(PHPPowerPoint_Style_Bullet::TYPE_BULLET)->setBulletChar('•');}else{$each_notetext->getActiveParagraph()->getBulletStyle()->setBulletType(PHPPowerPoint_Style_Bullet::TYPE_NONE)->setBulletChar('');}
//$each_notetext->createParagraph()->getAlignment()->setLevel(0)->setMarginLeft(25)->setIndent(-25);
//$each_notetext->getActiveParagraph()->getBulletStyle()->setBulletType(PHPPowerPoint_Style_Bullet::TYPE_BULLET)->setBulletChar('•');
//if($i==1){$each_notetext->createTextRun($eachvalue);}
//$each_notetext->createTextRun($eachvalue);
$each_notetext->createTextRun($eachvalue);
$each_notetext->createBreak();	
$each_notetext->createParagraph();
	
	

		}
	}
}








}



$sn++;
}

// Final DISCLAIMER Slider
$currentSlide2 = $this->createTemplatedSlide($objPHPPowerPoint,'disc'); 
$title_shape = $currentSlide2->createRichTextShape()->setHeight(100)->setWidth(900)->setOffsetX(10)->setOffsetY(10);
$title_shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );
$title_textRun = $title_shape->createTextRun('IMPORTANT DISCLAIMER');
$title_textRun->getFont()->setBold(true)->setSize(30)->setColor( new PHPPowerPoint_Style_Color( 'FFC00000' ) );

$disc_para = $currentSlide2->createRichTextShape()->setHeight(600)->setWidth(900)->setOffsetX(10)->setOffsetY(50);
$disc_para->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT )->setMarginLeft(25)->setIndent(-35);
$disc_para->getActiveParagraph()->getFont()->setSize(20)->setColor( new PHPPowerPoint_Style_Color( '00000000' ) );
$disc_para->createParagraph()->createTextRun('IMPORTANT DISCLAIMER:  The information herein is not intended to be an offer to buy or sell, or a solicitation of an offer to buy or sell, any securities and including any expression of opinion, has been obtained from or is based upon sources believed to be reliable but is not guaranteed as to accuracy or completeness although Japan Macro Advisors (JMA) believe it to be clear, fair and not misleading.  Each author of this report is not permitted to trade in or hold any of the investments or related investments which are the subject of this document.  The views of JMA reflected in this document may change without notice.  To the maximum extent possible at law, JMA does not accept any liability whatsoever arising from the use of the material or information contained herein.  This research document is not intended for use by or targeted at retail customers.  Should a retail customer obtain a copy of this report they should not base their investment decisions solely on the basis of this document but must seek independent financial advice.');

// Save PowerPoint 2007 file
$objWriter = PHPPowerPoint_IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
//$objWriter->setLayoutPack(new PHPPowerPoint_Writer_PowerPoint2007_LayoutPack_TemplateBased('./libraries/phppowerpoint/ppt_resources/newppt.pptx'));
#$objWriter->save(str_replace('.php', '.pptx', __FILE__));
if(isset($_REQUEST['page_no']) && $_REQUEST['page_no']!=null){
//$newname = $_REQUEST['page_no']."-".date('Y-m-d H-m-s')."-".mt_rand(10,100).".pptx";
$newname = $_REQUEST['title'].'-'.$_REQUEST['page_no']."-".date('Y-m-d').".pptx";
}else{
//$newname = "PresentationReport-".date('Y-m-d H-m-s')."-".mt_rand(10,100).".pptx";
$newname = $_REQUEST['title']."-".date('Y-m-d').".pptx";
}



$objWriter->save(base_path()."/public/phppowerpoint/created/".$newname);

$array=array('msg'=>true,'file'=>$newname,'dir'=>"/public/phppowerpoint/created/");
return Response::json($array, '200');
}else{
$array=array('msg'=>'You dont have valid chat','file'=>'');
return Response::json($array, '200');
}
// block to download file.
/*$filename = str_replace('.php', '.pptx', __FILE__);
header("Pragma: no-cache");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Disposition: attachment;filename=" . $newname);
ob_clean();
flush();
readfile($filename);
exit();*/
}else{
	echo die("Invalid Data");
}

}
	
	
	/**
 * Creates a templated slide
 *
 * @param PHPPowerPoint $objPHPPowerPoint
 * @return PHPPowerPoint_Slide
 */
 private function createTemplatedSlideImage(PHPPowerPoint $objPHPPowerPoint,$imageName,$imageSize,$numOfImage)
{
	// Create slide
	$slide = $objPHPPowerPoint->createSlide();
    // Add logo
	$offsetX = 30;
	$offsetY = 80;
	$i = 1;
	
	if($numOfImage > 2)
	{
		$imageSize = 230;
	}
	
	foreach($imageName as $nKey => $nValue)
	{
		$xdem =1;
		if($i == 2)
		{
			$xdem = $i *8;
			
		}
		elseif($i == 3)
		{
			$offsetX = 30;
	        $offsetY = 380;
			
		}
		elseif($i == 4)
		{
			$offsetX = 30;
	        $offsetY = 380;
			$xdem = $i *4;
			
		}
		
			if($numOfImage == 1 && $imageSize == 280)
			{
				$slide->createDrawingShape()
				 ->setName('PHPPowerPoint logo')
				 ->setDescription('PHPPowerPoint logo')
				 ->setPath('./public/uploads/ckImages/'.$nValue)
				 ->setHeight($imageSize)
				 ->setWidth(400)
				 ->setOffsetX($offsetX*$xdem)
				 ->setOffsetY($offsetY);
			}
			else if($numOfImage == 1 && $imageSize != 280)
			{
				$slide->createDrawingShape()
				 ->setName('PHPPowerPoint logo')
				 ->setDescription('PHPPowerPoint logo')
				 ->setPath('./public/uploads/ckImages/'.$nValue)
				 ->setHeight($imageSize)
				 ->setWidth(800)
				 ->setOffsetX($offsetX*$xdem)
				 ->setOffsetY($offsetY);
			}
			else
			{
				$slide->createDrawingShape()
				 ->setName('PHPPowerPoint logo')
				 ->setDescription('PHPPowerPoint logo')
				 ->setPath('./public/uploads/ckImages/'.$nValue)
				 ->setHeight($imageSize)
				 ->setWidth(400)
				 ->setOffsetX($offsetX*$xdem)
				 ->setOffsetY($offsetY);
			}
		 
				  
				  
				  $i++;
				  
		
	}
	
	
	
	
	/* if($imageSize == 280)
	{
	   $slide->createDrawingShape()
				  ->setName('PHPPowerPoint logo')
				  ->setDescription('PHPPowerPoint logo')
				 ->setPath('./public/uploads/ckImages/'.$imageName)
				  ->setHeight(150)
				  ->setOffsetX(20)
				  ->setOffsetY(70); 
	}
	else
	{
	   $slide->createDrawingShape()
				  ->setName('PHPPowerPoint logo')
				  ->setDescription('PHPPowerPoint logo')
				 ->setPath('./public/uploads/ckImages/'.$imageName)
				  ->setHeight(150)
				  ->setWidth(800)
				  ->setOffsetX(20)
				  ->setOffsetY(70); 
	} */
   

    // Return slide
	 $slide->createDrawingShape()
          ->setName('PHPPowerPoint logo')
          ->setDescription('PHPPowerPoint logo')
          ->setPath('./assets/images/logo.gif')
          ->setHeight(40)
          ->setOffsetX(10)
          ->setOffsetY(720 - 20 - 50);
		  
    return $slide;
}
 
private function createTemplatedSlide(PHPPowerPoint $objPHPPowerPoint,$type)
{
	// Create slide
	$slide = $objPHPPowerPoint->createSlide();

	

    // Add logo
    $slide->createDrawingShape()
          ->setName('PHPPowerPoint logo')
          ->setDescription('PHPPowerPoint logo')
          ->setPath('./assets/images/logo.gif')
          ->setHeight(40)
          ->setOffsetX(10)
          ->setOffsetY(720 - 20 - 50);

    // Return slide
    return $slide;
}


public function getColorSizeFont($var1,$var2,$text)
{
	$temp1 = strpos($text,$var1)+strlen($var1);
	$result = substr($text,$temp1,strlen($text));
	$dd=strpos($result,$var2);
	if($dd == 0){
		$dd = strlen($result);
	}
	$res = substr($result,0,$dd);
	return $res;
}


public function single_chart_ppt()
{ 
		

	$objPHPPowerPoint = new PHPPowerPoint();
	

	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){



$dir = base_path()."/public/phppowerpoint/created/";
$eachfiles = scandir($dir);
foreach ($eachfiles as $eachfile) {
	if($eachfile!='.' && $eachfile!='index.php' && $eachfile!='..')
		unlink($dir.$eachfile);
}

$this->Track_Download('ppt');
	
	$objPHPPowerPoint = new PHPPowerPoint();



$objPHPPowerPoint->getProperties()->setCreator("Maarten Balliauw")
								  ->setLastModifiedBy("Maarten Balliauw")
								  ->setTitle("Office 2007 PPTX Test Document")
								  ->setSubject("Office 2007 PPTX Test Document")
								  ->setDescription("Test document for Office 2007 PPTX, generated using PHP classes.")
								  ->setKeywords("office 2007 openxml php")
								  ->setCategory("Test result file");

$objPHPPowerPoint->removeSlideByIndex(0);
//First Slider With Folder Title
$currentSlide = $this->createTemplatedSlide($objPHPPowerPoint,'title'); 


# start Folder Title
$jma_text = $currentSlide->createRichTextShape()->setHeight(100)->setWidth(600)->setOffsetX(170)->setOffsetY(180);
$jma_text->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_CENTER );
$jma_textRun = $jma_text->createTextRun('JMA Chart');
$jma_textRun->getFont()->setBold(true)->setSize(60)->setColor( new PHPPowerPoint_Style_Color( 'FFC00000' ) );
// Create  (line)
$line = $currentSlide->createLineShape(170, 180, 770, 180);
$line->getBorder()->getColor()->setARGB('FFC00000');
// Create a shape (line)
$line = $currentSlide->createLineShape(170, 300, 770, 300);
$line->getBorder()->getColor()->setARGB('FFC00000');
#Each chart Slider With  Title
#print_r($_POST);die;
$total_chart=count($_POST);
if($total_chart>0){

 $chart_value=$_POST['chart'];

$currentchartSlide = $this->createTemplatedSlide($objPHPPowerPoint,'chart'); 



if(@reset(explode("/", $chart_value))=='charts'){

$get_img_str=explode("/", $chart_value);
 $img_name= end($get_img_str);

 $url= $this->Export_url;
copy($url.$chart_value, './public/temp/'.$img_name);
$img_create = imagecreatefromjpeg('./public/temp/'.$img_name);
  $i_width = imagesx($img_create);
  $i_height = imagesy($img_create);
$img_resize = imagecreatetruecolor (1400,933); 
imagecopyresampled ($img_resize,$img_create,0,0,0,0,1400,933,$i_width,$i_height);

unlink ('./public/temp/'.$img_name);
// Image Object
$each_img = new PHPPowerPoint_Shape_MemoryDrawing();
$each_img->setName('Jma My chart')
      ->setDescription('Jma My chart')
      ->setImageResource($img_resize)
      ->setRenderingFunction(PHPPowerPoint_Shape_MemoryDrawing::RENDERING_JPEG)
      ->setMimeType(PHPPowerPoint_Shape_MemoryDrawing::MIMETYPE_DEFAULT)
      ->setHeight(600)
      ->setOffsetX(20)
      ->setOffsetY(20);
$currentchartSlide->addShape($each_img);





}else{
	// internet connection
	$each_charterror = $currentchartSlide->createRichTextShape()->setHeight(500)->setWidth(800)->setOffsetX(30)->setOffsetY(80);
$each_charterror->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT)->setMarginLeft(25)->setIndent(-25);
$each_charterror->getActiveParagraph()->getFont()->setBold(true)->setSize(26)->setColor( new PHPPowerPoint_Style_Color( '00000000' ) );
$each_charterror->getActiveParagraph()->getBulletStyle()->setBulletType(PHPPowerPoint_Style_Bullet::TYPE_BULLET)->setBulletChar('•');
$each_charterror->createParagraph()->getAlignment()->setLevel(0)->setMarginLeft(25)->setIndent(-25);
$each_charterror->createTextRun("Due to bad internet connection we cant't export chart. Please try Again");
}





// Final DISCLAIMER Slider


// Save PowerPoint 2007 file
$objWriter = PHPPowerPoint_IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
$newname = "PresentationReport-".date('Y-m-d H-m-s')."-".mt_rand(10,100).".pptx";
$objWriter->save(base_path()."/public/phppowerpoint/created/".$newname);
$array=array('msg'=>true,'file'=>$newname,'dir'=>"/public/phppowerpoint/created/");
return Response::json($array, '200');

}else{
$array=array('msg'=>'You dont have valid chat','file'=>'');
return Response::json($array, '200');

}
}else{
	echo die("Invalid Data");
}

}


	
}