<?php
namespace App\Http\Controllers;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Html\FormFacade;
use View;
use Config;
use App\Model\Media;
use App\Lib\CommonClass;
use App\Lib\Acl;
use Exception;
use App\Http\Controllers\ErrorController;
use App\Model\Material;
use App\Libraries\mailer\PHPMailer;
use Session;
class MaterialsController extends Controller {
	
	public function __construct ()
        {


        		 parent::__construct();
            View::share ( 'menu_items', $this->populateLeftMenuLinks());
   


        }
	public function index() {
	 new ErrorController(404);
	}
	
	
	
	public function category(Request $request) {
			$params=$request->route()->parameters();
		$this->handleUnpaidUser();
		//echo '<pre>';
		//print_r($params); exit;
		if(count($_POST)>0) {
			$name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
			$phone = filter_var(trim($_POST['phone']), FILTER_SANITIZE_STRING);
			$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
			$data['result']['postvars']['name'] = $name;
			$data['result']['postvars']['phone'] = $phone;
			$data['result']['postvars']['email'] = $email;
			if($name == ''){			
				$this->setFlashMessage('<font color="#ff0000">Please enter your name.</font>');
			}elseif($phone == ''){
				$this->setFlashMessage('<font color="#ff0000">Please enter your phone number.</font>');
			}elseif($email == ''){
				$this->setFlashMessage('<font color="#ff0000">Please enter your email.</font>');
			}elseif(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
				$this->setFlashMessage('<font color="#ff0000">Please enter a valid email.</font>');
			}else{
				$data['result']['postvars'] = array();
				$this->setFlashMessage('<font color="#00ff00">Thank you for contacting JMA. We will get back to you shortly.</font>');
			}
			// Send notification mail
			$notification_to = Config::read('mailconfig.'.Config::read('environment').'.oxford_enquiry_to');
			$notification_subject = Config::read('mailconfig.'.Config::read('environment').'.oxford_enquiry_subject');
			$mail = new PHPMailer();
			$mail->IsSMTP();
			//$mail->IsMail();
			$mail->IsHTML(true);
			$mail->SMTPDebug  = 0;                // enables SMTP debug information (for testing)
			$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
			$mail->WordWrap = 50;
			$mail->SetFrom('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
			$mail->AddReplyTo('info@japanmacroadvisors.com', 'japanmacroadvisors.com');
			$mail->Subject = $notification_subject;
			$mail->Body = "Received a new enquiry on Oxford page.<p>Name : ".$name."<br><br>Email : ".$email."<br><br>Phone : ".$phone."</p>";
			$mail->AddAddress($notification_to);
			$mail->Send();
			
		}
		$categoryurl_main = isset($params['sub_cat']) ? $params['sub_cat'] : null;
		$categoryurl_sub = isset($params['title']) ? $params['title'] : null;
		switch ($categoryurl_main){
			case 'presentation-materials':
				$material_type = 'general';
				break;
			case 'materials-in-japanese':
				$material_type = 'japanese';
				break;
			case 'oxford-economics':
				$material_type = 'oxford';
				break;
			default:
				$material_type = 'general';
				break;
		}
		$media = new Media();
		$data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
		$data['result']['rightside']['media'] = $media->getLatestMedia(5);
		$AlaneeCommon = new CommonClass();
		$renderResultSet['pageTitle'] = "Welcome to Japan macro advisors - Materials";
		$renderResultSet['meta']['description']='Japan macro advisors - Materials';
		$renderResultSet['meta']['keywords']='japan macroadvisors, japan, japan economy, presentation materials, materials in Japanese';
		$data['renderResultSet']=$renderResultSet;
		// get all category items
		
		$materials = new Material();
		$acl = new Acl();
		$materialsPost = $materials->getAllMaterials($material_type);
		$data['result']['materials'] = $materialsPost;
		if($this->isUserLoggedIn()==true) {
			$data['result']['login_status']=true;
			if($acl->isPermitted('content', 'report', 'premiumaccess')==true){
				$data['result']['access_permission']=true;
			} else {
				$data['result']['access_permission']=false;
			}
		}else{
			$data['result']['login_status']=false;
		}
		if($material_type == 'oxford'){

			/* $this->pageTitle = "ã‚°ãƒ­ãƒ¼ãƒ�ãƒ«çµŒæ¸ˆãƒ¬ãƒ�ãƒ¼ãƒˆï¼ˆã‚ªãƒƒã‚¯ã‚¹ãƒ•ã‚©ãƒ¼ãƒ‰ãƒ»ã‚¨ã‚³ãƒŽãƒŸã‚¯ã‚¹ç¤¾ãƒ¬ãƒ�ãƒ¼ãƒˆï¼‰"; */

			$renderResultSet['pageTitle'] = "オックスフォード・エコノミクス社レポート";
			$renderResultSet['meta']['description']='ã‚ªãƒƒã‚¯ã‚¹ãƒ•ã‚©ãƒ¼ãƒ‰ã‚¨ã‚³ãƒŽãƒŸã‚¯ã‚¹ç¤¾ã�Œç™ºä¿¡ã�™ã‚‹æ•°å¤šã��ã�®ãƒ¬ãƒ�ãƒ¼ãƒˆã�‹ã‚‰åŽ³é�¸ã�—ã�Ÿä¾¡å€¤ã�‚ã‚‹ãƒ¬ãƒ�ãƒ¼ãƒˆã‚’æ—¥æœ¬èªžè¨³ã�—ã€�æœˆæ¬¡3å›žç„¡æ–™ã�§ç™ºä¿¡ã�—ã�¦ã�„ã�¾ã�™ã€‚';
			$renderResultSet['meta']['keywords']='ã‚°ãƒ­ãƒ¼ãƒ�ãƒ«çµŒæ¸ˆãƒ¬ãƒ�ãƒ¼ãƒˆã€�ã‚ªãƒƒã‚¯ã‚¹ãƒ•ã‚©ãƒ¼ãƒ‰ãƒ»ã‚¨ã‚³ãƒŽãƒŸã‚¯ã‚¹ã€�Oxford Economics';
			$data['renderResultSet']=$renderResultSet;
		
			return view('materials.oxford',$data);
		}else{
			return view('materials.category',$data);
		}
	}
	
	public function download(Request $request) {
		$params=$request->route()->parameters();
		try {
		$acl = new Acl();
		$material_id = $params['id'];
		$materials = new Material();
		$get_material = $materials->getThisMaterial($material_id);
	
		if($get_material['is_premium'] == 'Y'){
			if($this->isUserLoggedIn()==true) {
				if($acl->isPermitted('content', 'report', 'premiumaccess')==false){

					throw new Exception("You donot have permission to download ".$params['file'], 9999);
				}
			}else {
				throw new Exception("Please log-in to download ".$params['file'], 9999);
			}
		}
		$filename = $get_material['material_path'];
		if($filename!=$params['file']) {throw new Exception("File ".$params['file']." donot exist on server", 0000); }
		 $appPath = trim(Config::read('appication_path'));
		$fullPath = $_SERVER["DOCUMENT_ROOT"].($appPath!= '' ? $appPath : '').'/public/uploads/materials/'.$filename;
		$fd = fopen ($fullPath, "r");
		if ($fd) {
		    $fsize = filesize($fullPath);
		    $path_parts = pathinfo($fullPath);
		    $ext = strtolower($path_parts["extension"]);
		    switch ($ext) {
		        case "pdf":
					header("Content-type: application/pdf"); // add here more headers for diff. extensions
					header("Content-Disposition: inline; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a download
		        break;
				case "pptx":
					header("Content-type: application/vnd.openxmlformats-officedocument.presentationml.presentation"); 
					header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
				break;
				case "xlsx":
					header("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"); 
					header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
				break;	
				case "xltx":
					header("application/vnd.openxmlformats-officedocument.spreadsheetml.template"); 
					header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
				break;		
				case "potx":
					header("application/vnd.openxmlformats-officedocument.presentationml.template"); 
					header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
				break;		
				case "ppsx":
					header("application/vnd.openxmlformats-officedocument.presentationml.slideshow"); 
					header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
				break;		
				case "sldx":
					header("application/vnd.openxmlformats-officedocument.presentationml.slide"); 
					header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
				break;		
				case "docx":
					header("application/vnd.openxmlformats-officedocument.wordprocessingml.document"); 
					header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
				break;				
		        default;
					header("Content-type: application/octet-stream");
					header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
		    }
		    header("Content-length: $fsize");
		    header("Cache-control: private"); //use this to open files directly
		    while(!feof($fd)) {
		        $buffer = fread($fd, 2048);
		        echo $buffer;
		    }
		}else{
			exit("File does not exist on server.");
		}
			fclose ($fd);
		} catch (Exception $ex){
			echo $ex->getMessage();
		}
		exit;
	}
	
}

?>