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
use App\Model\User;
use App\Model\Mailtemplate;
use App\Model\Country;
use App\Lib\MailGunAPI;
use App\Libraries\mailer\PHPMailer;
use App\Libraries\linkedIn\oauth_client_class;
use Exception;
use App\Http\Controllers\ErrorController;
use Session;
class HelpdeskController extends Controller {
	

	  public function __construct ()
        {

        		 parent::__construct();
            View::share ( 'menu_items', $this->populateLeftMenuLinks());
   


        }

	public function index() {
		 new ErrorController(404);
	}

	public function post() {
		$support_timeStart = mktime(8,0,0,date('n'),date('j'),date('Y'));
		$support_timeEnd = mktime(16,30,0,date('n'),date('j'),date('Y'));
		$user = new User();
        $country = new Country();
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

        $data['pageTitle']= "Welcome to Japan macro advisors - Post , Enquiry";
         $data['meta']['description']="Japan macro advisors - Post , Enquiry";
        $data['meta']['keywords']='Sign up, register, subscribe,Post , Enquiry';
        $data['renderResultSet']=$data;
		$data['result']['action'] = 'post';
		if(!Session::has('user') || !Session::get('user.id')) {
			return redirect('/');
		}
		if(isset($_POST['mail_body'])) {
			$mail_body = nl2br(trim($_POST['mail_body']));
			if($mail_body == '') {
				$data['result']['status'] = 3332;
				$data['result']['message'] = 'Please enter a description';
			} else {
				// sending email notification 
				  $mail = new PHPMailer();
				  $mail->IsSMTP();
				  //$mail->IsMail();
				  $mail->IsHTML(true);  
				  $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
				  $mail->SetFrom('info@japanmacroadvisors.com', 'JMA Info');
				  $mail->AddReplyTo(Session::get('user.email'));
				  $mail->Subject = 'Helpdesk - new message from '.Session::get('user.fname').'- smid: 6543'.time();
				  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
				  $mail->WordWrap = 50;
  			  	  $mail->AddAddress('support@japanmacroadvisors.com','JMA Helpdesk');
			  	  
				$mail->Body = 'From : '.Session::get('user.fname').' '.Session::get('user.lname').'<br><br>
								Email : '.Session::get('user.email').'<br><br>'.$mail_body;
				$mail->Send();
				$mail->clearAddresses();
    		  	$mail->clearAttachments();
				// notification send.
				
				// Prepare message to client.
				$currentTime = time();
				if($currentTime >= $support_timeStart && $currentTime <= $support_timeEnd) {
					$mail->SetFrom('info@japanmacroadvisors.com', 'JMA Info');
					$mail->AddReplyTo('support@japanmacroadvisors.com', 'JMA Support');
					$mail->Subject = 'Thank you.';
					$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
					$mail->WordWrap = 50;
	  			    $mail->AddAddress(Session::get('user.email'),Session::get('user.fname').' '.Session::get('user.lname'));
					$msg = 'Dear '.Session::get('user.fname').' '.Session::get('user.lname').', <br><br>Thank you for sending your query.This is an automated response confirming that your query has been successfully received.<br>One of our research-associate will get back to you within an hour. To send further updates on this query, please reply to this email.
							<br><br>Thanks,<br>Support<br>Japan Macro Advisors';
					$mail->Body = $msg;				
					$mail->Send();
					$mail->clearAddresses();
	    		  	$mail->clearAttachments();
					$data['result']['status'] = 4001;
					$data['result']['message'] = $msg;
					$data['result']['status'] = 4001;
					$data['result']['message'] = 'Hi '.Session::get('user.fname').' '.Session::get('user.lname').', <br><br>Thank you for sending your query.Your query has been successfully received.<br>One of our research-associate will get back to you within an hour.<br><br>Thanks,<br>Support<br>Japan Macro Advisors';
				}else {
					$mail->SetFrom('info@japanmacroadvisors.com', 'JMA Info');
					$mail->AddReplyTo('support@japanmacroadvisors.com', 'JMA Support');
					$mail->Subject = 'Thank you.';
					$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
					$mail->WordWrap = 50;
	  			  	$mail->AddAddress(Session::get('user.email'),Session::get('user.fname').' '.Session::get('user.lname'));
					$msg = 'Dear '.Session::get('user.fname').' '.Session::get('user.lname').', <br><br>Thank you for sending your query.This is an automated response confirming that your query has been successfully received.<br>We operate Mon-Fri: from 8:00am to 9:00pm JST. We will get back to you during our working hours. To send further updates on this query, please reply to this email.
							<br><br>Thanks,<br>Support<br>Japan Macro Advisors';
					$mail->Body = $msg;				
					$mail->Send();
					$mail->clearAddresses();
	    		  	$mail->clearAttachments();
					$data['result']['status'] = 4001;
					$data['result']['message'] = 'Hi '.Session::get('user.fname').' '.Session::get('user.lname').', <br><br>Thank you for sending your query.Your query has been successfully received.<br>We operate Mon-Fri: from 8:00am to 9:00pm JST. We will get back to you during our working hours. <br><br>Thanks,<br>Support<br>Japan Macro Advisors';
				}
			}
		}
		return view('helpdesk.post',$data);
	}

	public function videos() {
		$this->pageTitle = "Welcome to Japan macro advisors - Videos";
		$this->renderResultSet['meta']['description']='Japan macro advisors - Videos';
		$this->renderResultSet['meta']['keywords']='japan macroadvisors, japan, Videos';
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
}


?>