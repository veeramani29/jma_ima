<?php
if ( ! defined('SERVER_ROOT')) exit('No direct script access allowed');
class HelpdeskController extends AlaneeController {
	public $classes = array('alanee_classes/access_management/acl_class.php','alanee_classes/common/alaneecommon_class.php','alanee_classes/mailer/class.phpmailer.php','alanee_classes/common/navigation_class.php');
	public function index() {
		$this->pageTitle = "Welcome to Japan macro advisors - Helpdesk";
		$this->renderResultSet['meta']['description']='Japan macro advisors - Helpdesk';
		$this->renderResultSet['meta']['keywords']='japan macroadvisors, japan, Helpdesk';
	}

	public function post() {
		$support_timeStart = mktime(8,0,0,date('n'),date('j'),date('Y'));
		$support_timeEnd = mktime(16,30,0,date('n'),date('j'),date('Y'));
		$this->pageTitle = "Welcome to Japan macro advisors - Helpdesk";
		$this->renderResultSet['meta']['description']='Japan macro advisors - Helpdesk';
		$this->renderResultSet['meta']['keywords']='japan macroadvisors, japan, Helpdesk';
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
		$this->renderResultSet['result']['action'] = 'post';
		if(!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
			$this->redirect('/');
		}
		if(isset($_POST['mail_body'])) {
			$mail_body = nl2br(trim($_POST['mail_body']));
			if($mail_body == '') {
				$this->renderResultSet['status'] = 3332;
				$this->renderResultSet['message'] = 'Please enter a description';
			} else {
				// sending email notification 
				  $mail = new PHPMailer();
				  $mail->IsSMTP();
				  $mail->IsHTML(true);  
				  $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
				  $mail->SetFrom('info@japanmacroadvisors.com', 'JMA Info');
				  $mail->AddReplyTo($_SESSION['user']['email']);
				  $mail->Subject = 'Helpdesk - new message from '.$_SESSION['user']['fname'].'- smid: 6543'.time();
				  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
				  $mail->WordWrap = 50;
  			  	  $mail->AddAddress('support@japanmacroadvisors.com','JMA Helpdesk');
			  	  
				$mail->Body = 'From : '.$_SESSION['user']['fname'].' '.$_SESSION['user']['lname'].'<br><br>
								Email : '.$_SESSION['user']['email'].'<br><br>'.$mail_body;
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
	  			    $mail->AddAddress($_SESSION['user']['email'],$_SESSION['user']['fname'].' '.$_SESSION['user']['lname']);
					$msg = 'Dear '.$_SESSION['user']['fname'].' '.$_SESSION['user']['lname'].', <br><br>Thank you for sending your query.This is an automated response confirming that your query has been successfully received.<br>One of our research-associate will get back to you within an hour. To send further updates on this query, please reply to this email.
							<br><br>Thanks,<br>Support<br>Japan Macro Advisors';
					$mail->Body = $msg;				
					$mail->Send();
					$mail->clearAddresses();
	    		  	$mail->clearAttachments();
					$this->renderResultSet['status'] = 4001;
					$this->renderResultSet['message'] = $msg;
					$this->renderResultSet['status'] = 4001;
					$this->renderResultSet['message'] = 'Hi '.$_SESSION['user']['fname'].' '.$_SESSION['user']['lname'].', <br><br>Thank you for sending your query.Your query has been successfully received.<br>One of our research-associate will get back to you within an hour.<br><br>Thanks,<br>Support<br>Japan Macro Advisors';
				}else {
					$mail->SetFrom('info@japanmacroadvisors.com', 'JMA Info');
					$mail->AddReplyTo('support@japanmacroadvisors.com', 'JMA Support');
					$mail->Subject = 'Thank you.';
					$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
					$mail->WordWrap = 50;
	  			  	$mail->AddAddress($_SESSION['user']['email'],$_SESSION['user']['fname'].' '.$_SESSION['user']['lname']);
					$msg = 'Dear '.$_SESSION['user']['fname'].' '.$_SESSION['user']['lname'].', <br><br>Thank you for sending your query.This is an automated response confirming that your query has been successfully received.<br>We operate Mon-Fri: from 8:00am to 9:00pm JST. We will get back to you during our working hours. To send further updates on this query, please reply to this email.
							<br><br>Thanks,<br>Support<br>Japan Macro Advisors';
					$mail->Body = $msg;				
					$mail->Send();
					$mail->clearAddresses();
	    		  	$mail->clearAttachments();
					$this->renderResultSet['status'] = 4001;
					$this->renderResultSet['message'] = 'Hi '.$_SESSION['user']['fname'].' '.$_SESSION['user']['lname'].', <br><br>Thank you for sending your query.Your query has been successfully received.<br>We operate Mon-Fri: from 8:00am to 9:00pm JST. We will get back to you during our working hours. <br><br>Thanks,<br>Support<br>Japan Macro Advisors';
				}
			}
		}
		$this->renderView();
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