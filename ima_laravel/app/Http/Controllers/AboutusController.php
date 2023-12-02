<?php


namespace App\Http\Controllers;
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
use App\Http\Controllers\Controller;
use View;
use App\Model\Postcategory;
use App\Model\Media;
use App\Lib\CommonClass;
use App\Lib\MailGunAPI;
use \Mailgun\Mailgun;

class AboutusController extends Controller {
	
	public function __construct ()
	{
		View::share ( 'menu_items', $this->populateLeftMenuLinks());
		View::share ( 'search_keywords', $this->searchBoxKeyWords());
	}
	
	public function index() {
		$this->handleUnpaidUser();
		$this->pageTitle = "Welcome to India macro advisors - About us";
		$this->renderResultSet['meta']['description']='We  aim to provide well structured interactive online database portal for the Indian economy';
		$this->renderResultSet['meta']['keywords']='India macroadvisors, India';
		$this->renderResultSet['meta']['shareTitle']='About Us|Our Economist team|India Macro Advisors';
		$data['renderResultSet']=$this->renderResultSet;
		// get all category items
		$postCategory = new postCategory();
		$media = new Media();
		$data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
		$data['result']['rightside']['media'] = $media->getLatestMedia(5);
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
		
		/* $this->populateLeftMenuLinks();	
		$this->renderView();		 */
		return view('aboutus.index',$data);	
	}
	
	public function privacypolicy() {
		$this->handleUnpaidUser();
		$this->renderResultSet['pageTitle'] = "Welcome to India macro advisors - Privacy policy";
		$this->renderResultSet['meta']['description']='We have created this privacy policy to guarantee our firm commitment to your privacy and the protection of your information.';
		$this->renderResultSet['meta']['keywords']='India macroadvisors, India';
		$this->renderResultSet['meta']['shareTitle'] = 'Privacy Policy|India Macro Advisors';
		$data['renderResultSet']=$this->renderResultSet;
		// get all category items
		$postCategory = new postCategory();
		$media = new Media();
		$data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
		$data['result']['rightside']['media'] = $media->getLatestMedia(5);
		
		
		return view('aboutus.privacypolicy',$data);
	}
	
	public function termsofuse() {
		$this->handleUnpaidUser();
		$this->renderResultSet['pageTitle'] = "Welcome to India macro advisors - Terms of Use";
		$this->renderResultSet['meta']['description']='Agreement to terms of use- Please read the following terms and conditions ("Terms of Use") before using the India Macro Advisors ("IMA", "We", "US" or "Our") website (the "Site")';
		$this->renderResultSet['meta']['keywords']='India macroadvisors, India';
		$this->renderResultSet['meta']['shareTitle'] = 'Terms of Use|India Macro Advisors';
		$data['renderResultSet']=$this->renderResultSet;
		
		// get all category items
		$postCategory = new postCategory();
		$media = new Media();
		$data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
		$data['result']['rightside']['media'] = $media->getLatestMedia(5);
		$AlaneeCommon = new CommonClass();
		if(count($data['result']['rightside']['notice'])>0) {
			foreach ($data['result']['rightside']['notice'] as &$rwn) {
				$rwn['media_value_text'] = $AlaneeCommon->editorfix($rwn['media_value_text']);
			}
		}
		if(count($data['result']['rightside']['media'])>0) {
			foreach ($data['result']['rightside']['media'] as &$rwm) {
				$rwm['media_value_text'] = $AlaneeCommon->editorfix($rwm['media_value_text']);
			}
		}
		
		return view('aboutus.termsofuse',$data);	
	}


	

public function commercial_policy(){

	$this->handleUnpaidUser();
		$this->renderResultSet['pageTitle'] = "Welcome to India macro advisors - Commercial policy";
		$this->renderResultSet['meta']['description']='India macro advisors - Commercial policy';
		$this->renderResultSet['meta']['keywords']='India macroadvisors, India';
		$data['renderResultSet']=$this->renderResultSet;
		// get all category items
		$postCategory = new postCategory();
		$media = new Media();
		$data['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
		$data['result']['rightside']['media'] = $media->getLatestMedia(5);
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
		
		return view('aboutus.commercial_policy',$data);	
}
	
	public function test(){
		$this->pageTitle = "Welcome to India macro advisors - Terms of Use";
		$this->renderResultSet['meta']['description']='India macro advisors - Terms of Use';
		$this->renderResultSet['meta']['keywords']='India macroadvisors, India';
		// get all category items
		$postCategory = new postCategory();
		$media = new Media();
		$this->renderResultSet['result']['rightside']['notice'] = $media->getLatestMediaAsNotice(5);
		$this->renderResultSet['result']['rightside']['media'] = $media->getLatestMedia(5);
		$AlaneeCommon = new Alaneecommon();
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
		$this->populateLeftMenuLinks();
		$this->renderView();
	}

	public function career($params=null){
		
		if(!empty($_FILES['careers_resume']))
		{
			
			        $file_name = $_FILES['careers_resume']['name'];
					$file_size = $_FILES['careers_resume']['size'];
					$file_tmp = $_FILES['careers_resume']['tmp_name'];
					$file_type = $_FILES['careers_resume']['type'];
					$extension = explode('.',$_FILES['careers_resume']['name']);
					$file_ext = $extension[1];

					$extensions = array("pdf","PDF");

					if(in_array($file_ext,$extensions)=== false){
						$errors[]="extension not allowed, please choose a pdf or PDF file.";
					}
					
					
					$target_dir = "assets/resume/";
                    $target_file = $target_dir . basename($_FILES["careers_resume"]["name"]);

					if (move_uploaded_file($_FILES["careers_resume"]["tmp_name"], $target_file)) {
						
					} else {
						$errors[]="Sorry, there was an error uploading your file.";
						print_r($errors);
						exit();
					}
					
					
					$mgObject = new MailGun(env('MailGunAPI'));


					/* $mgClient = $mgObject->Mailgun;

					$domain = $mgObject->domain; */ 
					
					$domain = 'mg.indiamacroadvisors.net';
					
					
					$uniquetime=time();
					
					$mailSubject = 'IMA';

					$mailBody = '<html>'.'Dear IMA Team,<br/>
					you have received the following resume.<br/>
					</html>';
					
					$result = $mgObject->sendMessage($domain, array(
							'from'    => 'info@mg.indiamacroadvisors.net',
							'to'      => 'erteam@indiamacroadvisors.com',
							'subject' => $mailSubject,
							'html'    => $mailBody,
							'o:tag'   => array($uniquetime)
					), array(
						'attachment' => array('./assets/resume/'.$file_name)
					));
					
				    unlink('./assets/resume/'.$file_name);
					return redirect ('aboutus/career/success');
					
		}
		
		
		
		
		$firstParam = isset($params) ? $params : ''; 
		$this->pageTitle = "Welcome to India macro advisors - Career";
		$this->renderResultSet['meta']['description']='If you are an aspiring young economist looking to combine analytical skills and entrepreneurial spirit, then join us';
		$this->renderResultSet['meta']['keywords']='India macroadvisors, India';
		$this->renderResultSet['meta']['shareTitle'] = 'Career|Job Opportunities|India Macro Advisors|Economic Research';
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
		return view('aboutus.career',$data);	
	}

}


?>